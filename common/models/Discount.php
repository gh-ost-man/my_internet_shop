<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $percent
 */
class Discount extends ActiveRecord
{
    public static function tableName()
    {
        return 'discounts';
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
