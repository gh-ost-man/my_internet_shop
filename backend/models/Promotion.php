<?php 
    namespace backend\models;

    use Yii;
    use \yii\db\ActiveRecord;

    /**
     * @property int $id
     * @property string $name
     * @property string $description
     * @property string $url_image 
     */
    class Promotion extends ActiveRecord
    {
        public static function tableName()
        {
            return 'promotions';
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