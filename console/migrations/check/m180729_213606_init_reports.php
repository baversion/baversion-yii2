<?php

use yii\db\Migration;

/**
 * Class m180729_213606_init_reports
 */
class m180729_213606_init_reports extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reports}}', [
            'id' => $this->primaryKey()->unsigned(),
            'object_type' => $this->string(20)->notNull(),
            'object_id' => $this->integer()->unsigned()->notNull(),
            'reporter_id' => $this->integer()->unsigned()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'reporter_ip' => $this->integer()->unsigned()->notNull(),
            'report_reason' => $this->tinyInteger()->notNull()->defaultValue(1),
            'report_status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-reports-reporter_id',
            '{{%reports}}',
            'reporter_id'
        );

        $this->addForeignKey(
            'fk-reports-reporter_id',
            '{{%reports}}',
            'reporter_id',
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
        echo "m180729_213606_init_reports cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180729_213606_init_reports cannot be reverted.\n";

        return false;
    }
    */
}
