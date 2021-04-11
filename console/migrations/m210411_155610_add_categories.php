<?php

use yii\db\Migration;

/**
 * Class m210411_155610_add_categories
 */
class m210411_155610_add_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('categories', [
            'name' => "Laptops", 
            'description' => "Description"
        ]);
        $this->insert('categories', [
            'name' => "Monitors", 
            'description' => "Description"
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210411_155610_add_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210411_155610_add_categories cannot be reverted.\n";

        return false;
    }
    */
}
