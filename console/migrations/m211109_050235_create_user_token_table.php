<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_token}}`.
 */
class m211109_050235_create_user_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_token}}', [
            'id'                     => $this->primaryKey(),
            'user_id'                => $this->integer()->notNull(),
            'token'                  => $this->char(64)->notNull(),
            'timestamp'              => $this->timestamp(),
            'device_os'              => $this->string(),
            'device_uuid'            => $this->string(),
            'device_version'         => $this->string(),
            'device_token'           => $this->string(),
            'created_at'             => $this->integer(),
            'updated_at'             => $this->integer(),
            'updated_UID'            => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_token}}');
    }
}
