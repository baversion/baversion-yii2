<?php

use yii\db\Migration;

/**
 * Class m180417_162458_init_helps
 */
class m180417_162458_init_helps extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%help_topics}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->notNull()->unsigned(),
            'topic_title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->unsigned(),
        ]);

        $this->createIndex(
            'idx-help_topics-author_id',
            '{{%help_topics}}',
            'author_id'
        );

        $this->addForeignKey(
            'fk-help_topics-author_id',
            '{{%help_topics}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%help_posts}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->notNull()->unsigned(),
            'topic_id' => $this->integer()->unsigned(),
            'post_title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => 'mediumtext',
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->unsigned(),
            'help_status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-help_posts-user_id',
            '{{%help_posts}}',
            'author_id'
        );

        $this->createIndex(
            'idx-help_posts-topic_id',
            '{{%help_posts}}',
            'topic_id'
        );

        $this->addForeignKey(
            'fk-help_posts-author_id',
            '{{%help_posts}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-help_posts-topic_id',
            '{{%help_posts}}',
            'topic_id',
            '{{%help_topics}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%help_post_meta}}', [
            'id' => $this->primaryKey()->unsigned(),
            'post_id' => $this->integer()->unsigned(),
            'meta_key' => $this->string()->notNull(),
            'meta_value' => 'mediumtext',
        ]);

        $this->createIndex(
            'idx-help_post_meta-post_id',
            '{{%help_post_meta}}',
            'post_id'
        );

        $this->addForeignKey(
            'fk-help_post_meta-post_id',
            '{{%help_post_meta}}',
            'post_id',
            '{{%help_posts}}',
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
        echo "m180417_162458_init_helps cannot be reverted.\n";

        return false;
    }
}
