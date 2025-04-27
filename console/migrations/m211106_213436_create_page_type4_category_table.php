<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_type4_category}}`.
 */
class m211106_213436_create_page_type4_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_type4_category}}', [
            'id'                     => $this->primaryKey(),
            'MID'                    => $this->integer()->unsigned()->defaultValue(null),
            'category_id'            => $this->integer()->unsigned(),
            'name_tw'                => $this->string(),
            'name_cn'                => $this->string(),
            'name_en'                => $this->string(),
            'status'                 => $this->tinyInteger()->defaultValue(1),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_type4_category}}');
    }
}
