<?php

namespace backend\models;

use yii\base\Model;

class CategoryForm extends Model
{
    public $name;
    public $description;
    
    public function rules()
    {
        return [
            [['name', 'description'], 'string', 'message' => 'Невірний тип поля'],
            [['name', 'description'], 'required', 'message' => 'Значення обов\'язкове']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Назва категорії'
        ];
    }
}