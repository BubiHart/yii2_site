<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Users extends ActiveRecord
{
    public static function collectionName()
    {
        return ['task', 'users'];
    }

    public function attributes()
    {
        return ['_id', 'login', 'password'];
    }

}
