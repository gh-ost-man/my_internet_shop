<?php
namespace backend\models;

use yii\base\Model;

class TovarForm extends Model 
{
    public $name;
    public $description;
    // public $imageFile;
    public $count;
    public $category_id;
    public $price;
    public $discount_id;
    
    public function rules()
    {
        return[
            [['name', 'description'], 'string', 'message' => 'невірний тип форми'],
            [['category_id', 'discount_id', 'count'], 'integer', 'min' => 0],
            [['price'], 'double', 'min' => 0],
            [['name', 'description', 'category_id', 'count'], 'required', 'message' => 'значення обов\'язкове'],
        ]; 
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Назва товару'
        ];
    }
}