<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_type11}}`.
 */
class m211115_232814_create_page_type11_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_type11}}', [
            'id'                     => $this->primaryKey(),
            'MID'                    => $this->integer()->unsigned(),
            'display_at'             => $this->date()->notNull(),
            'author'                 => $this->string(),
            // 'category_id'            => $this->integer()->unsigned(),
            'title_tw'               => $this->string(),
            'title_cn'               => $this->string(),
            'title_en'               => $this->string(),
            'summary_tw'             => $this->text(),
            'summary_cn'             => $this->text(),
            'summary_en'             => $this->text(),
            'content_tw'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_cn'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_en'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'housing_status'         => $this->tinyInteger(),
            'expect_apply_date'      => $this->string(),
            'expect_live_date'       => $this->string(),
            'number_of_housing'      => $this->integer(),
            'youtube_id'             => $this->string(),
            'image_file_name'        => $this->text(),
            'file_names'             => $this->text(),
            'file_names_backup'      => $this->text(),
            'view_counter'           => $this->integer(10)->unsigned()->defaultValue(0),
            'status'                 => $this->tinyInteger()->defaultValue(1),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer(),
        ]);

        $this->batchInsert('{{%page_type11}}', [
            'id',
            'MID',
            'display_at',
            'author',
            'title_tw',
            'title_cn',
            'title_en',
            'summary_tw',
            'summary_cn',
            'summary_en',
            'content_tw',
            'content_cn',
            'content_en',
            'housing_status',
            'expect_apply_date',
            'expect_live_date',
            'number_of_housing',
            'youtube_id',
            'image_file_name',
            'file_names',
            'file_names_backup',
            'view_counter',
            'status',
            'created_at',
            'updated_at',
            'updated_UID',
        ], [
            array('id' => '1','MID' => '2','display_at' => '2021-11-16','author' => NULL,'title_tw' => '荃灣前信義學校改裝作過渡性社會房屋項目','title_cn' => '','title_en' => '','summary_tw' => '荃灣前信義學校改裝作過渡性社會房屋','summary_cn' => NULL,'summary_en' => '','content_tw' => '<p><iframe frameborder="0" height="315" scrolling="no" src="https://www.youtube.com/embed/rERB0srFF8M" width="560"></iframe></p>
                ','content_cn' => NULL,'content_en' => '','housing_status' => '3','expect_apply_date' => '2021年11月中','expect_live_date' => '2022年3月','number_of_housing' => '145','youtube_id' => 'rERB0srFF8M','image_file_name' => NULL,'file_names' => '{"IrsWB593x4rwXSwT2qLqy7Lle3dESEBb_1637026057.jpg":"TWschool 01","nORcR7FOdit5GOT4Nyg5xhMjxrKyRmKC_1637026057.jpg":"TWschool 02"}','file_names_backup' => NULL,'view_counter' => '0','status' => '1','created_at' => '2021-11-16 12:37:39','updated_at' => '2021-11-16 12:37:39','updated_UID' => '1'),
            array('id' => '2','MID' => '2','display_at' => '2021-11-15','author' => NULL,'title_tw' => '大埔黃魚灘組合式過渡性社會房屋','title_cn' => '','title_en' => '','summary_tw' => '大埔黃魚灘組合式過渡性社會房屋 (由會德豐免費借出土地)','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','housing_status' => '1','expect_apply_date' => '待確定','expect_live_date' => '待確定','number_of_housing' => '1236','youtube_id' => NULL,'image_file_name' => NULL,'file_names' => '{"7XCaKnrHNVo_bgYro-3a2_D1AdpiEuog_1637031321.png":"TaiPo 01.jpg"}','file_names_backup' => NULL,'view_counter' => '0','status' => '1','created_at' => '2021-11-16 10:55:54','updated_at' => '2021-11-16 10:55:54','updated_UID' => '1'),
            array('id' => '3','MID' => '2','display_at' => '2021-11-14','author' => NULL,'title_tw' => '彩虹彩興路組合式過渡性社會房屋','title_cn' => '','title_en' => '','summary_tw' => '彩虹彩興路組合式過渡性社會房屋','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','housing_status' => '1','expect_apply_date' => '待確定','expect_live_date' => '待確定','number_of_housing' => '166','youtube_id' => NULL,'image_file_name' => NULL,'file_names' => '{"qx5J5sFtuqieqlSoQFfoiwOWxThL7lb1_1637031470.jpg":"Choi Hing 01","9442GUrNs7knx3lo9MxOK6FA4UzQda_r_1637031470.jpg":"Choi Hing 02"}','file_names_backup' => NULL,'view_counter' => '0','status' => '1','created_at' => '2021-11-16 10:57:50','updated_at' => '2021-11-16 10:57:50','updated_UID' => '1')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_type11}}');
    }
}
