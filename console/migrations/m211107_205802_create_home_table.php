<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home}}`.
 */
class m211107_205802_create_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home}}', [
            'id'                     => $this->primaryKey(),
            'content_tw'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_cn'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_en'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'top_youtube'            => $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'),
            'status'                 => $this->integer()->defaultValue(1),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer(),
        ]);

        $this->batchInsert('{{%home}}', [
            'id',
            'content_tw',
            'content_cn',
            'content_en',
            'top_youtube',
            'status',
            'created_at',
            'updated_at',
            'updated_UID'
        ], [
            array('id' => '1','content_tw' => '','content_cn' => NULL,'content_en' => '','top_youtube' => '[{"id":"laSfj3TXpeA","title":"「樂屋」 - 宋皇臺道及土瓜灣道交界組合屋項目"},{"id":"KAi5H4n_T74","title":"「樂屋」 - 宋皇臺道及土瓜灣道交界組合屋項目 (建造篇)"},{"id":"cZiOn5szcco","title":"「樂屋」改建樂善堂小學項目"},{"id":"O41Ysq552ZM","title":"大埔樂善村"}]','status' => '1','created_at' => '2021-11-09 17:25:33','updated_at' => '2021-11-09 17:25:33','updated_UID' => '1')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home}}');
    }
}
