<?php

use yii\db\Migration;

/**
 * Class m180729_203140_init_terminology
 */
class m180729_203140_init_terminology extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%terminology}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->unsigned(),
            'term_title' => $this->string()->notNull(),
            'term_slug' => $this->string()->unique(),
            'term_content' => $this->text(),
            'term_initial' => $this->string(2),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->unsigned(),
            'last_editor' => $this->integer()->unsigned(),
            'lock_to' => $this->integer()->unsigned(),
            'meta_keywords' => $this->string(),
            'meta_description' => $this->text(),
            'term_status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-terminology-author_id',
            'terminology',
            'author_id'
        );

        $this->createIndex(
            'idx-terminology-last_editor',
            'terminology',
            'last_editor'
        );

        $this->createIndex(
            'idx-terminology-lock_to',
            'terminology',
            'lock_to'
        );

        $this->addForeignKey(
            'fk-terminology-author_id',
            'terminology',
            'author_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-terminology-last_editor',
            'terminology',
            'last_editor',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-terminology-lock_to',
            'terminology',
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
        echo "m180729_203140_init_terminology cannot be reverted.\n";

        return false;
    }
}
