<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m210519_103207_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id'                     => $this->primaryKey(),
            'MID'                    => $this->integer()->unsigned(),
            'seq'                    => $this->integer(),
            'home_seq'               => $this->integer(),
            'url'                    => $this->string()->notNull(),
            'name_tw'                => $this->string(),
            'name_cn'                => $this->string(),
            'name_en'                => $this->string(),
            'page_type'              => $this->integer(),
            'link'                   => $this->text(),
            'link_target'            => $this->integer(1)->defaultValue(0),
            'banner_image_file_name' => $this->string(),
            'icon_file_name'         => $this->string(),
            'display_home'           => $this->integer()->defaultValue(0),
            'status'                 => $this->integer()->defaultValue(1),
            'show_after_login'       => $this->integer()->defaultValue(0),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer(),
        ]);

        $this->batchInsert('{{%menu}}', [
            'id',
            'MID',
            'seq',
            'home_seq',
            'url',
            'name_tw',
            'name_cn',
            'name_en',
            'page_type',
            'link',
            'link_target',
            'banner_image_file_name',
            'icon_file_name',
            'display_home',
            'status',
            'show_after_login',
            'created_at',
            'updated_at',
            'updated_UID'
        ], [
            array('id' => '1','MID' => NULL,'seq' => NULL,'home_seq' => '0','url' => 'latest-news','name_tw' => '最新消息','name_cn' => NULL,'name_en' => 'Latest News','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '1','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:56','updated_at' => '2021-11-07 15:40:56','updated_UID' => '1'),
            //array('id' => '2','MID' => '1','seq' => '0','home_seq' => NULL,'url' => 'lst-housing-new-project','name_tw' => '樂屋新建案','name_cn' => NULL,'name_en' => 'LST Housing New Project','page_type' => '11','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 09:02:43','updated_at' => '2021-11-07 09:02:43','updated_UID' => '1'),
            array('id' => '2','MID' => '1','seq' => '0','home_seq' => NULL,'url' => 'lst-housing-new-project','name_tw' => '樂屋新項目','name_cn' => NULL,'name_en' => 'LST Housing New Project','page_type' => '0','link' => 'lst-housing-new-project','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 09:02:43','updated_at' => '2021-11-07 09:02:43','updated_UID' => '1'),
            array('id' => '3','MID' => '1','seq' => '1','home_seq' => NULL,'url' => 'press-release','name_tw' => '新聞發布','name_cn' => NULL,'name_en' => 'Press Release','page_type' => '4','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 09:04:05','updated_at' => '2021-11-07 09:04:05','updated_UID' => '1'),
            array('id' => '4','MID' => NULL,'seq' => NULL,'home_seq' => '1','url' => 'housing-application','name_tw' => '申請樂屋','name_cn' => NULL,'name_en' => 'Housing Application','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '1','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:56','updated_at' => '2021-11-07 15:40:56','updated_UID' => '1'),
            //array('id' => '5','MID' => '4','seq' => '0','home_seq' => NULL,'url' => 'lst-housing-project','name_tw' => '樂屋項目','name_cn' => NULL,'name_en' => 'LST Housing Project','page_type' => '12','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:19','updated_at' => '2021-11-07 15:40:19','updated_UID' => '1'),
            array('id' => '5','MID' => '4','seq' => '0','home_seq' => NULL,'url' => 'lst-housing-project','name_tw' => '樂屋項目','name_cn' => NULL,'name_en' => 'LST Housing Project','page_type' => '0','link' => 'lst-housing-project','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:19','updated_at' => '2021-11-07 15:40:19','updated_UID' => '1'),
            array('id' => '6','MID' => '4','seq' => '1','home_seq' => NULL,'url' => 'application','name_tw' => '申請','name_cn' => NULL,'name_en' => 'Application','page_type' => '0','link' => 'application','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:19','updated_at' => '2021-11-07 15:40:19','updated_UID' => '1'),
            array('id' => '7','MID' => '4','seq' => '2','home_seq' => NULL,'url' => 'faqs','name_tw' => 'FAQs','name_cn' => NULL,'name_en' => 'FAQs','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:19','updated_at' => '2021-11-07 15:40:19','updated_UID' => '1'),
            array('id' => '8','MID' => NULL,'seq' => NULL,'home_seq' => '2','url' => 'household-information','name_tw' => '劏房戶資訊','name_cn' => NULL,'name_en' => 'Household Information','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '1','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:56','updated_at' => '2021-11-07 15:40:56','updated_UID' => '1'),
            array('id' => '9','MID' => '8','seq' => '0','home_seq' => NULL,'url' => 'housing-rental-control','name_tw' => '劏房租務管制','name_cn' => NULL,'name_en' => 'Housing Rental Control','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:22','updated_at' => '2021-11-07 15:40:22','updated_UID' => '1'),
            array('id' => '10','MID' => '8','seq' => '1','home_seq' => NULL,'url' => 'useful-information','name_tw' => '實用資訊','name_cn' => NULL,'name_en' => 'Useful Information','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:22','updated_at' => '2021-11-07 15:40:22','updated_UID' => '1'),
            array('id' => '11','MID' => NULL,'seq' => NULL,'home_seq' => '3','url' => 'lst-housing-story','name_tw' => '樂屋故事','name_cn' => NULL,'name_en' => 'LST Housing Story','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '1','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:56','updated_at' => '2021-11-07 15:40:56','updated_UID' => '1'),
            array('id' => '12','MID' => '11','seq' => '0','home_seq' => NULL,'url' => 'story','name_tw' => '樂屋故事','name_cn' => NULL,'name_en' => 'Story','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:26','updated_at' => '2021-11-07 15:40:26','updated_UID' => '1'),
            array('id' => '13','MID' => '11','seq' => '1','home_seq' => NULL,'url' => 'about-us','name_tw' => '關於樂屋','name_cn' => NULL,'name_en' => 'About LST Housing','page_type' => '0','link' => 'about-us','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '0','created_at' => '2021-11-07 15:40:26','updated_at' => '2021-11-07 15:40:26','updated_UID' => '1'),
            array('id' => '14','MID' => NULL,'seq' => NULL,'home_seq' => '4','url' => 'lst-housing-household','name_tw' => '樂屋住戶','name_cn' => NULL,'name_en' => 'LST Housing Household','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '1','status' => '1','show_after_login' => '1','created_at' => '2021-11-07 15:40:56','updated_at' => '2021-11-07 15:40:56','updated_UID' => '1'),
            array('id' => '15','MID' => '14','seq' => '0','home_seq' => NULL,'url' => 'household-regulations','name_tw' => '住戶守則','name_cn' => NULL,'name_en' => 'Household Regulations','page_type' => '1','link' => '','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '1','created_at' => '2021-11-07 15:40:29','updated_at' => '2021-11-07 15:40:29','updated_UID' => '1'),
            array('id' => '16','MID' => '14','seq' => '1','home_seq' => NULL,'url' => 'household-activity','name_tw' => '住戶活動','name_cn' => NULL,'name_en' => 'Household Activity','page_type' => '0','link' => 'household-activity','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '1','created_at' => '2021-11-07 15:40:29','updated_at' => '2021-11-07 15:40:29','updated_UID' => '1'),
            array('id' => '17','MID' => '14','seq' => '2','home_seq' => NULL,'url' => 'rental-payment','name_tw' => '住戶上載交租文件','name_cn' => NULL,'name_en' => 'Household Rental Payment','page_type' => '0','link' => 'rental-payment','link_target' => '0','banner_image_file_name' => '','icon_file_name' => '','display_home' => '0','status' => '1','show_after_login' => '1','created_at' => '2021-11-07 15:40:29','updated_at' => '2021-11-07 15:40:29','updated_UID' => '1'),
        ]);

        // $this->addForeignKey(
        //     'menu-MID',
        //     'menu',
        //     'MID',
        //     'menu',
        //     'id',
        //     'SET NULL',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
