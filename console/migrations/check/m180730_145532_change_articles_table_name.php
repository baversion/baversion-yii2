<?php

use yii\db\Migration;

/**
 * Class m180730_145532_change_articles_table_name
 */
class m180730_145532_change_articles_table_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%articles}}', '{{%blog}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180730_145532_change_articles_table_name cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180730_145532_change_articles_table_name cannot be reverted.\n";

        return false;
    }
    */
}
