<?php

use yii\db\Migration;

/**
 * Handles the creation of table `solutions`.
 */
class m181124_174658_create_solutions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%solutions}}', [
            'id' => $this->primaryKey()->unsigned(),
            'author_id' => $this->integer()->unsigned(),
            'solution_title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'problem' => $this->text(),
            'solution' => $this->text(),
            'cover_image' => $this->string(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'published_at' => $this->integer()->unsigned(),
            'solution_status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-solutions-author_id',
            '{{%articles}}',
            'author_id'
        );

        $this->addForeignKey(
            'fk-solutions-author_id',
            '{{%solutions}}',
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
        $this->dropTable('solutions');
    }
}
