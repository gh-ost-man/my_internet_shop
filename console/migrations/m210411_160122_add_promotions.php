<?php

use yii\db\Migration;

/**
 * Class m210411_160122_add_promotions
 */
class m210411_160122_add_promotions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('promotions', [
            'name' => "Promotion1", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion1.png'])
        ]);
        $this->insert('promotions', [
            'name' => "Promotion2", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion2.png'])
        ]);
        $this->insert('promotions', [
            'name' => "Promotion3", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion3.png'])
        ]);
         $this->insert('promotions', [
            'name' => "Promotion4", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion4.png'])
        ]);
        $this->insert('promotions', [
            'name' => "Promotion5", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion5.jpg'])
        ]);
        $this->insert('promotions', [
            'name' => "Promotion6", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion6.png'])
        ]);
        $this->insert('promotions', [
            'name' => "Promotion7", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion7.jpg'])
        ]);
         $this->insert('promotions', [
            'name' => "Promotion8", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion8.jpg'])
        ]);
        $this->insert('promotions', [
            'name' => "Promotion9", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion9.jpg'])
        ]);
        $this->insert('promotions', [
            'name' => "Promotion10", 
            'description' => "Description",
            'url_image' => json_encode(['../../images/promotion/Promotion10.png'])
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210411_160122_add_promotions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210411_160122_add_promotions cannot be reverted.\n";

        return false;
    }
    */
}
