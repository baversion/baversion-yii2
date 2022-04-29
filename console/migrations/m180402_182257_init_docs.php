<?php

use yii\db\Migration;

/**
 * Class m180402_182257_init_docs
 */
class m180402_182257_init_docs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%docs}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->unsigned(),
            'doc_title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => $this->text(),
            'version' => $this->string(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->unsigned(),
            'parent_id' =>  $this->integer()->unsigned(),
            'deprecated' => $this->boolean()->notNull()->defaultValue(0),
            'doc_status' => "ENUM('draft', 'pending', 'schedule', 'trash', 'published') NOT NULL DEFAULT 'draft'",
        ]);

        $this->createIndex(
            'idx-docs-author_id',
            '{{%docs}}',
            'author_id'
        );

        $this->createIndex(
            'idx-docs-parent_id',
            '{{%docs}}',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-docs-author_id',
            '{{%docs}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-docs-parent_id',
            '{{%docs}}',
            'parent_id',
            '{{%docs}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%doc_meta}}', [
            'id' => $this->primaryKey()->unsigned(),
            'doc_id' => $this->integer()->unsigned(),
            'meta_key' => $this->string()->notNull(),
            'meta_value' => 'mediumtext',
        ]);

        $this->createIndex(
            'idx-doc_meta-doc_id',
            '{{%doc_meta}}',
            'doc_id'
        );

        $this->addForeignKey(
            'fk-doc_meta-doc_id',
            '{{%doc_meta}}',
            'doc_id',
            '{{%docs}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%doc_posts}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->unsigned(),
            'doc_id' => $this->integer()->notNull()->unsigned(),
            'post_title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => $this->text(),
            'src' => $this->string(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->notNull()->unsigned(),
            'parent_id' =>  $this->integer()->unsigned(),
            'post_status' => "ENUM('draft', 'pending', 'trash', 'schedule', 'published', 'deprecated') NOT NULL DEFAULT 'draft'",
        ]);

        $this->createIndex(
            'idx-doc_posts-author_id',
            '{{%doc_posts}}',
            'author_id'
        );

        $this->createIndex(
            'idx-doc_posts-doc_id',
            '{{%doc_posts}}',
            'doc_id'
        );

        $this->createIndex(
            'idx-doc_posts-parent_id',
            '{{%doc_posts}}',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-doc_posts-author_id',
            '{{%doc_posts}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-doc_posts-doc_id',
            '{{%doc_posts}}',
            'doc_id',
            '{{%docs}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-doc_posts-parent_id',
            '{{%doc_posts}}',
            'parent_id',
            '{{%doc_posts}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('{{%doc_post_meta}}', [
            'id' => $this->primaryKey()->unsigned(),
            'post_id' => $this->integer()->unsigned(),
            'meta_key' => $this->string()->notNull(),
            'meta_value' => 'mediumtext',
        ]);

        $this->createIndex(
            'idx-doc_post_meta-post_id',
            '{{%doc_post_meta}}',
            'post_id'
        );

        $this->addForeignKey(
            'fk-doc_post_meta-post_id',
            '{{%doc_post_meta}}',
            'post_id',
            '{{%doc_posts}}',
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
        echo "m180402_182257_init_docs cannot be reverted.\n";

        return false;
    }
}
