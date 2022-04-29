<?php

use yii\db\Migration;

/**
 * Class m180729_220554_init_notifications
 */
class m180729_220554_init_notifications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notifications}}',[
            'id' => $this->primaryKey()->unsigned(),
            'notification_title' => $this->string()->notNull(),
            'slug_code' => $this->string()->unique(),
            'summary' => $this->string()->notNull(),
            'content' => $this->text(),
            'notification_type' => $this->string(15)->notNull(),
            'created_at' => $this->integer()->notNull()->unsigned(),
        ]);

        $this->createTable('{{%notification_user}}',[
            'notification_id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'seen_at' => $this->integer()->notNull()->unsigned(),
            'seen' => $this->boolean()->notNull()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-notification_user-notification_id',
            '{{%notification_user}}',
            'notification_id'
        );

        $this->createIndex(
            'idx-notification_user-user_id',
            '{{%notification_user}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-notification_user-notification_id',
            '{{%notification_user}}',
            'notification_id',
            '{{%notifications}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-notification_user-user_id',
            '{{%notification_user}}',
            'user_id',
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
        echo "m180729_220554_init_notifications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180729_220554_init_notifications cannot be reverted.\n";

        return false;
    }
    */
}
