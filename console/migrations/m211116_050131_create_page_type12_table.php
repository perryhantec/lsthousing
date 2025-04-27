<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_type12}}`.
 */
class m211116_050131_create_page_type12_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_type12}}', [
            'id'                        => $this->primaryKey(),
            'MID'                       => $this->integer()->unsigned(),
            'display_at'                => $this->date()->notNull(),
            'author'                    => $this->string(),
            // 'category_id'               => $this->integer()->unsigned(),
            'title_tw'                  => $this->string(),
            'title_cn'                  => $this->string(),
            'title_en'                  => $this->string(),
            'summary_tw'                => $this->text(),
            'summary_cn'                => $this->text(),
            'summary_en'                => $this->text(),
            'content_tw'                => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_cn'                => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_en'                => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'poster_file_name'          => $this->text(),
            'district_id'               => $this->integer()->unsigned(),
            'housing_location'          => $this->string(),
            'housing_rent'              => $this->string(),
            'avl_no_of_people_min'      => $this->integer()->unsigned()->defaultValue(0),
            'avl_no_of_people_max'      => $this->integer()->unsigned()->defaultValue(0),
            'avl_no_of_application'     => $this->integer()->unsigned()->defaultValue(0),
            'avl_no_of_live_year'       => $this->integer()->unsigned()->defaultValue(0),
            'remarks'                   => $this->text(),
            'youtube_id'                => $this->string(),
            'image_file_name'           => $this->text(),
            'file_names'                => $this->text(),
            'file_names_backup'         => $this->text(),
            'view_counter'              => $this->integer(10)->unsigned()->defaultValue(0),

            // 'apply_date'                => $this->string(),
            // 'close_apply_date'          => $this->string(),

            'is_open'                   => $this->tinyInteger()->defaultValue(1),
            'status'                    => $this->tinyInteger()->defaultValue(1),
            'created_at'                => $this->dateTime().' DEFAULT NOW()',
            'updated_at'                => $this->timestamp(),
            'updated_UID'               => $this->integer(),
        ]);

        $this->batchInsert('{{%page_type12}}', [
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
            'poster_file_name',
            'district_id',
            'housing_location',
            'housing_rent',
            'avl_no_of_people_min',
            'avl_no_of_people_max',
            'avl_no_of_application',
            'avl_no_of_live_year',
            'remarks',
            'youtube_id',
            'image_file_name',
            'file_names',
            'file_names_backup',
            'view_counter',
            // 'apply_date',
            // 'close_apply_date',
            'is_open',
            'status',
            'created_at',
            'updated_at',
            'updated_UID',
        ], [
            // array('id' => '1','MID' => '5','display_at' => '2021-11-17','author' => NULL,'title_tw' => '九龍城落山道「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/1.jpg?1637119789','district_id' => '5','housing_location' => '九龍城落山道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '2','avl_no_of_people_max' => '4','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','apply_date' => '2021-10-01','close_apply_date' => '2021-12-31','status' => '1','created_at' => '2021-11-17 11:29:49','updated_at' => '2021-11-17 11:29:49','updated_UID' => '1'),
            // array('id' => '2','MID' => '5','display_at' => '2021-11-16','author' => NULL,'title_tw' => '旺角自由道「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/2.jpg?1637120159','district_id' => '9','housing_location' => '旺角自由道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '2','avl_no_of_people_max' => '4','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','apply_date' => '2021-12-01','close_apply_date' => '2021-12-15','status' => '1','created_at' => '2021-11-17 11:36:00','updated_at' => '2021-11-17 11:36:00','updated_UID' => '1'),
            // array('id' => '3','MID' => '5','display_at' => '2021-11-15','author' => NULL,'title_tw' => '九龍城樂善堂小學「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/3.jpg?1637120270','district_id' => '5','housing_location' => '九龍城龍崗道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '2','avl_no_of_people_max' => '5','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','apply_date' => '2021-09-01','close_apply_date' => '2021-11-15','status' => '1','created_at' => '2021-11-17 11:37:50','updated_at' => '2021-11-17 11:37:50','updated_UID' => '1'),
            // array('id' => '4','MID' => '5','display_at' => '2021-11-14','author' => NULL,'title_tw' => '土瓜灣宋皇臺「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/4.jpg?1637120333','district_id' => '5','housing_location' => '土瓜灣宋皇臺道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '1','avl_no_of_people_max' => '3','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','apply_date' => '2021-10-01','close_apply_date' => '2021-11-30','status' => '1','created_at' => '2021-11-17 11:38:54','updated_at' => '2021-11-17 11:38:54','updated_UID' => '1'),
            // array('id' => '5','MID' => '5','display_at' => '2021-11-13','author' => NULL,'title_tw' => '土瓜灣酒店式「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/5.jpg?1637120529','district_id' => '5','housing_location' => '土瓜灣炮仗街','housing_rent' => '$3,970 至 $4,370','avl_no_of_people_min' => '1','avl_no_of_people_max' => '2','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '租金已包水電煤及Wifi; 需要在共享廚房煮食','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','apply_date' => '2021-10-15','close_apply_date' => '2021-12-14','status' => '1','created_at' => '2021-11-17 11:42:10','updated_at' => '2021-11-17 11:42:10','updated_UID' => '1')
            array('id' => '1','MID' => '5','display_at' => '2021-11-17','author' => NULL,'title_tw' => '九龍城落山道「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/1.jpg?1637119789','district_id' => '5','housing_location' => '九龍城落山道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '2','avl_no_of_people_max' => '4','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','is_open' => '1','status' => '1','created_at' => '2021-11-17 11:29:49','updated_at' => '2021-11-17 11:29:49','updated_UID' => '1'),
            array('id' => '2','MID' => '5','display_at' => '2021-11-16','author' => NULL,'title_tw' => '旺角自由道「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/2.jpg?1637120159','district_id' => '9','housing_location' => '旺角自由道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '2','avl_no_of_people_max' => '4','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','is_open' => '1','status' => '1','created_at' => '2021-11-17 11:36:00','updated_at' => '2021-11-17 11:36:00','updated_UID' => '1'),
            array('id' => '3','MID' => '5','display_at' => '2021-11-15','author' => NULL,'title_tw' => '九龍城樂善堂小學「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/3.jpg?1637120270','district_id' => '5','housing_location' => '九龍城龍崗道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '2','avl_no_of_people_max' => '5','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','is_open' => '1','status' => '1','created_at' => '2021-11-17 11:37:50','updated_at' => '2021-11-17 11:37:50','updated_UID' => '1'),
            array('id' => '4','MID' => '5','display_at' => '2021-11-14','author' => NULL,'title_tw' => '土瓜灣宋皇臺「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/4.jpg?1637120333','district_id' => '5','housing_location' => '土瓜灣宋皇臺道','housing_rent' => '家庭總收入25%或綜援租金津貼','avl_no_of_people_min' => '1','avl_no_of_people_max' => '3','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','is_open' => '-1','status' => '1','created_at' => '2021-11-17 11:38:54','updated_at' => '2021-11-17 11:38:54','updated_UID' => '1'),
            array('id' => '5','MID' => '5','display_at' => '2021-11-13','author' => NULL,'title_tw' => '土瓜灣酒店式「樂屋」','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '','content_cn' => NULL,'content_en' => '','poster_file_name' => '/lsthousing/content/blog3/poster/5.jpg?1637120529','district_id' => '5','housing_location' => '土瓜灣炮仗街','housing_rent' => '$3,970 至 $4,370','avl_no_of_people_min' => '1','avl_no_of_people_max' => '2','avl_no_of_application' => '0','avl_no_of_live_year' => '0','remarks' => '租金已包水電煤及Wifi; 需要在共享廚房煮食','youtube_id' => NULL,'image_file_name' => '','file_names' => '[]','file_names_backup' => NULL,'view_counter' => '0','is_open' => '1','status' => '1','created_at' => '2021-11-17 11:42:10','updated_at' => '2021-11-17 11:42:10','updated_UID' => '1')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_type12}}');
    }
}
