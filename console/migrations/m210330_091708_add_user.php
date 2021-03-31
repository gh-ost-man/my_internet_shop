<?php

use yii\db\Migration;

/**
 * Class m210330_091708_add_user
 */
class m210330_091708_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('user');
        $auth->assign($userRole, 2);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210330_091708_add_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210330_091708_add_user cannot be reverted.\n";

        return false;
    }
    */
}
