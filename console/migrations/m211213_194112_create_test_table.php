<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test}}`.
 */
class m211213_194112_create_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test}}', [
            'id'                    => $this->primaryKey(),
            'response'              => $this->text(),
            'created_at'            => $this->dateTime().' DEFAULT NOW()',
            'updated_at'            => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%test}}');
    }
}
