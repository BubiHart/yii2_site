<?php

namespace app\models;

use yii\helpers\Security;
use yii\web\IdentityInterface;
use yii\mongodb\ActiveRecord;


class User extends ActiveRecord implements IdentityInterface
{
    //public $_id;
    //public $authKey;
    public $username;

    private static $users = [];


    public static function findIdentity($_id)
    {
        return static::findOne($_id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function collectionName()
    {
        return 'users';
    }

    public function attributes()
    {
        return ['_id', 'login', 'password'];
    }

    public static function findByLogin($login)
    {
        return self::findOne(array('login' => $login));
    }
}
