<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item_order}}`.
 */
class m210410_074537_create_item_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%item_order}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'tovar_id' => $this->integer()->notNull(),
            'price' => $this->float(),
            'count' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%item_order}}');
    }
}
