<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%about_us}}`.
 */
class m211210_052933_create_about_us_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%about_us}}', [
            'id'                    => $this->primaryKey(),
            'seq'                   => $this->integer()->unsigned()->defaultValue(0),
            'show_year'             => $this->integer()->unsigned(),
            // 'start_year'            => $this->integer()->unsigned(),
            // 'end_year'              => $this->integer()->unsigned(),
            'color'                 => $this->string(),
            'icon_file_name'        => $this->string(),
            'description'           => $this->text(),
            'file_names'            => $this->text(),
            'status'                => $this->tinyInteger()->unsigned()->defaultValue(1),
            'created_at'            => $this->dateTime().' DEFAULT NOW()',
            'updated_at'            => $this->timestamp(),
        ]);

        $this->batchInsert('{{%about_us}}', [
            'id',
            'seq',
            'show_year',
            // 'start_year',
            // 'end_year',
            'color',
            'icon_file_name',
            'description',
            'file_names',
            'status',
            'created_at',
            'updated_at',
        ], [
            array('id' => '1','seq' => '0','show_year' => '2017','color' => '#de6971','icon_file_name' => '1.jpg','description' => '<p><span style="color: rgb(17, 17, 17); font-family: light, verdana, 微軟正黑體, 黑體; font-size: 16px; background-color: rgb(255, 255, 255);">樂善堂2017年起，以自資形式進行首個「樂屋」項目，旨在協助正輪候公屋的基層家庭，改善居住環境，以及透過「社區為本」服務概念，為家庭提供適切的支援。</span></p>
            ','file_names' => '[]','status' => '1','created_at' => '2021-12-11 21:23:52','updated_at' => '2021-12-11 21:48:27'),
            array('id' => '2','seq' => '1','show_year' => '2019','color' => '#f4ca51','icon_file_name' => '2.jpg','description' => '<p>d2</p>
            ','file_names' => '[]','status' => '1','created_at' => '2021-12-11 21:25:29','updated_at' => '2021-12-11 21:40:18'),
            array('id' => '3','seq' => '2','show_year' => '2020','color' => '#67c2bd','icon_file_name' => '3.jpg','description' => '<p>d3</p>
            ','file_names' => '[]','status' => '1','created_at' => '2021-12-11 21:26:43','updated_at' => '2021-12-11 21:40:18'),
            array('id' => '4','seq' => '3','show_year' => '2021','color' => '#a791b8','icon_file_name' => '4.jpg','description' => '<p>d4</p>
            ','file_names' => '[]','status' => '1','created_at' => '2021-12-11 21:27:32','updated_at' => '2021-12-11 21:47:28'),
            array('id' => '5','seq' => '4','show_year' => '2022','color' => '#a8c83f','icon_file_name' => '5.jpg','description' => '<p>d5</p>
            ','file_names' => '[]','status' => '1','created_at' => '2021-12-11 21:28:12','updated_at' => '2021-12-11 21:47:28')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%about_us}}');
    }
}
