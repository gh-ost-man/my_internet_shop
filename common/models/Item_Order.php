<?php 
    namespace common\models;

    use Yii;
    use \yii\db\ActiveRecord;

    /**
     * 
     * @property int $id
     * @property int $order_id
     * @property int $tovar_id
     * @property float $price
     * @property int $count
     * 
     */
    class Item_Order extends ActiveRecord
    {
        public static function tableName()
        {
            return 'item_order';
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