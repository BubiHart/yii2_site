<?php

namespace app\controllers;

use app\models\ChangeUserData;
use app\models\UpdateForm;
use app\models\UpdateUser;
use Yii;
use yii\filters\AccessControl;
use app\models\Users;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UpdateData;
use app\models\ContactForm;
use app\models\EntryForm;
use yii\data\Pagination;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->insert_user_data($model->login, $model->password);
            return $this->redirect(['site/index']);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionUsers()
    {
        if (Yii::$app->user->isGuest) {
            return $this->actionLogin();
        }

        $query = Users::find();

        $pagination = new Pagination([
            'defaultPageSize' => 25,
            'totalCount' => $query->count(),
        ]);

        $users = $query->orderBy('_id')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('users', [
            'users' => $users,
            'pagination' => $pagination,
        ]);

    }

    public function actionUpdate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->actionLogin();
        }

        $model = new UpdateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->update_user_data();

            return $this->redirect(['site/index']);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('update', ['model' => $model]);
        }
    }

}
