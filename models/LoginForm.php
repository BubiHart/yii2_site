<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Connection;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends ActiveRecord
{
    public $login;
    public $password;
    public $id;

    private $password_hash;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // login and password are both required
            [['login', 'password'], 'trim'],
            [['login', 'password'], 'required'],
            ['login', 'exist', 'targetAttribute' => 'login', 'message' => 'No user with such a login'],
            ['password', 'validatePassword'],

        ];
    }

    public static function collectionName()
    {
        return ['task', 'users'];
    }

    public function attributes()
    {
        return ['_id', 'login', 'password'];
    }


    public function login()
    {
        if($this->validate())
        {
            //$id = User::get
            $user = User::findByLogin($this->login);
            //$user = User::findIdentity()
            /*
            var_dump($user);
            die;
            */
            return Yii::$app->user->login($user);
        }

        return false;
    }

    public function validatePassword($attribute, $params)
    {
        self::get_user_pass();


        if(!empty($this->password_hash) && $this->password_hash != null)
        {
            if(!Yii::$app->security->validatePassword($this->password, $this->password_hash))
            {
                $this->addError($attribute, "Password is incorrect");
            }
        }

    }

    public function get_user_pass()
    {
        $dsn = 'mongodb://root:tgEm8ZObfIpzXY2bNBSl@ds159121.mlab.com:59121/task';

        $connection = new Connection([
            'dsn' => $dsn,
        ]);

        $connection->open();
        $collection = $connection->getCollection(['task', 'users']);

        $user_pass = $collection->findOne(array('login' => $this->login));
        $this->password_hash = $user_pass['password'];
    }


}
