<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_us}}`.
 */
class m211107_201158_create_contact_us_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_us}}', [
            'id'                     => $this->primaryKey(),
            'company_name_tw'        => $this->string(),
            'company_name_cn'        => $this->string(),
            'company_name_en'        => $this->string(),
            'address_tw'             => $this->text(),
            'address_cn'             => $this->text(),
            'address_en'             => $this->text(),
            'phone'                  => $this->string(),
            'fax'                    => $this->string(),
            'whatsapp'               => $this->string(),
            'email'                  => $this->string(),
            'website'                => $this->string(),
            'facebook'               => $this->string(),
            'instagram'              => $this->string(),
            'twitter'                => $this->string(),
            'youtube'                => $this->string(),
            'googlemap'              => $this->string(510),
            'content_tw'             => $this->text(),
            'content_cn'             => $this->text(),
            'content_en'             => $this->text(),
            'status'                 => $this->integer()->defaultValue(1),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer(),
        ]);

        $this->batchInsert('{{%contact_us}}', [
            'id',
            'company_name_tw',
            'company_name_cn',
            'company_name_en',
            'address_tw',
            'address_cn' ,
            'address_en',
            'phone',
            'fax',
            'whatsapp',
            'email',
            'website',
            'facebook',
            'instagram',
            'twitter',
            'youtube',
            'googlemap',
            'content_tw',
            'content_cn',
            'content_en',
            'status',
            'created_at',
            'updated_at',
            'updated_UID',
        ], [
            [
                'id' => '1',
                'company_name_tw' => '九龍樂善堂',
                'company_name_cn' => NULL,
                'company_name_en' => 'The Lok Sin Tong Benevolent Society, Kowloon',
                'address_tw' => '九龍城龍崗道61號',
                'address_cn' => NULL,
                'address_en' => '61 Lung Kong Road, Kowloon City',
                'phone' => '2272-9888',
                'fax' => '2382-1811',
                'whatsapp' => '',
                'email' => 'housing@loksintong.org',
                'website' => '',
                'facebook' => 'https://www.facebook.com/LokSinTong',
                'instagram' => 'https://www.instagram.com/LokSinTong',
                'twitter' => '',
                'youtube' => 'https://www.youtube.com/channel/UCCR4hLzZDYIG4iPVQEwA95Q',
                'googlemap' => 'https://maps.google.com.hk/maps?f=q&amp;source=s_q&amp;hl=zh-TW&amp;q=九龍城九龍樂善堂&amp;sll=39.267997,-80.505068&amp;sspn=4.107739,9.788818&amp;ie=UTF8&amp;cd=2&amp;geocode=FfK6VAEdoWfOBg&amp;split=0&amp;hq=&amp;hnear=九龍樂善堂&amp;ll=22.329167,114.190392&amp;spn=0.00397,0.006437&amp;z=17&amp;iwloc=A&amp;output=embed',
                'content_tw' => '',
                'content_cn' => NULL,
                'content_en' => '',
                'status' => '1',
                'created_at' => '2021-11-08 10:34:41',
                'updated_at' => '2021-11-08 10:34:41',
                'updated_UID' => '1',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact_us}}');
    }
}
