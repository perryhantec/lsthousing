<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_group_user}}`.
 */
class m210519_103145_create_admin_group_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_group_user}}', [
            'id'             => $this->primaryKey(),
            'admin_group_id' => $this->integer()->unsigned()->notNull(),
            'admin_user_id'  => $this->integer()->unsigned()->notNull(),
        ]);

        $this->batchInsert('{{%admin_group_user}}', [
            'admin_group_id',
            'admin_user_id',
        ], [
//            [
//                'admin_group_id' => '1',
//                'admin_user_id'  => '1',
//            ],
        ]);

        // $this->addForeignKey(
        //     'admin_group_user-admin_group_id',
        //     'admin_group_user',
        //     'admin_group_id',
        //     'admin_group',
        //     'id',
        //     'CASCADE',
        //     'CASCADE'
        // );

        // $this->addForeignKey(
        //     'admin_group_user-admin_user_id',
        //     'admin_group_user',
        //     'admin_user_id',
        //     'admin_user',
        //     'id',
        //     'CASCADE',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_group_user}}');
    }
}
