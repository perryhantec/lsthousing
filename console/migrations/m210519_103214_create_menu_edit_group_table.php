<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu_edit_group}}`.
 */
class m210519_103214_create_menu_edit_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu_edit_group}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->unsigned()->notNull(),
            'admin_group_id'  => $this->integer()->unsigned()->notNull(),
        ]);

        $this->batchInsert('{{%menu_edit_group}}', [
            'menu_id',
            'admin_group_id',
        ], [
            // [
            //     'menu_id' => '1',
            //     'admin_group_id'  => '1',
            // ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu_edit_group}}');
    }
}
