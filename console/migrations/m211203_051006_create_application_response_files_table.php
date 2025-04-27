<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application_response_files}}`.
 */
class m211203_051006_create_application_response_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application_response_files}}', [
            'id'                    => $this->primaryKey(),
            'application_id'        => $this->integer()->unsigned(),
            'user_id'               => $this->integer()->unsigned(),
            'request_id'            => $this->integer()->unsigned(),
            'response'              => $this->text(),
            'response_result'       => $this->text(),
            'created_at'            => $this->dateTime().' DEFAULT NOW()',
            'updated_at'            => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application_response_files}}');
    }
}
