<?php

use yii\db\Migration;

/**
 * Handles the creation of table `revisions`.
 */
class m180729_222617_create_revisions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('revisions', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->unsigned()->notNull(),
            'object_type' => $this->string(20)->notNull(),
            'object_id' => $this->integer()->unsigned()->notNull(),
            'revition_title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => 'mediumtext',
            'extra_fields' => $this->binary(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'revision_at' => $this->integer()->notNull()->unsigned(),
            'author_ip' => $this->integer()->unsigned()->notNull(),
            'revision_status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-revisions-author_id',
            '{{%revisions}}',
            'author_id'
        );

        $this->addForeignKey(
            'fk-revisions-author_id',
            '{{%revisions}}',
            'author_id',
            '{{%users}}',
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
        $this->dropTable('revisions');
    }
}
