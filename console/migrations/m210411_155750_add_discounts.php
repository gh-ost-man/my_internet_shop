<?php

use yii\db\Migration;

/**
 * Class m210411_155750_add_discounts
 */
class m210411_155750_add_discounts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('discounts', [
            'name' => "Discount1", 
            'description' => "Description",
            'percent' => "25"
        ]);
        $this->insert('discounts', [
            'name' => "Discount2", 
            'description' => "Description",
            'percent' => "35"
        ]);
        $this->insert('discounts', [
            'name' => "Discount3", 
            'description' => "Description",
            'percent' => "45"
        ]);
        
        $this->insert('discounts', [
            'name' => "Discount4", 
            'description' => "Description",
            'percent' => 55
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210411_155750_add_discounts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210411_155750_add_discounts cannot be reverted.\n";

        return false;
    }
    */
}
