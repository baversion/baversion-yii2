<?php

use yii\db\Migration;

/**
 * Class m180801_203716_add_users_columns
 */
class m180801_203716_add_users_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%users}}',
            'bio',
            $this->text()
        );

        $this->addColumn(
            '{{%users}}',
            'website',
            $this->string(50)
        );

        $this->addColumn(
            '{{%users}}',
            'twitter',
            $this->string(50)
        );

        $this->addColumn(
            '{{%users}}',
            'github',
            $this->string(50)
        );

        $this->addColumn(
            '{{%users}}',
            'linkedin',
            $this->string(50)
        );

        $this->addColumn(
            '{{%users}}',
            'stackoverflow',
            $this->string(50)
        );

        $this->addColumn(
            '{{%users}}',
            'total_reputation',
            $this->integer()->notNull()->defaultValue(0)->after('total_votes')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180801_203716_add_users_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180801_203716_add_users_columns cannot be reverted.\n";

        return false;
    }
    */
}
