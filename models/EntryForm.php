<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Connection;
use yii\mongodb\validators;

class EntryForm extends ActiveRecord
{
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'trim'],
            ['login', 'unique', 'targetAttribute' => 'login', 'message' => 'This login has already been taken'],

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

    public function insert_user_data($login, $password)
    {
        $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
        $dsn = 'mongodb://root:tgEm8ZObfIpzXY2bNBSl@ds159121.mlab.com:59121/task';

        $connection = new Connection([
            'dsn' => $dsn,
        ]);
        $connection->open();

        $collection = $connection->getCollection(['task', 'users']);

        if($this->validate())
        {
            $collection->insert(['login' => $login, 'password' => $hash]);
        }


    }

}