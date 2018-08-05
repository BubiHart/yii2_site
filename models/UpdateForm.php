<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Connection;
use yii\mongodb\validators;

class UpdateForm extends ActiveRecord
{
    public $new_login;
    public $new_password;

    public function rules()
    {
        return [
            [['login', 'password'], 'trim'],
            [['new_login', 'new_password'], 'validate_form', 'skipOnEmpty' => false],
            ['new_login', 'unique', 'targetAttribute' => 'login', 'message' => 'This login has already been taken'],

            //['login', 'validateLogin', 'skipOnEmpty' => false],
            /*

            [['login', 'password'], 'required'],

            */
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



    public function validate_form($attribute, $params)
    {
        if (empty($this->new_login) && empty($this->new_password))
        {
            $this->addError($attribute, 'You must fill in at least one field');
        }
    }

    public function update_user_data()
    {
        $old_login = Yii::$app->user->identity->login;
        $new_password_hash = Yii::$app->security->generatePasswordHash($this->new_password);

        if(!empty($this->new_login) && !empty($this->new_password))
        {
            self::updateAll(array('login' => $this->new_login, 'password' => $new_password_hash), array('login' => $old_login));
            Yii::$app->user->identity->login = $this->new_login;
        }

        if(!empty($this->new_login) && empty($this->new_password))
        {
            self::updateAll(array('login' => $this->new_login), array('login' => $old_login));
            Yii::$app->user->identity->login = $this->new_login;
        }

        if(empty($this->new_login) && !empty($this->new_password))
        {
            self::updateAll(array('password' => $new_password_hash), array('login' => $old_login));
        }

    }



}