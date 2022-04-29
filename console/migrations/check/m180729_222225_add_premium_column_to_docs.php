<?php

use yii\db\Migration;

/**
 * Class m180729_222225_add_premium_column_to_docs
 */
class m180729_222225_add_premium_column_to_docs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%docs}}',
            'premium',
            $this->integer()->notNull()->defaultValue(0)->after('lock_to')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180729_222225_add_premium_column_to_docs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180729_222225_add_premium_column_to_docs cannot be reverted.\n";

        return false;
    }
    */
}
