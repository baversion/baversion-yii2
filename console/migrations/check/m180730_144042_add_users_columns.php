<?php

use yii\db\Migration;

/**
 * Class m180730_144042_add_users_columns
 */
class m180730_144042_add_users_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn(
            '{{%users}}',
            'email_auth_key',
            'email_verification_code'
        );

        $this->addColumn(
            '{{%users}}',
            'email_verified',
            $this->integer()->notNull()->defaultValue(0)->after('email_verify_token')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180730_144042_add_users_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180730_144042_add_users_columns cannot be reverted.\n";

        return false;
    }
    */
}
