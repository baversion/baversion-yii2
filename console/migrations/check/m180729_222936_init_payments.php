<?php

use yii\db\Migration;

/**
 * Class m180729_222936_init_payments
 */
class m180729_222936_init_payments extends Migration
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
    public function safeDown()
    {
        echo "m180729_222936_init_payments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180729_222936_init_payments cannot be reverted.\n";

        return false;
    }
    */
}
