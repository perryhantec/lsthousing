<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%general}}`.
 */
class m211107_204232_create_general_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%general}}', [
            'id'                          => $this->primaryKey(),
            'web_name_tw'                 => $this->string(),
            'web_name_cn'                 => $this->string(),
            'web_name_en'                 => $this->string(),
            'description'                 => $this->text(),
            'keywords'                    => $this->text(),
            'banner_image_file_name'      => $this->string(),
            'copyright_tw'                => $this->string(),
            'copyright_cn'                => $this->string(),
            'copyright_en'                => $this->string(),
            'copyright_notice_tw'         => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'copyright_notice_cn'         => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'copyright_notice_en'         => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'disclaimer_tw'               => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'disclaimer_cn'               => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'disclaimer_en'               => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'privacy_statement_tw'        => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'privacy_statement_cn'        => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'privacy_statement_en'        => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'shop_empty_desc_tw'          => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'shop_empty_desc_cn'          => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'shop_empty_desc_en'          => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'delivery_fee'                => $this->float(),
            'delivery_fee_free_when'      => $this->float(),
            'site_counter'                => $this->integer(10),
            'created_at'                  => $this->dateTime().' DEFAULT NOW()',
            'updated_at'                  => $this->timestamp(),
            'updated_UID'                 => $this->integer(),
        ]);

        $this->batchInsert('{{%general}}', [
            'id',
            'web_name_tw',
            'web_name_cn',
            'web_name_en',
            'description',                 
            'keywords',
            'banner_image_file_name',
            'copyright_tw',
            'copyright_cn',
            'copyright_en',
            'copyright_notice_tw',
            'copyright_notice_cn',
            'copyright_notice_en',
            'disclaimer_tw',
            'disclaimer_cn',
            'disclaimer_en',
            'privacy_statement_tw',
            'privacy_statement_cn',
            'privacy_statement_en',
            'shop_empty_desc_tw',
            'shop_empty_desc_cn',
            'shop_empty_desc_en',
            'delivery_fee',
            'delivery_fee_free_when',
            'site_counter',
            'created_at',
            'updated_at',
            'updated_UID',
        ], [
            [
                'id' => '1',
                'web_name_tw' => '九龍樂善堂樂屋網',
                'web_name_cn' => NULL,
                'web_name_en' => 'THE LOK SIN TONG  BENEVOLENT SOCIETY  KOWLOON',
                'description' => '',
                'keywords' => '',
                'banner_image_file_name' => NULL,
                'copyright_tw' => '2022 © 九龍樂善堂 | 版權所有 不得轉載',
                'copyright_cn' => NULL,
                'copyright_en' => 'Copyright © LOK SIN TONG. All Rights Reserved.',
                'copyright_notice_tw' => '<p>網站由「樂善堂李聖根社會房屋基金」贊助&nbsp; &nbsp; 設計: 樂善製作</p>',
                'copyright_notice_cn' => NULL,
                'copyright_notice_en' => '',
                'disclaimer_tw' => '',
                'disclaimer_cn' => NULL,
                'disclaimer_en' => '',
                'privacy_statement_tw' => '',
                'privacy_statement_cn' => NULL,
                'privacy_statement_en' => '',
                'shop_empty_desc_tw' => '',
                'shop_empty_desc_cn' => NULL,
                'shop_empty_desc_en' => '',
                'delivery_fee' => NULL,
                'delivery_fee_free_when' => NULL,
                'site_counter' => '0',
                'created_at' => '2021-11-08 20:34:22',
                'updated_at' => '2021-11-08 20:34:22',
                'updated_UID' => '1',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%general}}');
    }
}
