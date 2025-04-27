<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu_edit_user}}`.
 */
class m210519_103220_create_menu_edit_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu_edit_user}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->unsigned()->notNull(),
            'admin_user_id'  => $this->integer()->unsigned()->notNull(),
        ]);

        $this->batchInsert('{{%menu_edit_group}}', [
            'menu_id',
            'admin_user_id',
        ], [
            // [
            //     'menu_id' => '1',
            //     'admin_user_id'  => '1',
            // ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu_edit_user}}');
    }
}
