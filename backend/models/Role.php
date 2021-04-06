<?php

namespace backend\models;

use Yii;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $percent
 */
class Role extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_item';
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [];
    }
}
