<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->unsigned(),
            'first_name' => $this->string(20)->notNull(),
            'last_name' => $this->string(20),
            'username' => $this->string(25)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'email_auth_key' => $this->string()->unique(),
            'points' => $this->integer()->notNull()->defaultValue(0),
            'image' => $this->string(),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
        ], $tableOptions);

        $this->createTable('{{%user_meta}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'meta_key' => $this->string()->notNull(),
            'meta_value' => 'mediumtext',
        ]);

        $this->createIndex(
            'idx-user_meta-user_id',
            '{{%user_meta}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_meta-user_id',
            '{{%user_meta}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-user_properties-user_id',
            '{{%user_properties}}'
        );
        $this->dropIndex(
            'idx-user_properties-user_id',
            '{{%user_properties}}'
        );

        $this->dropTable('{{%user_properties}}');

        $this->dropTable('{{%users}}');
    }
}
