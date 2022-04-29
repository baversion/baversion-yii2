<?php

use yii\db\Migration;

/**
 * Class m180423_175538_init_images
 */
class m180423_175538_init_images extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey()->unsigned(),
            'image_name' => $this->string(128)->unique()->notNull(),
            'image_hash' => $this->string(32)->notNull(),
            'original_name' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull()->unsigned(),
            'created_at' => $this->integer()->notNull()->unsigned(),
        ]);

        $this->createIndex(
            'idx-images-user_id',
            '{{%images}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-images-user_id',
            '{{%images}}',
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
        echo "m180423_175538_init_images cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180423_175538_init_images cannot be reverted.\n";

        return false;
    }
    */
}
