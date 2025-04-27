<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user}}`.
 */
class m210519_103200_create_admin_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_user}}', [
            'id'                   => $this->primaryKey(),
            'name'                 => $this->string()->notNull(),
            'email'                => $this->string(320)->notNull(),
            'username'             => $this->string(320)->notNull(),
            'language'             => $this->integer()->defaultValue(null),
            'password_hash'        => $this->string(160)->notNull(),
            'password_reset_token' => $this->char(43)->defaultValue(null),
            'role'                 => $this->integer()->defaultValue(20),
            'auth_key'             => $this->text(),
            'status'               => $this->integer()->defaultValue(1),
            'created_at'           => $this->timestamp()->notNull(),
            'last_login_at'        => $this->dateTime()->defaultValue(null),
            'updated_at'           => $this->dateTime()->defaultValue(null),
            'updated_UID'          => $this->integer()->defaultValue(null)
        ]);

        $this->batchInsert('{{%admin_user}}', [
            'name',
            'email',
            'username',
            'language',
            'password_hash',
            'password_reset_token',
            'role',
            'auth_key',
            'status',
            'created_at',
            'last_login_at',
            'updated_at',
            'updated_UID'
        ], [
            [
                'name' => 'Efaith Admin',
                'email' => 'info@efaith.com.hk',
                'username' => 'efaith_adm',
                'language' => NULL,
                'password_hash' => '$2y$13$CgLFvqH0XFkfOdVV1WdhS.DyIURD8bH4B67DNyECUzhEcXUdCijSy',
                'password_reset_token' => NULL,
                'role' => '10',
                'auth_key' => 'ue6PCi-22mNkDYLvKe1q7iRow6OgKwub',
                'status' => '1',
                'created_at' => '2022-07-23 01:18:29',
                'last_login_at' => '2022-07-23 01:18:29',
                'updated_at' => '2022-07-23 01:18:29',
                'updated_UID' => '1'
            ],
            [
                'name' => 'LST Housing Admin',
                'email' => 'info@efaith.com.hk',
                'username' => 'lst_housing_admin',
                'language' => NULL,
                'password_hash' => '$2y$13$v/ThSX4GcM.E30T75zNDVObOzbMiIq2Bq8S9VTbgAgevF8o8kcqBu',
                'password_reset_token' => NULL,
                'role' => '20',
                'auth_key' => 'xnzre7xM3PjDRNhEGflv60EKeAj7B-th',
                'status' => '1',
                'created_at' => '2022-07-22 18:59:02',
                'last_login_at' => '2022-07-22 18:59:02',
                'updated_at' => '2022-07-22 18:59:02',
                'updated_UID' => '1'
            ],
            [
                'name' => 'LST Admin',
                'email' => 'housing@loksintong.org',
                'username' => 'lstadmin',
                'language' => NULL,
                'password_hash' => '$2y$13$/3VC6TVob1Y018A9fL3/uekJhh6gVvcX5wiOSnTKAVKd7RFrEKCkq',
                'password_reset_token' => NULL,
                'role' => '20',
                'auth_key' => 'xnzre7xM3PjDRNhEGflv60EKeAj7B-th',
                'status' => '1',
                'created_at' => '2022-07-22 18:59:02',
                'last_login_at' => '2022-07-22 18:59:02',
                'updated_at' => '2022-07-22 18:59:02',
                'updated_UID' => '2'
            ],
            [
                'name'                 => 'Hong',
                'email'                => 'hong.wong@efaith.com.hk',
                'username'             => 'admin',
                'language'             => null,
                'password_hash'        => '$2y$13$zv12nQ/uPAHcJD1a8JBUMel/x.A1b32qDYehxjvWs2tQ615cvfT5m',
                'password_reset_token' => null,
                'role'                 => '10',
                'auth_key'             => 'YdA937_J98r1ayiPfvsci9rhyBZ-NDuO',
                'status'               => '1',
                'created_at'           => '2021-05-18 04:37:18',
                'last_login_at'        => '2021-05-18 16:27:58',
                'updated_at'           => '2021-05-18 16:27:58',
                'updated_UID'          => '1'
            ],

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user}}');
    }
}
