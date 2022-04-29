<?php

use yii\db\Migration;

/**
 * Class m180730_153952_add_src_blog
 */
class m180730_153952_add_src_blog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%blog}}',
            'sources',
            $this->binary()->after('featured')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180730_153952_add_src_blog cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180730_153952_add_src_blog cannot be reverted.\n";

        return false;
    }
    */
}
