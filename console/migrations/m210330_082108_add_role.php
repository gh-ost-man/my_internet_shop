<?php

use yii\db\Migration;

/**
 * Class m210330_082108_add_role
 */
class m210330_082108_add_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() // коли міграція виконується
    {
        $auth = Yii::$app->authManager;
        $auth->add($auth->createRole('admin'));
        $auth->add($auth->createRole('user'));
        $auth->add($auth->createRole('owner'));
        $auth->add($auth->createRole('manager'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() // коли ми відміняєм нашу міграцію
    {
        echo "m210330_082108_add_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210330_082108_add_role cannot be reverted.\n";

        return false;
    }
    */
}
