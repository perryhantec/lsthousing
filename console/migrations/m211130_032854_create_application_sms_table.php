<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application_sms}}`.
 */
class m211130_032854_create_application_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application_sms}}', [
            'id'                    => $this->primaryKey(),
            'application_id'        => $this->integer()->unsigned(),
            'user_id'               => $this->integer()->unsigned(),
            'sent_at'               => $this->dateTime().' DEFAULT NOW()',
            'status'                => $this->integer()->defaultValue(1),
            'sent_response'         => $this->string(),
            'sent_reference'        => $this->string(),
            'created_at'            => $this->dateTime().' DEFAULT NOW()',
            'updated_at'            => $this->timestamp(),
            'updated_UID'           => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application_sms}}');
    }
}
