<?php

use yii\db\Migration;

/**
 * Class m180729_210639_init_votes
 */
class m180729_210639_init_votes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%votes}}', [
            'voter_id' => $this->integer()->unsigned()->notNull(),
            'object_type' => $this->string(20)->notNull(),
            'object_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'voter_ip' => $this->integer()->unsigned()->notNull(),
            'vote' =>  $this->boolean()->notNull()->defaultValue(1),
        ]);

        $this->addPrimaryKey(
            'pk-votes',
            '{{%votes}}',
            [
                'voter_id',
                'object_type',
                'object_id'
            ]
        );

        $this->createIndex(
            'idx-votes-voter_id',
            '{{%votes}}',
            'voter_id'
        );

        $this->addForeignKey(
            'fk-votes-voter_id',
            '{{%votes}}',
            'voter_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addColumn(
            '{{%users}}',
            'total_votes',
            $this->integer()->notNull()->defaultValue(0)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180729_210639_init_votes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180729_210639_init_votes cannot be reverted.\n";

        return false;
    }
    */
}
