<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
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
