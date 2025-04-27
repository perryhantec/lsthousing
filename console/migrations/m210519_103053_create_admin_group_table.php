<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_group}}`.
 */
class m210519_103053_create_admin_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_group}}', [
            'id'                      => $this->primaryKey(),
            'name'                    => $this->string()->notNull(),
            'canManageHome'           => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageContactus'      => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageUser'           => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageApplication'    => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageMark'           => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageVisit'          => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageRequestFile'    => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageResponseFile'   => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageApprove'        => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageAllocate'       => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageRental'         => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageAbout'          => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageProject'        => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageNewProject'     => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageGeneral'        => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageMenu'           => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'canManageAdmin'          => $this->tinyInteger(4)->notNull()->defaultValue(0),
            'status'                  => $this->integer()->defaultValue(1),
            'created_at'              => $this->timestamp()->notNull(),
            'updated_at'              => $this->dateTime()->defaultValue(null),
            'updated_UID'             => $this->integer()->defaultValue(null)
        ]);

        $this->batchInsert('{{%admin_group}}', [
            'name',
            'canManageHome',
            'canManageContactus',
            'canManageUser',
            'canManageApplication',
            'canManageMark',
            'canManageVisit',
            'canManageRequestFile',
            'canManageResponseFile',
            'canManageApprove',
            'canManageAllocate',
            'canManageRental',
            'canManageAbout',
            'canManageProject',
            'canManageNewProject',
            'canManageGeneral',
            'canManageMenu',
            'canManageAdmin',
            'status',
            'created_at',
            'updated_at',
            'updated_UID'
        ], [
            // [
            //     'name'                    => 'Clerk',
            //     'canManageHome'           => '1',
            //     'canManageContactus'      => '1',
            //     'canManageUser'           => '1',
            //     'canManageApplication'    => '1',
            //     'canManageMark'           => '1',
            //     'canManageVisit'          => '1',
            //     'canManageRequestFile'    => '1',
            //     'canManageResponseFile'   => '1',
            //     'canManageApprove'        => '1',
            //     'canManageAllocate'       => '1',
            //     'canManageRental'         => '1',
            //     'canManageAbout'          => '1',
            //     'canManageProject'        => '1',
            //     'canManageNewProject'     => '1',
            //     'canManageGeneral'        => '1',
            //     'canManageMenu'           => '1',
            //     'canManageAdmin'          => '0',
            //     'status'                  => '1',
            //     'created_at'              => '2019-06-04 07:35:28',
            //     'updated_at'              => '2020-04-21 16:55:43',
            //     'updated_UID'             => '1',
            // ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_group}}');
    }
}
