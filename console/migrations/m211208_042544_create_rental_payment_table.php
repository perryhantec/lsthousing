<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rental_payment}}`.
 */
class m211208_042544_create_rental_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rental_payment}}', [
            'id'                    => $this->primaryKey(),
            'user_id'               => $this->integer()->unsigned(),
            'files'                 => $this->text(),
            'payment_year'          => $this->integer()->unsigned(),
            'payment_month'         => $this->tinyInteger()->unsigned(),
            'is_read'               => $this->tinyInteger(),
            'created_at'            => $this->dateTime().' DEFAULT NOW()',
            'updated_at'            => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rental_payment}}');
    }
}
