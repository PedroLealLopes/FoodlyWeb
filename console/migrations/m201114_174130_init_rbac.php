<?php

use yii\db\Migration;

/**
 * Class m201114_174130_init_rbac
 */
class m201114_174130_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    }

    /**
     * {@inheritdoc}
     */
    // public function safeDown()
    // {
    //     echo "m201114_174130_init_rbac cannot be reverted.\n";

    //     return false;
    // }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $cook = $auth->createRole('cook');
        $auth->add($cook);

        $user = $auth->createRole('user');
        $auth->add($user);

        $auth->assign($admin, 1);
        $auth->assign($cook, 2);
        $auth->assign($user, 3);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
