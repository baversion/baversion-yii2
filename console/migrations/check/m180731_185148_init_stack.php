<?php

use yii\db\Migration;

/**
 * Class m180731_185148_init_stack
 */
class m180731_185148_init_stack extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stack_topics}}',[
            'id' => $this->primaryKey()->unsigned(),
            'topic_title' => $this->string(100)->notNull(),
            'slug' => $this->string(50)->notNull(),
            'content' => $this->text()->notNull(),
            'view_count' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'author_id' => $this->integer()->unsigned()->notNull(),
            'last_editor' => $this->integer()->unsigned(),
            'last_responder' => $this->integer()->unsigned(),
            'lock_to' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'answered_at' => $this->integer()->unsigned()->notNull(),
            'accepted' => $this->boolean()->defaultValue(0),
            'total_votes' => $this->integer()->notNull()->defaultValue(0),
            'total_likes' => $this->integer()->notNull()->defaultValue(0),
            'topic_status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-stack_topics-author_id',
            'stack_topics',
            'author_id'
        );

        $this->createIndex(
            'idx-stack_topics-last_editor',
            'stack_topics',
            'last_editor'
        );

        $this->createIndex(
            'idx-stack_topics-last_responder',
            'stack_topics',
            'last_responder'
        );

        $this->createIndex(
            'idx-stack_topics-lock_to',
            'stack_topics',
            'lock_to'
        );

        $this->addForeignKey(
            'fk-stack_topics-author_id',
            'stack_topics',
            'author_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-stack_topics-last_editor',
            'stack_topics',
            'last_editor',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-stack_topics-last_responder',
            'stack_topics',
            'last_responder',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-stack_topics-lock_to',
            'stack_topics',
            'lock_to',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%stack_answers}}',[
            'id' => $this->primaryKey()->unsigned(),
            'topic_id' => $this->integer()->unsigned()->notNull(),
            'content' => $this->text()->notNull(),
            'author_id' => $this->integer()->unsigned()->notNull(),
            'last_editor' => $this->integer()->unsigned(),
            'lock_to' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'accepted_at' => $this->integer()->unsigned(),
            'accepted' => $this->boolean()->defaultValue(0),
            'total_votes' => $this->integer()->notNull()->defaultValue(0),
            'total_likes' => $this->integer()->notNull()->defaultValue(0),
            'answer_status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-stack_answers-topic_id',
            'stack_answers',
            'topic_id'
        );

        $this->createIndex(
            'idx-stack_answers-author_id',
            'stack_answers',
            'author_id'
        );

        $this->createIndex(
            'idx-stack_answers-last_editor',
            'stack_answers',
            'last_editor'
        );

        $this->createIndex(
            'idx-stack_answers-lock_to',
            'stack_answers',
            'lock_to'
        );

        $this->addForeignKey(
            'fk-stack_answers-topic_id',
            'stack_answers',
            'topic_id',
            'stack_topics',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-stack_answers-author_id',
            'stack_answers',
            'author_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-stack_answers-last_editor',
            'stack_answers',
            'last_editor',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-stack_answers-lock_to',
            'stack_answers',
            'lock_to',
            'users',
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
        echo "m180731_185148_init_stack cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180731_185148_init_stack cannot be reverted.\n";

        return false;
    }
    */
}
