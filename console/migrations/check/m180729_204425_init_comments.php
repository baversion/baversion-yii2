<?php

use yii\db\Migration;

/**
 * Class m180729_204425_init_comments
 */
class m180729_204425_init_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->unsigned()->notNull(),
            'object_type' => $this->string(20)->notNull(),
            'object_id' => $this->integer()->unsigned()->notNull(),
            'content' => $this->text(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'author_ip' => $this->integer()->unsigned()->notNull(),
            'parent_id' => $this->integer()->unsigned()->notNull(),
            'comment_status' =>  $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-comments-author_id',
            '{{%comments}}',
            'author_id'
        );

        $this->createIndex(
            'idx-comments-parent_id',
            '{{%comments}}',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-comments-author_id',
            '{{%comments}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comments-parent_id',
            '{{%comments}}',
            'parent_id',
            '{{%comments}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180729_204425_init_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180729_204425_init_comments cannot be reverted.\n";

        return false;
    }
    */
}
