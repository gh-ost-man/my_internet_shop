<?php 
    namespace common\models;

    use Yii;
    use \yii\db\ActiveRecord;

    /**
     * 
     * @property int $id
     * @property string $name
     * @property string $description
     * @property string $url_image
     * @property int $count
     * @property float $price
     * @property int $category_id
     * @property int $discount_id
     * 
     */
    class Tovar extends ActiveRecord
    {
        public static function tableName()
        {
            return 'tovars';
        }

        public function rules()
        {
            return [];
        }

        public function attributeLabel()
        {
            return [];
        }
    }