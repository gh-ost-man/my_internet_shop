<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tovars}}`.
 */
class m210330_171547_create_tovars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tovars}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'url_image' => 'json',
            'count' => $this->integer()->defaultValue(0),
            'price' => $this->float(),
            'category_id' => $this->integer()->notNull(),
            'discount_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tovars}}');
    }
}
