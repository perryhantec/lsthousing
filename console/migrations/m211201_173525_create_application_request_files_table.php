<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application_request_files}}`.
 */
class m211201_173525_create_application_request_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application_request_files}}', [
            'id'                    => $this->primaryKey(),
            'application_id'        => $this->integer()->unsigned(),
            'user_id'               => $this->integer()->unsigned(),
            'request'               => $this->text(),
            'remarks'               => $this->text(),
            'ref_code'              => $this->string(),
            'app_status'            => $this->tinyInteger()->unsigned()->defaultValue(1),
            'created_at'            => $this->dateTime().' DEFAULT NOW()',
            'updated_at'            => $this->timestamp(),
        ]);
/*
        $this->batchInsert('{{%application_request_files}}', [
            'id',
            'application_id',
            'user_id',
            'request',
            'remarks',
            'ref_code',
            'app_status',
            'created_at',
            'updated_at',
        ], [
            array('id' => '1','application_id' => '1','user_id' => '1','request' => '["1","2","3"]','remarks' => '<p>test</p>

            <p>remarks</p>
            ','ref_code' => 'RESQ00000001','app_status' => '1','created_at' => '2021-12-03 02:20:06','updated_at' => '2021-12-03 02:23:36'),
              array('id' => '2','application_id' => '1','user_id' => '1','request' => '["3","5","6","8","11","12","14","16","24"]','remarks' => '<p><strong>gggg</strong></p>
            
            <p>&nbsp;</p>
            
            <p><strong>lllluig87g8g8</strong></p>
            ','ref_code' => 'RESQ00000002','app_status' => '1','created_at' => '2021-12-03 02:21:30','updated_at' => '2021-12-03 02:23:40')            
        ]);
*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application_request_files}}');
    }
}
