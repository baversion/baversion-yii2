<?php

use yii\db\Migration;

/**
 * Class m180331_142201_init_blog
 */
class m180331_142201_init_blog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->unsigned(),
            'article_title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'excerpt' => $this->text(),
            'content' => 'mediumtext',
            'cover_image' => $this->string(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->unsigned(),
            'article_status' => "ENUM('draft', 'pending', 'schedule', 'trash', 'published') NOT NULL DEFAULT 'draft'",
        ]);

        $this->createIndex(
            'idx-articles-author_id',
            '{{%articles}}',
            'author_id'
        );

        $this->addForeignKey(
            'fk-articles-author_id',
            '{{%articles}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%article_meta}}', [
            'id' => $this->primaryKey()->unsigned(),
            'article_id' => $this->integer()->unsigned(),
            'meta_key' => $this->string()->notNull(),
            'meta_value' => 'mediumtext',
        ]);

        $this->createIndex(
            'idx-article_meta-article_id',
            '{{%article_meta}}',
            'article_id'
        );

        $this->addForeignKey(
            'fk-article_meta-article_id',
            '{{%article_meta}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('tags', [
            'id' => $this->primaryKey()->unsigned(),
            'tag_name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'excerpt' => $this->text(),
            'content' => $this->text(),
            'cover_image' => $this->string(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->unsigned(),
            'tag_status' => "ENUM('draft', 'pending', 'schedule', 'trash', 'published') NOT NULL DEFAULT 'draft'",
        ]);

        $this->createTable('{{%tag_meta}}', [
            'id' => $this->primaryKey()->unsigned(),
            'tag_id' => $this->integer()->unsigned(),
            'meta_key' => $this->string()->notNull(),
            'meta_value' => 'mediumtext',
        ]);

        $this->createIndex(
            'idx-tag_meta-tag_id',
            '{{%tag_meta}}',
            'tag_id'
        );

        $this->addForeignKey(
            'fk-tag_meta-tag_id',
            '{{%tag_meta}}',
            'tag_id',
            '{{%tags}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%article_tag_relations}}', [
            'article_id' => $this->integer()->notNull()->unsigned(),
            'tag_id' => $this->integer()->notNull()->unsigned(),
        ]);

        $this->addPrimaryKey('pk-article_tag_relations', '{{%article_tag_relations}}', ['article_id', 'tag_id']);

        $this->addForeignKey(
            'fk-article_tag_relations-article_id',
            '{{%article_tag_relations}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-article_tag_relations-tag_id',
            '{{%article_tag_relations}}',
            'tag_id',
            '{{%tags}}',
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
        echo "m180331_142201_init_blog cannot be reverted.\n";

        return false;
    }
}
