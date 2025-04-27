<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                    => $this->primaryKey(),
            'app_no'                => $this->string(),

            'chi_name'              => $this->string(),
            'eng_name'              => $this->string(),
            'phone'                 => $this->string(8),
            'mobile'                => $this->string(8),
            'address'               => $this->text(),
            'area'                  => $this->integer()->unsigned(),
            'email'                 => $this->string(),
            'house_type'            => $this->tinyInteger()->unsigned(),
            'house_type_other'      => $this->string(),
            'private_type'          => $this->tinyInteger()->unsigned(),
            'together_type'         => $this->tinyInteger()->unsigned(),
            'together_type_other'   => $this->string(),
            'live_rent'             => $this->float(2)->unsigned(),
            // 'live_year'             => $this->float(2)->unsigned(),
            'live_year'             => $this->tinyInteger()->unsigned()->defaultValue(0),
            'live_month'            => $this->tinyInteger()->unsigned()->defaultValue(0),
            'family_member'         => $this->tinyInteger()->unsigned(),
            'prh'                   => $this->tinyInteger()->unsigned(),
            'prh_no'                => $this->string(),
            'prh_location'          => $this->tinyInteger()->unsigned(),
            'apply_prh_year'        => $this->integer(4)->unsigned()->defaultValue(0),
            'apply_prh_month'       => $this->tinyInteger()->unsigned()->defaultValue(0),
            'apply_prh_day'         => $this->tinyInteger()->unsigned()->defaultValue(0),
            // part 2 & 3 applicant
            'app_gender'            => $this->tinyInteger()->unsigned(),
            'app_born_date'         => $this->string(),
            // 'app_born_type'         => $this->tinyInteger()->unsigned(),
            'app_id_type'           => $this->tinyInteger()->unsigned(),
            'app_id_no'             => $this->string(),
            'app_marriage_status'   => $this->tinyInteger()->unsigned(),
            'app_chronic_patient'   => $this->text(),
            'app_working_status'    => $this->tinyInteger()->unsigned(),
            'app_career'            => $this->string(),
            'app_income'            => $this->float(2)->unsigned()->defaultValue(0),
            // 'app_funding_type'      => $this->tinyInteger()->unsigned(),
            'app_funding_type'      => $this->text(),
            'app_funding_value'     => $this->float(2)->unsigned()->defaultValue(0),
            'app_asset'             => $this->tinyInteger()->unsigned(),
            'app_asset_type'        => $this->string(),
            'app_asset_value'       => $this->float(2)->unsigned()->defaultValue(0),
            'app_deposit'           => $this->float(2)->unsigned()->defaultValue(0),
            // part 2 & 3 family member 1
            'm1_chi_name'           => $this->string(),
            'm1_eng_name'           => $this->string(),
            'm1_gender'             => $this->tinyInteger()->unsigned(),
            'm1_born_date'          => $this->string(),
            // 'm1_born_type'          => $this->tinyInteger()->unsigned(),
            'm1_id_type'            => $this->tinyInteger()->unsigned(),
            'm1_id_no'              => $this->string(),
            'm1_relationship'       => $this->string(),
            'm1_marriage_status'    => $this->tinyInteger()->unsigned(),
            'm1_chronic_patient'    => $this->tinyInteger()->unsigned(),
            'm1_special_study'      => $this->tinyInteger()->unsigned(),
            'm1_working_status'     => $this->tinyInteger()->unsigned(),
            'm1_career'             => $this->string(),
            'm1_income'             => $this->float(2)->unsigned()->defaultValue(0),
            // 'm1_funding_type'       => $this->tinyInteger()->unsigned(),
            'm1_funding_type'       => $this->text(),
            'm1_funding_value'      => $this->float(2)->unsigned()->defaultValue(0),
            'm1_asset'              => $this->tinyInteger()->unsigned(),
            'm1_asset_type'         => $this->string(),
            'm1_asset_value'        => $this->float(2)->unsigned()->defaultValue(0),
            'm1_deposit'            => $this->float(2)->unsigned()->defaultValue(0),

            'm2_chi_name'           => $this->string(),
            'm2_eng_name'           => $this->string(),
            'm2_gender'             => $this->tinyInteger()->unsigned(),
            'm2_born_date'          => $this->string(),
            // 'm2_born_type'          => $this->tinyInteger()->unsigned(),
            'm2_id_type'            => $this->tinyInteger()->unsigned(),
            'm2_id_no'              => $this->string(),
            'm2_relationship'       => $this->string(),
            'm2_marriage_status'    => $this->tinyInteger()->unsigned(),
            'm2_chronic_patient'    => $this->tinyInteger()->unsigned(),
            'm2_special_study'      => $this->tinyInteger()->unsigned(),
            'm2_working_status'     => $this->tinyInteger()->unsigned(),
            'm2_career'             => $this->string(),
            'm2_income'             => $this->float(2)->unsigned()->defaultValue(0),
            // 'm2_funding_type'       => $this->tinyInteger()->unsigned(),
            'm2_funding_type'       => $this->text(),
            'm2_funding_value'      => $this->float(2)->unsigned()->defaultValue(0),
            'm2_asset'              => $this->tinyInteger()->unsigned(),
            'm2_asset_type'         => $this->string(),
            'm2_asset_value'        => $this->float(2)->unsigned()->defaultValue(0),
            'm2_deposit'            => $this->float(2)->unsigned()->defaultValue(0),

            'm3_chi_name'           => $this->string(),
            'm3_eng_name'           => $this->string(),
            'm3_gender'             => $this->tinyInteger()->unsigned(),
            'm3_born_date'          => $this->string(),
            // 'm3_born_type'          => $this->tinyInteger()->unsigned(),
            'm3_id_type'            => $this->tinyInteger()->unsigned(),
            'm3_id_no'              => $this->string(),
            'm3_relationship'       => $this->string(),
            'm3_marriage_status'    => $this->tinyInteger()->unsigned(),
            'm3_chronic_patient'    => $this->tinyInteger()->unsigned(),
            'm3_special_study'      => $this->tinyInteger()->unsigned(),
            'm3_working_status'     => $this->tinyInteger()->unsigned(),
            'm3_career'             => $this->string(),
            'm3_income'             => $this->float(2)->unsigned()->defaultValue(0),
            // 'm3_funding_type'       => $this->tinyInteger()->unsigned(),
            'm3_funding_type'       => $this->text(),
            'm3_funding_value'      => $this->float(2)->unsigned()->defaultValue(0),
            'm3_asset'              => $this->tinyInteger()->unsigned(),
            'm3_asset_type'         => $this->string(),
            'm3_asset_value'        => $this->float(2)->unsigned()->defaultValue(0),
            'm3_deposit'            => $this->float(2)->unsigned()->defaultValue(0),

            'm4_chi_name'           => $this->string(),
            'm4_eng_name'           => $this->string(),
            'm4_gender'             => $this->tinyInteger()->unsigned(),
            'm4_born_date'          => $this->string(),
            // 'm4_born_type'          => $this->tinyInteger()->unsigned(),
            'm4_id_type'            => $this->tinyInteger()->unsigned(),
            'm4_id_no'              => $this->string(),
            'm4_relationship'       => $this->string(),
            'm4_marriage_status'    => $this->tinyInteger()->unsigned(),
            'm4_chronic_patient'    => $this->tinyInteger()->unsigned(),
            'm4_special_study'      => $this->tinyInteger()->unsigned(),
            'm4_working_status'     => $this->tinyInteger()->unsigned(),
            'm4_career'             => $this->string(),
            'm4_income'             => $this->float(2)->unsigned()->defaultValue(0),
            // 'm4_funding_type'       => $this->tinyInteger()->unsigned(),
            'm4_funding_type'       => $this->text(),
            'm4_funding_value'      => $this->float(2)->unsigned()->defaultValue(0),
            'm4_asset'              => $this->tinyInteger()->unsigned(),
            'm4_asset_type'         => $this->string(),
            'm4_asset_value'        => $this->float(2)->unsigned()->defaultValue(0),
            'm4_deposit'            => $this->float(2)->unsigned()->defaultValue(0),

            'm5_chi_name'           => $this->string(),
            'm5_eng_name'           => $this->string(),
            'm5_gender'             => $this->tinyInteger()->unsigned(),
            'm5_born_date'          => $this->string(),
            // 'm5_born_type'          => $this->tinyInteger()->unsigned(),
            'm5_id_type'            => $this->tinyInteger()->unsigned(),
            'm5_id_no'              => $this->string(),
            'm5_relationship'       => $this->string(),
            'm5_marriage_status'    => $this->tinyInteger()->unsigned(),
            'm5_chronic_patient'    => $this->tinyInteger()->unsigned(),
            'm5_special_study'      => $this->tinyInteger()->unsigned(),
            'm5_working_status'     => $this->tinyInteger()->unsigned(),
            'm5_career'             => $this->string(),
            'm5_income'             => $this->float(2)->unsigned()->defaultValue(0),
            // 'm5_funding_type'       => $this->tinyInteger()->unsigned(),
            'm5_funding_type'       => $this->text(),
            'm5_funding_value'      => $this->float(2)->unsigned()->defaultValue(0),
            'm5_asset'              => $this->tinyInteger()->unsigned(),
            'm5_asset_type'         => $this->string(),
            'm5_asset_value'        => $this->float(2)->unsigned()->defaultValue(0),
            'm5_deposit'            => $this->float(2)->unsigned()->defaultValue(0),
            // part 2 & 3 other
            'single_parents'        => $this->tinyInteger()->unsigned(),
            'pregnant'              => $this->tinyInteger()->unsigned(),
            'pregnant_period'       => $this->tinyInteger()->unsigned(),
            'total_income'          => $this->float(2)->unsigned()->defaultValue(0),
            'total_funding'         => $this->float(2)->unsigned()->defaultValue(0),
            'total_asset'           => $this->float(2)->unsigned()->defaultValue(0),
            // part 4
            'social_worker_name'    => $this->string(),
            'social_worker_phone'   => $this->string(8),
            'social_worker_email'   => $this->string(),

            'room_no'               => $this->string(),
            'start_date'            => $this->string(),
            'withdrew_date'         => $this->string(),

            'user_appl_status'      => $this->integer()->defaultValue(20),

            'otp'                   => $this->string(),
            'otp_expire'            => $this->integer(20),
            'wrong_count'           => $this->integer()->defaultValue(0),
            'wrong_expire'          => $this->integer(20)->defaultValue(0),

            // 'show_upload_page'      => $this->tinyInteger()->defaultValue(0),

            // 'name'                   => $this->string()->notNull(),
            // 'phone'                  => $this->string(16),
            // 'email'                  => $this->string(320)->notNull(),
            // 'username'               => $this->string(320)->notNull(),
            'language'               => $this->integer(),
            'img'                    => $this->string(2048),
            'password_hash'          => $this->string(160)->notNull()->defaultValue('$2y$13$Kp71i/AcmLWAZwhgK4T7l.u1S3gc2QvqQis0KpHT2LSngdQNqZkDm'),
            // LSThousing2022
            'password_reset_token'   => $this->char(43),
            'role'                   => $this->integer()->defaultValue(20),
            'oAuth_user'             => $this->integer()->defaultValue(0),
            'auth_key'               => $this->text(),
            'status'                 => $this->integer()->defaultValue(1),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'last_login_at'          => $this->dateTime(),
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer(),
            // 'id' => $this->primaryKey(),
            // 'username' => $this->string()->notNull()->unique(),
            // 'auth_key' => $this->string(32)->notNull(),
            // 'password_hash' => $this->string()->notNull(),
            // 'password_reset_token' => $this->string()->unique(),
            // 'email' => $this->string()->notNull()->unique(),

            // 'status' => $this->smallInteger()->notNull()->defaultValue(10),
            // 'created_at' => $this->integer()->notNull(),
            // 'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
/*
        $this->batchInsert('{{%user}}', [
            'id',
            'app_no',
            'chi_name',
            'eng_name',
            'phone',
            'mobile',
            'address',
            'area',
            'email',
            'house_type',
            'house_type_other',
            'private_type',
            'together_type',
            'together_type_other',
            'live_rent',
            'live_year',
            'live_month',
            'family_member',
            'prh',
            'prh_no',
            'prh_location',
            'apply_prh_year',
            'apply_prh_month',
            'apply_prh_day',
            'app_gender',
            'app_born_date',
            // 'app_born_type',
            'app_id_type',
            'app_id_no',
            'app_marriage_status',
            'app_chronic_patient',
            'app_working_status',
            'app_career',
            'app_income',
            'app_funding_type',
            'app_funding_value',
            'app_asset',
            'app_asset_type',
            'app_asset_value',
            'app_deposit',
            'm1_chi_name',
            'm1_eng_name',
            'm1_gender',
            'm1_born_date',
            // 'm1_born_type',
            'm1_id_type',
            'm1_id_no',
            'm1_relationship',
            'm1_marriage_status',
            'm1_chronic_patient',
            'm1_special_study',
            'm1_working_status',
            'm1_career',
            'm1_income',
            'm1_funding_type',
            'm1_funding_value',
            'm1_asset',
            'm1_asset_type',
            'm1_asset_value',
            'm1_deposit',
            'single_parents',
            'pregnant',
            'pregnant_period',
            'total_income',
            'total_funding',
            'total_asset',
            'social_worker_name',
            'social_worker_phone',
            'social_worker_email',
            'user_appl_status',
            // 'show_upload_page',
            'language',
            'img',
            'password_hash',
            'password_reset_token',
            'role',
            'oAuth_user',
            'auth_key',
            'status',
            'created_at',
            'last_login_at',
            'updated_at',
            'updated_UID',
        ], [
            array(
                'id' => '1','app_no' => 'APP000000001','chi_name' => 'chi','eng_name' => 'eng','phone' => '','mobile' => '60171951','address' => 'my address',
                'area' => '123','email' => 'hong.wong@efaith.com.hk','house_type' => '1','house_type_other' => '','private_type' => '2','together_type' => NULL,
                'together_type_other' => '','live_rent' => '987','live_year' => '0','live_month' => '5','family_member' => '2','prh' => '1',
                'prh_no' => 'U-1324646(G-1654-G-6584)','prh_location' => '1','apply_prh_year' => '2018','apply_prh_month' => '8','apply_prh_day' => '16',
                'app_gender' => '1','app_born_date' => '1/1/1970','app_id_type' => '1','app_id_no' => 'Y147258(3)','app_marriage_status' => '2',
                'app_chronic_patient' => '','app_working_status' => '1','app_career' => 'cs','app_income' => '800','app_funding_type' => '["5"]',
                'app_funding_value' => '500','app_asset' => '1','app_asset_type' => 'stock','app_asset_value' => '1000','app_deposit' => '200',
                'm1_chi_name' => 'DDDD','m1_eng_name' => 'DDDD','m1_gender' => '2','m1_born_date' => '8/8/1988','m1_id_type' => '2','m1_id_no' => 'R966324',
                'm1_relationship' => 'friend','m1_marriage_status' => '1','m1_chronic_patient' => NULL,'m1_special_study' => '0','m1_working_status' => '3',
                'm1_career' => '','m1_income' => '0','m1_funding_type' => NULL,'m1_funding_value' => '0','m1_asset' => '2','m1_asset_type' => '',
                'm1_asset_value' => '0','m1_deposit' => '0','single_parents' => '2','pregnant' => '2','pregnant_period' => NULL,'total_income' => '2000',
                'total_funding' => '1000','total_asset' => '9999','social_worker_name' => 'abc','social_worker_phone' => '88888888',
                'social_worker_email' => 'abc@def.com','user_appl_status' => '10','language' => NULL,'img' => NULL,
                'password_hash' => '$2y$13$KdNQe3gPmmAvZFMl4ymUMOKIe4U4yeGasW9jf/prpRQQw1kq3XlIC','password_reset_token' => NULL,'role' => '30',
                'oAuth_user' => '0','auth_key' => '17-DbK4opzByydPEv38DU25plsJ808dA','status' => '1',
                'created_at' => '2021-11-28 19:33:23','last_login_at' => '2021-11-28 14:49:07','updated_at' => '2021-11-28 19:33:23','updated_UID' => '1'
            )
        ]);
*/
        $this->batchInsert('{{%user}}', [
            'app_no',
            'chi_name',
            'eng_name',
            'mobile',
            'role',
//            'password_hash',
        ], [
            ['app_no' => 'APP000000001','chi_name' => '廖子康','eng_name' => NULL,'mobile' => '67053655','role' => '30'],
            ['app_no' => 'APP000000002','chi_name' => '劉雅雯','eng_name' => NULL,'mobile' => '51174288','role' => '30'],
            ['app_no' => 'APP000000003','chi_name' => '唐惠萍','eng_name' => NULL,'mobile' => '93167186','role' => '30'],
            ['app_no' => 'APP000000004','chi_name' => '吳國枝','eng_name' => NULL,'mobile' => '94290218','role' => '30'],
            ['app_no' => 'APP000000005','chi_name' => '黎祥光','eng_name' => NULL,'mobile' => '93769966','role' => '30'],
            ['app_no' => 'APP000000006','chi_name' => '蘇志芳','eng_name' => NULL,'mobile' => '92479569','role' => '30'],
            ['app_no' => 'APP000000007','chi_name' => '謝亞麗','eng_name' => NULL,'mobile' => '61789079','role' => '30'],
            ['app_no' => 'APP000000008','chi_name' => '周麗思','eng_name' => NULL,'mobile' => '95306846','role' => '30'],
            ['app_no' => 'APP000000009','chi_name' => '王荣顏','eng_name' => NULL,'mobile' => '67944987','role' => '30'],
            ['app_no' => 'APP000000010','chi_name' => '劉文龍','eng_name' => NULL,'mobile' => '52280639','role' => '30'],
            ['app_no' => 'APP000000011','chi_name' => '甄秀嬋','eng_name' => NULL,'mobile' => '56283768','role' => '30'],
            ['app_no' => 'APP000000012','chi_name' => '鄧綺玲','eng_name' => NULL,'mobile' => '65322640','role' => '30'],
            ['app_no' => 'APP000000013','chi_name' => '何綺霞','eng_name' => NULL,'mobile' => '67111055','role' => '30'],
            ['app_no' => 'APP000000014','chi_name' => '謝俊玲','eng_name' => NULL,'mobile' => '55443240','role' => '30'],
            ['app_no' => 'APP000000015','chi_name' => '莫家怡','eng_name' => NULL,'mobile' => '51785986','role' => '30'],
            ['app_no' => 'APP000000016','chi_name' => '陳美鳳','eng_name' => NULL,'mobile' => '98342414','role' => '30'],
            ['app_no' => 'APP000000017','chi_name' => '蔡倩儀','eng_name' => NULL,'mobile' => '96003617','role' => '30'],
            ['app_no' => 'APP000000018','chi_name' => '鍾均文','eng_name' => NULL,'mobile' => '65886148','role' => '30'],
            ['app_no' => 'APP000000019','chi_name' => '曾媛妮','eng_name' => NULL,'mobile' => '91523050','role' => '30'],
            ['app_no' => 'APP000000020','chi_name' => '莊永偉','eng_name' => NULL,'mobile' => '52819121','role' => '30'],
            ['app_no' => 'APP000000021','chi_name' => '盧靜','eng_name' => NULL,'mobile' => '67772585','role' => '30'],
            ['app_no' => 'APP000000022','chi_name' => '黎燕茗','eng_name' => NULL,'mobile' => '67628619','role' => '30'],
            ['app_no' => 'APP000000023','chi_name' => '蔡岳','eng_name' => NULL,'mobile' => '91539883','role' => '30'],
            ['app_no' => 'APP000000024','chi_name' => '吳秋順','eng_name' => NULL,'mobile' => '64322976','role' => '30'],
            ['app_no' => 'APP000000025','chi_name' => '劉恩欣','eng_name' => NULL,'mobile' => '52229649','role' => '30'],
            ['app_no' => 'APP000000026','chi_name' => '楊雪','eng_name' => NULL,'mobile' => '53369069','role' => '30'],
            ['app_no' => 'APP000000027','chi_name' => '葉信忠','eng_name' => NULL,'mobile' => '95858643','role' => '30'],
            ['app_no' => 'APP000000028','chi_name' => '關冠峰','eng_name' => NULL,'mobile' => '56163495','role' => '30'],
            ['app_no' => 'APP000000029','chi_name' => '張樂成','eng_name' => NULL,'mobile' => '67969261','role' => '30'],
            ['app_no' => 'APP000000030','chi_name' => '趙春容','eng_name' => NULL,'mobile' => '51352030','role' => '30'],
            ['app_no' => 'APP000000031','chi_name' => '廖幻','eng_name' => NULL,'mobile' => '98359739','role' => '30'],
            ['app_no' => 'APP000000032','chi_name' => '劉婷婷','eng_name' => NULL,'mobile' => '51129701','role' => '30'],
            ['app_no' => 'APP000000033','chi_name' => '梁安妮','eng_name' => NULL,'mobile' => '60353810','role' => '30'],
            ['app_no' => 'APP000000034','chi_name' => '董德祿','eng_name' => NULL,'mobile' => '96311295','role' => '30'],
            ['app_no' => 'APP000000035','chi_name' => '王學發','eng_name' => NULL,'mobile' => '62117164','role' => '30'],
            ['app_no' => 'APP000000036','chi_name' => '張惠娟','eng_name' => NULL,'mobile' => '96594357','role' => '30'],
            ['app_no' => 'APP000000037','chi_name' => '趙秀珍','eng_name' => NULL,'mobile' => '96486177','role' => '30'],
            ['app_no' => 'APP000000038','chi_name' => '黃春強','eng_name' => NULL,'mobile' => '94490032','role' => '30'],
            ['app_no' => 'APP000000039','chi_name' => '秦家芝','eng_name' => NULL,'mobile' => '63568785','role' => '30'],
            ['app_no' => 'APP000000040','chi_name' => '關美愿','eng_name' => NULL,'mobile' => '93769966','role' => '30'],
            ['app_no' => 'APP000000041','chi_name' => '黃佩君','eng_name' => NULL,'mobile' => '59328723','role' => '30'],
            ['app_no' => 'APP000000042','chi_name' => '楊俊','eng_name' => NULL,'mobile' => '52287277','role' => '30'],
            ['app_no' => 'APP000000043','chi_name' => '李宛陶','eng_name' => NULL,'mobile' => '52223963','role' => '30'],
            ['app_no' => 'APP000000044','chi_name' => '張娜','eng_name' => NULL,'mobile' => '69356290','role' => '30'],
            ['app_no' => 'APP000000045','chi_name' => '程龍','eng_name' => NULL,'mobile' => '52193383','role' => '30'],
            ['app_no' => 'APP000000046','chi_name' => '莫兆剛','eng_name' => NULL,'mobile' => '61034342','role' => '30'],
            ['app_no' => 'APP000000047','chi_name' => '倫健偉','eng_name' => NULL,'mobile' => '98635878','role' => '30'],
            ['app_no' => 'APP000000048','chi_name' => '林培瑤','eng_name' => NULL,'mobile' => '96034801','role' => '30'],
            ['app_no' => 'APP000000049','chi_name' => '廖清強','eng_name' => NULL,'mobile' => '98804055','role' => '30'],
            ['app_no' => 'APP000000050','chi_name' => '凌禮昌','eng_name' => NULL,'mobile' => '90193711','role' => '30'],
            ['app_no' => 'APP000000051','chi_name' => '王婉儀','eng_name' => NULL,'mobile' => '97799618','role' => '30'],
            ['app_no' => 'APP000000052','chi_name' => '傅雨成','eng_name' => NULL,'mobile' => '93337804','role' => '30'],
            ['app_no' => 'APP000000053','chi_name' => '孫耀然','eng_name' => NULL,'mobile' => '52208598','role' => '30'],
            ['app_no' => 'APP000000054','chi_name' => '黃允豪','eng_name' => NULL,'mobile' => '67479636','role' => '30'],
            ['app_no' => 'APP000000055','chi_name' => '卓錦珠','eng_name' => NULL,'mobile' => '90881192','role' => '30'],
            ['app_no' => 'APP000000056','chi_name' => '袁艷華','eng_name' => NULL,'mobile' => '69992822','role' => '30'],
            ['app_no' => 'APP000000057','chi_name' => '陳文隆','eng_name' => NULL,'mobile' => '54480833','role' => '30'],
            ['app_no' => 'APP000000058','chi_name' => '劉安國','eng_name' => NULL,'mobile' => '63072068','role' => '30'],
            ['app_no' => 'APP000000059','chi_name' => '陳雪珍','eng_name' => NULL,'mobile' => '55420696','role' => '30'],
            ['app_no' => 'APP000000060','chi_name' => '周偉海','eng_name' => NULL,'mobile' => '51108271','role' => '30'],
            ['app_no' => 'APP000000061','chi_name' => '顏家貴','eng_name' => NULL,'mobile' => '63528797','role' => '30'],
            ['app_no' => 'APP000000062','chi_name' => '張啟明','eng_name' => NULL,'mobile' => '93425301','role' => '30'],
            ['app_no' => 'APP000000063','chi_name' => '梁錦明','eng_name' => NULL,'mobile' => '62559667','role' => '30'],
            ['app_no' => 'APP000000064','chi_name' => '董振偉','eng_name' => NULL,'mobile' => '93444202','role' => '30'],
            ['app_no' => 'APP000000065','chi_name' => '呂賽雲','eng_name' => NULL,'mobile' => '60956104','role' => '30'],
            ['app_no' => 'APP000000066','chi_name' => '鄧曉娃','eng_name' => NULL,'mobile' => '68783181','role' => '30'],
            ['app_no' => 'APP000000067','chi_name' => '謝昌怡','eng_name' => NULL,'mobile' => '97767200','role' => '30'],
            ['app_no' => 'APP000000068','chi_name' => '楊金華','eng_name' => NULL,'mobile' => '91390613','role' => '30'],
            ['app_no' => 'APP000000069','chi_name' => '胡少玉','eng_name' => NULL,'mobile' => '67057333','role' => '30'],
            ['app_no' => 'APP000000070','chi_name' => '温招娣','eng_name' => NULL,'mobile' => '92057356','role' => '30'],
            ['app_no' => 'APP000000071','chi_name' => '謝美娟','eng_name' => NULL,'mobile' => '90920558','role' => '30'],
            ['app_no' => 'APP000000072','chi_name' => '吳玲鳳','eng_name' => NULL,'mobile' => '53986867','role' => '30'],
            ['app_no' => 'APP000000073','chi_name' => '杜曉華','eng_name' => NULL,'mobile' => '52810733','role' => '30'],
            ['app_no' => 'APP000000074','chi_name' => '王小慧','eng_name' => NULL,'mobile' => '92858765','role' => '30'],
            ['app_no' => 'APP000000075','chi_name' => '何志芬','eng_name' => NULL,'mobile' => '67121728','role' => '30'],
            ['app_no' => 'APP000000076','chi_name' => '張敏莉','eng_name' => NULL,'mobile' => '54019875','role' => '30'],
            ['app_no' => 'APP000000077','chi_name' => '温雅','eng_name' => NULL,'mobile' => '51221266','role' => '30'],
            ['app_no' => 'APP000000078','chi_name' => '阮少玲','eng_name' => NULL,'mobile' => '61881226','role' => '30'],
            ['app_no' => 'APP000000079','chi_name' => '高文樂','eng_name' => NULL,'mobile' => '63429863','role' => '30'],
            ['app_no' => 'APP000000080','chi_name' => '巫妙芳','eng_name' => NULL,'mobile' => '59775552','role' => '30'],
            ['app_no' => 'APP000000081','chi_name' => '陳迪安','eng_name' => NULL,'mobile' => '96552667','role' => '30'],
            ['app_no' => 'APP000000082','chi_name' => '徐瑋君','eng_name' => NULL,'mobile' => '94619218','role' => '30'],
            ['app_no' => 'APP000000083','chi_name' => '吳世玉','eng_name' => NULL,'mobile' => '51101884','role' => '30'],
            ['app_no' => 'APP000000084','chi_name' => '區咏紅','eng_name' => NULL,'mobile' => '63724128','role' => '30'],
            ['app_no' => 'APP000000085','chi_name' => '梁文胜','eng_name' => NULL,'mobile' => '65719113','role' => '30'],
            ['app_no' => 'APP000000086','chi_name' => '張朝暉','eng_name' => NULL,'mobile' => '56005852','role' => '30'],
            ['app_no' => 'APP000000087','chi_name' => '羅偉杰','eng_name' => NULL,'mobile' => '65874338','role' => '30'],
            ['app_no' => 'APP000000088','chi_name' => '羅廖雄','eng_name' => NULL,'mobile' => '67108982','role' => '30'],
            ['app_no' => 'APP000000089','chi_name' => '高明珠','eng_name' => NULL,'mobile' => '61948524','role' => '30'],
            ['app_no' => 'APP000000090','chi_name' => '林笑梅','eng_name' => NULL,'mobile' => '91580302','role' => '30'],
            ['app_no' => 'APP000000091','chi_name' => '楊美珠','eng_name' => NULL,'mobile' => '56164108','role' => '30'],
            ['app_no' => 'APP000000092','chi_name' => '楊衛衛','eng_name' => NULL,'mobile' => '93178331','role' => '30'],
            ['app_no' => 'APP000000093','chi_name' => '梁焯傑','eng_name' => NULL,'mobile' => '65399995','role' => '30'],
            ['app_no' => 'APP000000094','chi_name' => '羅景聰','eng_name' => NULL,'mobile' => '92704693','role' => '30'],
            ['app_no' => 'APP000000095','chi_name' => '梁秀慧','eng_name' => NULL,'mobile' => '92246663','role' => '30'],
            ['app_no' => 'APP000000096','chi_name' => '潘嘉濠','eng_name' => NULL,'mobile' => '69978038','role' => '30'],
            ['app_no' => 'APP000000097','chi_name' => '梁凱兒','eng_name' => NULL,'mobile' => '52100474','role' => '30'],
            ['app_no' => 'APP000000098','chi_name' => '康文旌','eng_name' => NULL,'mobile' => '63899217','role' => '30'],
            ['app_no' => 'APP000000099','chi_name' => '張美素','eng_name' => NULL,'mobile' => '68743970','role' => '30'],
            ['app_no' => 'APP000000100','chi_name' => '陳奉英','eng_name' => NULL,'mobile' => '94372939','role' => '30'],
            ['app_no' => 'APP000000101','chi_name' => '余慧清','eng_name' => NULL,'mobile' => '66439955','role' => '30'],
            ['app_no' => 'APP000000102','chi_name' => '劉詠心','eng_name' => NULL,'mobile' => '62285415','role' => '30'],
            ['app_no' => 'APP000000103','chi_name' => '潘淑霞','eng_name' => NULL,'mobile' => '55992036','role' => '30'],
            ['app_no' => 'APP000000104','chi_name' => '陳麗妍','eng_name' => NULL,'mobile' => '98399853','role' => '30'],
            ['app_no' => 'APP000000105','chi_name' => '黃以銘','eng_name' => NULL,'mobile' => '90362976','role' => '30'],
            ['app_no' => 'APP000000106','chi_name' => '黎曼慧','eng_name' => NULL,'mobile' => '96056454','role' => '30'],
            ['app_no' => 'APP000000107','chi_name' => '林惠芳','eng_name' => NULL,'mobile' => '51616722','role' => '30'],
            ['app_no' => 'APP000000108','chi_name' => '郭滿齊','eng_name' => NULL,'mobile' => '95392009','role' => '30'],
            ['app_no' => 'APP000000109','chi_name' => NULL,'eng_name' => 'NIPHORNRAM RUANG','mobile' => '64889627','role' => '30'],
            ['app_no' => 'APP000000110','chi_name' => '唐嘉蓮','eng_name' => NULL,'mobile' => '90148637','role' => '30'],
            ['app_no' => 'APP000000111','chi_name' => '賴婉雯','eng_name' => NULL,'mobile' => '92689103','role' => '30'],
            ['app_no' => 'APP000000112','chi_name' => '洪素珍','eng_name' => NULL,'mobile' => '93703813','role' => '30'],
            ['app_no' => 'APP000000113','chi_name' => '謝志紅','eng_name' => NULL,'mobile' => '68590273','role' => '30'],
            ['app_no' => 'APP000000114','chi_name' => '莫秀青','eng_name' => NULL,'mobile' => '51218297','role' => '30'],
            ['app_no' => 'APP000000115','chi_name' => '田長順','eng_name' => NULL,'mobile' => '59314995','role' => '30'],
            ['app_no' => 'APP000000116','chi_name' => '鄧桂明','eng_name' => NULL,'mobile' => '61329173','role' => '30'],
            ['app_no' => 'APP000000117','chi_name' => '吳金萍','eng_name' => NULL,'mobile' => '56216214','role' => '30'],
            ['app_no' => 'APP000000118','chi_name' => '劉宇婷','eng_name' => NULL,'mobile' => '67085228','role' => '30'],
            ['app_no' => 'APP000000119','chi_name' => '朱檢花','eng_name' => NULL,'mobile' => '52220903','role' => '30'],
            ['app_no' => 'APP000000120','chi_name' => '丁宇坤','eng_name' => NULL,'mobile' => '96855895','role' => '30'],
            ['app_no' => 'APP000000121','chi_name' => '林淑嫺','eng_name' => NULL,'mobile' => '91472914','role' => '30'],
            ['app_no' => 'APP000000122','chi_name' => '吳雅芳','eng_name' => NULL,'mobile' => '92771108','role' => '30'],
            ['app_no' => 'APP000000123','chi_name' => '馮嘉健','eng_name' => NULL,'mobile' => '52253778','role' => '30'],
            ['app_no' => 'APP000000124','chi_name' => '區國強','eng_name' => NULL,'mobile' => '68132207','role' => '30'],
            ['app_no' => 'APP000000125','chi_name' => '李達平','eng_name' => NULL,'mobile' => '55309565','role' => '30'],
            ['app_no' => 'APP000000126','chi_name' => '陳美然','eng_name' => NULL,'mobile' => '63579866','role' => '30'],
            ['app_no' => 'APP000000127','chi_name' => '謝奇才','eng_name' => NULL,'mobile' => '91431298','role' => '30'],
            ['app_no' => 'APP000000128','chi_name' => '黃麗霞','eng_name' => NULL,'mobile' => '53687430','role' => '30'],
            ['app_no' => 'APP000000129','chi_name' => '伍立超','eng_name' => NULL,'mobile' => '93531200','role' => '30'],
            ['app_no' => 'APP000000130','chi_name' => '林少貞','eng_name' => NULL,'mobile' => '97109543','role' => '30'],
            ['app_no' => 'APP000000131','chi_name' => '陳志光','eng_name' => NULL,'mobile' => '94826687','role' => '30'],
            ['app_no' => 'APP000000132','chi_name' => '丁燕芬','eng_name' => NULL,'mobile' => '93403037','role' => '30'],
            ['app_no' => 'APP000000133','chi_name' => '周海芽','eng_name' => NULL,'mobile' => '54080908','role' => '30'],
            ['app_no' => 'APP000000134','chi_name' => '梁偉權','eng_name' => NULL,'mobile' => '68511657','role' => '30'],
            ['app_no' => 'APP000000135','chi_name' => '容星強','eng_name' => NULL,'mobile' => '54088562','role' => '30'],
            ['app_no' => 'APP000000136','chi_name' => '林滸峰','eng_name' => NULL,'mobile' => '67607050','role' => '30'],
            ['app_no' => 'APP000000137','chi_name' => '洪詠姍','eng_name' => NULL,'mobile' => '55618860','role' => '30'],
            ['app_no' => 'APP000000138','chi_name' => '劉俊芝','eng_name' => NULL,'mobile' => '95239078','role' => '30'],
            ['app_no' => 'APP000000139','chi_name' => '蘇嘉莉','eng_name' => NULL,'mobile' => '51107766','role' => '30'],
            ['app_no' => 'APP000000140','chi_name' => '陳小燕','eng_name' => NULL,'mobile' => '64862888','role' => '30'],
            ['app_no' => 'APP000000141','chi_name' => '胡其磊','eng_name' => NULL,'mobile' => '63608806','role' => '30'],
            ['app_no' => 'APP000000142','chi_name' => '吳棠生','eng_name' => NULL,'mobile' => '91217722','role' => '30'],
            ['app_no' => 'APP000000143','chi_name' => '何建輝','eng_name' => NULL,'mobile' => '62038538','role' => '30'],
            ['app_no' => 'APP000000144','chi_name' => '喻朝輝','eng_name' => NULL,'mobile' => '62119256','role' => '30'],
            ['app_no' => 'APP000000145','chi_name' => '石麗香','eng_name' => NULL,'mobile' => '97784909','role' => '30'],
            ['app_no' => 'APP000000146','chi_name' => '容銘洪','eng_name' => NULL,'mobile' => '56621619','role' => '30'],
            ['app_no' => 'APP000000147','chi_name' => '李文鳳','eng_name' => NULL,'mobile' => '98355018','role' => '30'],
            ['app_no' => 'APP000000148','chi_name' => '陶春燕','eng_name' => NULL,'mobile' => '67088692','role' => '30'],
            ['app_no' => 'APP000000149','chi_name' => '戴雪峰','eng_name' => NULL,'mobile' => '62115434','role' => '30'],
            ['app_no' => 'APP000000150','chi_name' => '莫彩嬌','eng_name' => NULL,'mobile' => '65478951','role' => '30'],
            ['app_no' => 'APP000000151','chi_name' => '鍾澤兵','eng_name' => NULL,'mobile' => '65970593','role' => '30'],
            ['app_no' => 'APP000000152','chi_name' => '方玉靈','eng_name' => 'Fong Yuk Ling','mobile' => '67032349','role' => '30'],
            ['app_no' => 'APP000000153','chi_name' => '楊玉霞','eng_name' => 'Yeung Yuk Ha','mobile' => '54951382','role' => '30'],
            ['app_no' => 'APP000000154','chi_name' => '王小麗','eng_name' => 'Wang Xiao Li','mobile' => '66860263','role' => '30'],
            ['app_no' => 'APP000000155','chi_name' => '麥嘉威','eng_name' => 'Mai Jiawei','mobile' => '68710702','role' => '30'],
            ['app_no' => 'APP000000156','chi_name' => '劉雪貞','eng_name' => 'Lau Suet Ching','mobile' => '63395726','role' => '30'],
            ['app_no' => 'APP000000157','chi_name' => '羅柳苑','eng_name' => 'Luo Liu Yuan Sindy','mobile' => '51128659','role' => '30'],
            ['app_no' => 'APP000000158','chi_name' => '陳豔芝','eng_name' => 'Chan Yim Chi','mobile' => '96848202','role' => '30'],
            ['app_no' => 'APP000000159','chi_name' => '鄒少鋒','eng_name' => 'Zou Shaofeng','mobile' => '92027580','role' => '30'],
            ['app_no' => 'APP000000160','chi_name' => '袁淑貞','eng_name' => 'Yuen Shuk Ching','mobile' => '92032419','role' => '30'],
            ['app_no' => 'APP000000161','chi_name' => '黃體媛','eng_name' => 'Wong Taiwun','mobile' => '59313397','role' => '30'],
            ['app_no' => 'APP000000162','chi_name' => '胡詠梓','eng_name' => 'Wu Wing Chi','mobile' => '96887335','role' => '30'],
            ['app_no' => 'APP000000163','chi_name' => '陳文瑜','eng_name' => 'Chen Wen Yu','mobile' => '55137118','role' => '30'],
            ['app_no' => 'APP000000164','chi_name' => NULL,'eng_name' => 'DITTA ALLAH','mobile' => '64005385','role' => '30'],
            ['app_no' => 'APP000000165','chi_name' => '林應葵','eng_name' => 'Lin Yingkui','mobile' => '53451578','role' => '30'],
            ['app_no' => 'APP000000166','chi_name' => '楊艷','eng_name' => 'Yang Yan','mobile' => '55986635','role' => '30'],
            ['app_no' => 'APP000000167','chi_name' => '李麗','eng_name' => 'Li Li','mobile' => '52253996','role' => '30'],
            ['app_no' => 'APP000000168','chi_name' => '王志英','eng_name' => '','mobile' => '56228255','role' => '30'],
            ['app_no' => 'APP000000169','chi_name' => '曾凱敏','eng_name' => '','mobile' => '62889210','role' => '30'],
            ['app_no' => 'APP000000170','chi_name' => '譚文穎','eng_name' => '','mobile' => '98213191','role' => '30'],
            ['app_no' => 'APP000000171','chi_name' => '李達龍','eng_name' => '','mobile' => '92327731','role' => '30'],
            ['app_no' => 'APP000000172','chi_name' => '劉偉強','eng_name' => '','mobile' => '60634110','role' => '30'],
            ['app_no' => 'APP000000173','chi_name' => '林傑桃','eng_name' => '','mobile' => '66205807','role' => '30'],
            ['app_no' => 'APP000000174','chi_name' => '王和碧','eng_name' => '','mobile' => '65406919','role' => '30'],
            ['app_no' => 'APP000000175','chi_name' => '伍貫鳴','eng_name' => '','mobile' => '51122567','role' => '30'],
            ['app_no' => 'APP000000176','chi_name' => '謝美元','eng_name' => '','mobile' => '55332311','role' => '30'],
            ['app_no' => 'APP000000177','chi_name' => '翁勝進','eng_name' => '','mobile' => '98252868','role' => '30'],
            ['app_no' => 'APP000000178','chi_name' => '張超群','eng_name' => '','mobile' => '97181796','role' => '30'],
            ['app_no' => 'APP000000179','chi_name' => '朱永泉','eng_name' => '','mobile' => '98792379','role' => '30'],
            ['app_no' => 'APP000000180','chi_name' => '黃德明','eng_name' => '','mobile' => '55405006','role' => '30'],
            ['app_no' => 'APP000000181','chi_name' => '馮家聰','eng_name' => '','mobile' => '93210733','role' => '30'],
            ['app_no' => 'APP000000182','chi_name' => '黎明','eng_name' => '','mobile' => '54700685','role' => '30'],
            ['app_no' => 'APP000000183','chi_name' => '李崇華','eng_name' => '','mobile' => '95222219','role' => '30'],
            ['app_no' => 'APP000000184','chi_name' => '林健華','eng_name' => '','mobile' => '69938407','role' => '30'],
            ['app_no' => 'APP000000185','chi_name' => '羅文迅','eng_name' => '','mobile' => '90576083','role' => '30'],
            ['app_no' => 'APP000000186','chi_name' => '陶惠儀','eng_name' => '','mobile' => '98227973','role' => '30'],
            ['app_no' => 'APP000000187','chi_name' => '梁浩忠','eng_name' => '','mobile' => '61103552','role' => '30'],
            ['app_no' => 'APP000000188','chi_name' => '陳苑彤','eng_name' => '','mobile' => '64748277','role' => '30'],
            ['app_no' => 'APP000000189','chi_name' => '陳樂天','eng_name' => '','mobile' => '51113700','role' => '30'],
            ['app_no' => 'APP000000190','chi_name' => '梁浩榮','eng_name' => '','mobile' => '64135581','role' => '30'],
            ['app_no' => 'APP000000191','chi_name' => '趙文達','eng_name' => '','mobile' => '93876191','role' => '30'],
            ['app_no' => 'APP000000192','chi_name' => '張木金','eng_name' => '','mobile' => '60648676','role' => '30'],
            ['app_no' => 'APP000000193','chi_name' => '李尤渠','eng_name' => '','mobile' => '55888871','role' => '30'],
            ['app_no' => 'APP000000194','chi_name' => '周賽嫦','eng_name' => '','mobile' => '63523066','role' => '30'],
            ['app_no' => 'APP000000195','chi_name' => '黃美貞 ','eng_name' => '','mobile' => '97832345','role' => '30'],
            ['app_no' => 'APP000000196','chi_name' => '梁書銘','eng_name' => '','mobile' => '91486335','role' => '30'],
            ['app_no' => 'APP000000197','chi_name' => '倪少威','eng_name' => '','mobile' => '61344382','role' => '30'],
            ['app_no' => 'APP000000198','chi_name' => '楊智英','eng_name' => '','mobile' => '55782263','role' => '30'],
            ['app_no' => 'APP000000199','chi_name' => '苳培林','eng_name' => '','mobile' => '61115603','role' => '30'],
            ['app_no' => 'APP000000200','chi_name' => '朱基業','eng_name' => '','mobile' => '95276988','role' => '30'],
            ['app_no' => 'APP000000201','chi_name' => '楊幹佳','eng_name' => '','mobile' => '61312255','role' => '30'],
            ['app_no' => 'APP000000202','chi_name' => '許小潔','eng_name' => '','mobile' => '66597116','role' => '30'],
            ['app_no' => 'APP000000203','chi_name' => '羅苗','eng_name' => '','mobile' => '64328695','role' => '30'],
            ['app_no' => 'APP000000204','chi_name' => '鄺耀星','eng_name' => '','mobile' => '90967511','role' => '30'],
            ['app_no' => 'APP000000205','chi_name' => '連瑞和','eng_name' => '','mobile' => '93889851','role' => '30'],
            ['app_no' => 'APP000000206','chi_name' => '黎俊賢','eng_name' => '','mobile' => '91842313','role' => '30'],
            ['app_no' => 'APP000000207','chi_name' => '洪美儀','eng_name' => '','mobile' => '60777403','role' => '30'],
            ['app_no' => 'APP000000208','chi_name' => '黃子燊','eng_name' => '','mobile' => '68508658','role' => '30'],
            ['app_no' => 'APP000000209','chi_name' => '區偉民','eng_name' => '','mobile' => '62203441','role' => '30'],
            ['app_no' => 'APP000000210','chi_name' => '陳廣德','eng_name' => '','mobile' => '97120906','role' => '30'],
            ['app_no' => 'APP000000211','chi_name' => '王子龍','eng_name' => '','mobile' => '64452315','role' => '30'],
            ['app_no' => 'APP000000212','chi_name' => '李倩','eng_name' => '','mobile' => '54011261','role' => '30'],
            ['app_no' => 'APP000000213','chi_name' => '陳鳯儀','eng_name' => '','mobile' => '59147852','role' => '30'],
            ['app_no' => 'APP000000214','chi_name' => '吳嘉喬','eng_name' => '','mobile' => '97420663','role' => '30'],
            ['app_no' => 'APP000000215','chi_name' => '徐嘉碧','eng_name' => '','mobile' => '98189283','role' => '30'],
            ['app_no' => 'APP000000216','chi_name' => '劉嘉雯','eng_name' => '','mobile' => '98782518','role' => '30'],
            ['app_no' => 'APP000000217','chi_name' => '何鈺顥','eng_name' => '','mobile' => '91621012','role' => '30'],
            ['app_no' => 'APP000000218','chi_name' => '李燁姍','eng_name' => '','mobile' => '97185623','role' => '30'],
            ['app_no' => 'APP000000219','chi_name' => '曾倩婷','eng_name' => '','mobile' => '64000887','role' => '30'],
            ['app_no' => 'APP000000220','chi_name' => '黎曼玲','eng_name' => '','mobile' => '94423885','role' => '30'],
            ['app_no' => 'APP000000221','chi_name' => '李卓瑩','eng_name' => '','mobile' => '96628175','role' => '30'],
            ['app_no' => 'APP000000222','chi_name' => '文雪良','eng_name' => '','mobile' => '62380880','role' => '30'],
            ['app_no' => 'APP000000223','chi_name' => '陳繼忠','eng_name' => '','mobile' => '66410707','role' => '30'],
            ['app_no' => 'APP000000224','chi_name' => '陳仲賢','eng_name' => '','mobile' => '95157456','role' => '30'],
            ['app_no' => 'APP000000225','chi_name' => '陳麗玲','eng_name' => '','mobile' => '51135966','role' => '30'],
            ['app_no' => 'APP000000226','chi_name' => '鄭栩栖','eng_name' => '','mobile' => '65861205','role' => '30'],
            ['app_no' => 'APP000000227','chi_name' => '鄧福怡','eng_name' => '','mobile' => '61686471','role' => '30'],
            ['app_no' => 'APP000000228','chi_name' => '劉德慧','eng_name' => '','mobile' => '65619218','role' => '30'],
            ['app_no' => 'APP000000229','chi_name' => '梁慧敏','eng_name' => '','mobile' => '62069128','role' => '30'],
            ['app_no' => 'APP000000230','chi_name' => '甄秀慧','eng_name' => '','mobile' => '92537755','role' => '30'],
            ['app_no' => 'APP000000231','chi_name' => '魏君玉','eng_name' => '','mobile' => '55427934','role' => '30'],
            ['app_no' => 'APP000000232','chi_name' => '馮美華','eng_name' => '','mobile' => '98401772','role' => '30'],
            ['app_no' => 'APP000000233','chi_name' => '蘇銘心','eng_name' => '','mobile' => '54461403','role' => '30'],
            ['app_no' => 'APP000000234','chi_name' => '譚蓓欣','eng_name' => '','mobile' => '68082030','role' => '30'],
            ['app_no' => 'APP000000235','chi_name' => '鄭秀英','eng_name' => '','mobile' => '66701184','role' => '30'],
            ['app_no' => 'APP000000236','chi_name' => '溫惠英','eng_name' => '','mobile' => '54227872','role' => '30'],
            ['app_no' => 'APP000000237','chi_name' => '鄺卓謙','eng_name' => '','mobile' => '62789110','role' => '30'],
            ['app_no' => 'APP000000238','chi_name' => '陳漢燊','eng_name' => '','mobile' => '62230029','role' => '30'],
            ['app_no' => 'APP000000239','chi_name' => '戴家斌','eng_name' => '','mobile' => '92980109','role' => '30'],
            ['app_no' => 'APP000000240','chi_name' => '蔣國經','eng_name' => '','mobile' => '61552418','role' => '30'],
            ['app_no' => 'APP000000241','chi_name' => '李中正','eng_name' => '','mobile' => '51621256','role' => '30'],
            ['app_no' => 'APP000000242','chi_name' => '曾俊喬','eng_name' => '','mobile' => '92203987','role' => '30'],
            ['app_no' => 'APP000000243','chi_name' => '何家裕','eng_name' => '','mobile' => '61967183','role' => '30'],
            ['app_no' => 'APP000000244','chi_name' => '徐鎮鴻','eng_name' => '','mobile' => '63584451','role' => '30'],
            ['app_no' => 'APP000000245','chi_name' => '何嘉偉','eng_name' => '','mobile' => '92445837','role' => '30'],
            ['app_no' => 'APP000000246','chi_name' => '陳孟申','eng_name' => '','mobile' => '69353847','role' => '30'],
            ['app_no' => 'APP000000247','chi_name' => '陳柏希','eng_name' => '','mobile' => '93136166','role' => '30'],
            ['app_no' => 'APP000000248','chi_name' => '萬世豪','eng_name' => '','mobile' => '62835528','role' => '30'],
            ['app_no' => 'APP000000249','chi_name' => '李健恒','eng_name' => '','mobile' => '61666010','role' => '30'],
            ['app_no' => 'APP000000250','chi_name' => '李添發','eng_name' => '','mobile' => '65818415','role' => '30'],
            ['app_no' => 'APP000000251','chi_name' => '徐偉榮','eng_name' => '','mobile' => '94337444','role' => '30'],
            ['app_no' => 'APP000000252','chi_name' => '江樂林','eng_name' => '','mobile' => '54221427','role' => '30'],
            ['app_no' => 'APP000000253','chi_name' => '黃華丰','eng_name' => '','mobile' => '56036567','role' => '30'],
            ['app_no' => 'APP000000254','chi_name' => '甘俊豪','eng_name' => '','mobile' => '65744118','role' => '30'],
            ['app_no' => 'APP000000255','chi_name' => '歐陽大山','eng_name' => '','mobile' => '91374141','role' => '30'],
            ['app_no' => 'APP000000256','chi_name' => '胡敬耀','eng_name' => '','mobile' => '67363380','role' => '30'],
            ['app_no' => 'APP000000257','chi_name' => '王清平','eng_name' => '','mobile' => '54850604','role' => '30'],
            ['app_no' => 'APP000000258','chi_name' => '張紅華','eng_name' => '','mobile' => '60488754','role' => '30'],
            ['app_no' => 'APP000000259','chi_name' => '陳潔儀','eng_name' => '','mobile' => '62290627','role' => '30'],
            ['app_no' => 'APP000000260','chi_name' => '何佩玲','eng_name' => '','mobile' => '92383219','role' => '30'],
            ['app_no' => 'APP000000261','chi_name' => '賈姬絲','eng_name' => '','mobile' => '96239284','role' => '30'],
            ['app_no' => 'APP000000262','chi_name' => '鄒美倩','eng_name' => '','mobile' => '95326558','role' => '30'],
            ['app_no' => 'APP000000263','chi_name' => '曾曉忻','eng_name' => '','mobile' => '91777989','role' => '30'],
            ['app_no' => 'APP000000264','chi_name' => '蘇慧敏','eng_name' => '','mobile' => '62247062','role' => '30'],
            ['app_no' => 'APP000000265','chi_name' => '胡靜婷','eng_name' => '','mobile' => '90826122','role' => '30'],
            ['app_no' => 'APP000000266','chi_name' => '魏靜敏','eng_name' => '','mobile' => '95206928','role' => '30'],
            ['app_no' => 'APP000000267','chi_name' => '林映妮','eng_name' => '','mobile' => '65338680','role' => '30'],
            ['app_no' => 'APP000000268','chi_name' => '胡綺琳','eng_name' => '','mobile' => '97031523','role' => '30'],
            ['app_no' => 'APP000000269','chi_name' => '張靜怡','eng_name' => '','mobile' => '66942113','role' => '30'],
            ['app_no' => 'APP000000270','chi_name' => '林茂森','eng_name' => '','mobile' => '91870386','role' => '30'],
            ['app_no' => 'APP000000271','chi_name' => '盧卓豐','eng_name' => '','mobile' => '62467261','role' => '30'],
            ['app_no' => 'APP000000272','chi_name' => '蘇家俊','eng_name' => '','mobile' => '68443236','role' => '30'],
            ['app_no' => 'APP000000273','chi_name' => '羅俊輝','eng_name' => '','mobile' => '96700080','role' => '30'],
            ['app_no' => 'APP000000274','chi_name' => '黃淳楨','eng_name' => '','mobile' => '62332045','role' => '30'],
            ['app_no' => 'APP000000275','chi_name' => '馬美玲','eng_name' => '','mobile' => '62865726','role' => '30'],
            ['app_no' => 'APP000000276','chi_name' => '鄧俊謙','eng_name' => '','mobile' => '54114949','role' => '30'],
            ['app_no' => 'APP000000277','chi_name' => '冼佩敏','eng_name' => '','mobile' => '63863444','role' => '30'],
            ['app_no' => 'APP000000278','chi_name' => '曾婷','eng_name' => '','mobile' => '56150230','role' => '30'],
            ['app_no' => 'APP000000279','chi_name' => '王莉施','eng_name' => '','mobile' => '61874390','role' => '30'],
            ['app_no' => 'APP000000280','chi_name' => '簡海儀','eng_name' => '','mobile' => '68748488','role' => '30'],
            ['app_no' => 'APP000000281','chi_name' => '何淑華','eng_name' => '','mobile' => '90726397','role' => '30'],
            ['app_no' => 'APP000000282','chi_name' => '陳文意','eng_name' => '','mobile' => '97251276','role' => '30'],
            ['app_no' => 'APP000000283','chi_name' => '盧佩儀','eng_name' => '','mobile' => '97329011','role' => '30'],
            ['app_no' => 'APP000000284','chi_name' => '劉善悠','eng_name' => '','mobile' => '65406026','role' => '30'],
            ['app_no' => 'APP000000285','chi_name' => '黃小玲','eng_name' => '','mobile' => '97157638','role' => '30'],
            ['app_no' => 'APP000000286','chi_name' => '俞倩婷','eng_name' => '','mobile' => '92731461','role' => '30'],
            ['app_no' => 'APP000000287','chi_name' => '王朝偉','eng_name' => '','mobile' => '59326507','role' => '30'],
            ['app_no' => 'APP000000288','chi_name' => '溫緯麟','eng_name' => '','mobile' => '94808912','role' => '30'],
            ['app_no' => 'APP000000289','chi_name' => '蕭健維','eng_name' => '','mobile' => '53662705','role' => '30'],
            ['app_no' => 'APP000000290','chi_name' => '陳威文','eng_name' => '','mobile' => '54951971','role' => '30'],
            ['app_no' => 'APP000000291','chi_name' => '龍日興','eng_name' => '','mobile' => '91682132','role' => '30'],
            ['app_no' => 'APP000000292','chi_name' => '羅汶俊','eng_name' => '','mobile' => '66215335','role' => '30'],
            ['app_no' => 'APP000000293','chi_name' => '譚海鍵','eng_name' => '','mobile' => '96285411','role' => '30'],
            ['app_no' => 'APP000000294','chi_name' => '陳建安','eng_name' => '','mobile' => '95101770','role' => '30'],
            ['app_no' => 'APP000000295','chi_name' => '曾憲峰','eng_name' => '','mobile' => '62800559','role' => '30'],
            ['app_no' => 'APP000000296','chi_name' => '陳家俊','eng_name' => '','mobile' => '93866869','role' => '30'],
            ['app_no' => 'APP000000297','chi_name' => '陳偉安','eng_name' => '','mobile' => '95371725','role' => '30'],
            ['app_no' => 'APP000000298','chi_name' => '林瑞珊','eng_name' => '','mobile' => '91220597','role' => '30'],
            ['app_no' => 'APP000000299','chi_name' => '文睿嵐','eng_name' => '','mobile' => '92331122','role' => '30'],
            ['app_no' => 'APP000000300','chi_name' => '林諾宜','eng_name' => '','mobile' => '69905641','role' => '30'],
            ['app_no' => 'APP000000301','chi_name' => '李金燕','eng_name' => '','mobile' => '95334163','role' => '30'],
            ['app_no' => 'APP000000302','chi_name' => '高詩詠','eng_name' => '','mobile' => '63096080','role' => '30'],
            ['app_no' => 'APP000000303','chi_name' => '石積琰','eng_name' => '','mobile' => '93850377','role' => '30'],
            ['app_no' => 'APP000000304','chi_name' => '李嫻','eng_name' => '','mobile' => '93325805','role' => '30'],
            ['app_no' => 'APP000000305','chi_name' => '曾婉華','eng_name' => '','mobile' => '66965278','role' => '30'],
            ['app_no' => 'APP000000306','chi_name' => '溫淑芳','eng_name' => '','mobile' => '63088307','role' => '30'],
            ['app_no' => 'APP000000307','chi_name' => '張立群','eng_name' => '','mobile' => '97605152','role' => '30'],
            ['app_no' => 'APP000000308','chi_name' => '劉梅嬌','eng_name' => '','mobile' => '51161273','role' => '30'],
        ]);
    }





































































































    public function down()
    {
        // $this->dropTable('{{%user}}');
    }
}
