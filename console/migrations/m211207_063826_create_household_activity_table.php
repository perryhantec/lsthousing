<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%household_activity}}`.
 */
class m211207_063826_create_household_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%household_activity}}', [
            'id'                    => $this->primaryKey(),
            'user_id'               => $this->integer()->unsigned(),
            'title'                 => $this->string(),
            'date'                  => $this->string(),
            'time'                  => $this->string(),
            'location'              => $this->string(),
            'close_date'            => $this->string(),
            'name'                  => $this->string(),
            'mobile'                => $this->string(),
            'no_of_ppl'             => $this->integer()->unsigned(),
            'remarks'               => $this->text(),
            'activity_status'       => $this->tinyInteger()->unsigned()->defaultValue(1),
            'created_at'            => $this->dateTime().' DEFAULT NOW()',
            'updated_at'            => $this->timestamp(),
        ]);
/*
        $this->batchInsert('{{%household_activity}}', [
            'id',
            'user_id',
            'title',
            'date',
            'time',
            'location',
            'close_date',
            'name',
            'mobile',
            'no_of_ppl',
            'remarks',
            'activity_status',
            'created_at',
            'updated_at',
        ], [
            array('id' => '1','user_id' => '1','title' => 'test','date' => '2021-12-08','time' => '15:00','location' => 'abc','close_date' => '2021-12-07','name' => 'name','mobile' => '12345678','no_of_ppl' => '12','remarks' => '','activity_status' => '1','created_at' => '2021-12-07 17:46:09','updated_at' => '2021-12-07 17:46:09')
        ]);
*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%household_activity}}');
    }
}
