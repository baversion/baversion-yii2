<?php

use yii\db\Migration;

/**
 * Class m181019_130700_init_payments
 */
class m181019_130700_init_payments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%users}}',
            'premium_frequency', // quantity of month
            $this->tinyInteger()->notNull()->defaultValue(0)
        );

        $this->addColumn(
            '{{%users}}',
            'expire_at', // when is the datetime of expiration of premium?
            $this->integer()->notNull()->unsigned()
        );

        $this->createTable('{{%premiums}}', [
            'id' => $this->primaryKey()->unsigned(),
            $this->tinyInteger()->unsigned()->notNull()->defaultValue(1), // the number of months
            'price' => $this->integer()->unsigned()->notNull(),
            'special' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'premium_status' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'stats' => '',
            'ip' => '',
            // other column should implement based on pay gate.
            'user_agent' => $this->string(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
            'type_name' => $this->string()->notNull(), // premium, course, ...
            'type_id' => $this->integer()->unsigned()->notNull(), // id of order_type
            'order_status' => $this->integer()->unsigned()->notNull(),
        ]);

        $this->createTable('{{%order_course_relations}}', [
            'order_id' => $this->integer()->unsigned(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181019_130700_init_payments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181019_130700_init_payments cannot be reverted.\n";

        return false;
    }
    */
}
