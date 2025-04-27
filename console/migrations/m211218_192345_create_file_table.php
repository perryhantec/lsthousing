<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m211218_192345_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id'         => $this->primaryKey(),
            'filename'   => $this->string(),
            'filepath'   => $this->string(),
            'auth_key'   => $this->string(),
            'status'     => $this->tinyInteger()->unsigned(),
            'created_at' => $this->dateTime().' DEFAULT NOW()',
            'created_by' => $this->string(),
            'updated_at' => $this->timestamp(),
            'updated_by' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%file}}');
    }
}
