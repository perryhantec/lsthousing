<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_type1}}`.
 */
class m211104_081033_create_page_type1_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_type1}}', [
            'id'                     => $this->primaryKey(),
            'MID'                    => $this->integer()->unsigned(),
            'content_tw'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_cn'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_en'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'file_names'             => $this->text(),
            'status'                 => $this->tinyInteger()->defaultValue(1),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer(),
        ]);

        $this->batchInsert('{{%page_type1}}', [
            'id',
            'MID',
            'content_tw',
            'content_cn',
            'content_en',
            'file_names',
            'status',
            'created_at',
            'updated_at',
            'updated_UID',
        ], [
            array('id' => '1','MID' => '7','content_tw' => '<ol>
            <li>「樂屋」申請資格</li>
        </ol>
        
        <p>必須符合以下基本資格:</p>
        
        <ul>
            <li>正輪候公屋 3 年或以上</li>
            <li>申請人必須為年滿 18 歲的香港居民</li>
            <li>家庭總入息低於家庭住戶每月收入中位數 55% 或 正領取綜援之家庭優先</li>
            <li>急需社區支援 或 居住於惡劣環境之家庭</li>
        </ul>
        
        <p>&nbsp;</p>
        
        <ol>
            <li value="2">「樂屋」租金</li>
        </ol>
        
        <ul>
            <li>現正領取綜緩家庭：租金津貼上限</li>
            <li>低收入家庭：因應家庭總入息、家庭情況及背景而定</li>
        </ul>
        
        <p>&nbsp;</p>
        
        <ol>
            <li value="3">「樂屋」可以容納多少人居住?</li>
        </ol>
        
        <ul>
            <li>一般人均面積約 7 平方米</li>
            <li>如 140 平方呎，建議入住人數為 2 人</li>
        </ul>
                
        <p>&nbsp;</p>
        
        <ol>
            <li value="4">「樂屋」水電費如何收取?</li>
        </ol>
        
        <ul>
            <li>一般設獨立電錶及水錶，住戶自行繳交</li>
            <li>酒店式「樂屋」之租金已包括所有電費、水費和煤氣費用</li>
        </ul>
        ','content_cn' => NULL,'content_en' => '','file_names' => '[]','status' => '1','created_at' => '2021-11-17 13:05:02','updated_at' => '2021-11-17 13:05:02','updated_UID' => '1'),
        array('id' => '2','MID' => '12','content_tw' => '<p>唐女士原本與就讀中學孫女同住深水埗一個一百呎的劏房單位, 月租約$6,800, 兩婆孫相依為命, 唐女士最擔心是孫女的學業和成長, 「以往住在劏房, 連一張書枱也放不下」。唐女士和孫女後來入住了樂善堂小學社會房屋「樂屋」, 終於有書枱給孫女讀書,「孫女以往好少笑容, 入住後見到她心情愉快, 成績也進步了不少」。唐女士在「樂屋」裡與其他鄰里守望相助, 不時照顧鄰居的孩子, 還一起種植不同菜菓, 是孩子們的好婆婆。她表示自己始終會老, 希望孫女能學有所成, 將來能有份工作, 獨立生活, 貢獻社會。</p>
    
    <p>劉太和劉先生育有一對兒子, 原本住在九龍區劏房百多呎地方, 月租約$7,000, 丈夫無業, 一家四口僅靠從事零售業的劉太月入$12,000收入過活, 扣除租房後, 只餘下$5,000生活。劉氏夫婦後來申請並入住了位於九龍城福佬村道, 由愛心地產商捐出樓宇, 並由樂善堂翻新之「樂屋」, 月租為$4,000。由於樂善堂轄下單位逾60個, 工作機會很多, 最後為劉生尋找了一份雜務員的工作, 收入約$15,000。劉生對於特區政府和樂善堂攜手合作, 為他們一家四口建造一個安樂蝸並給予工作機會, 形容猶如「中了六合彩」, 現在他們一家已被編配了公屋, 兩個兒子對於過渡上公屋時間有舒適住房居住, 十分感恩, 並表示長大後會回饋社會。</p>
    ','content_cn' => NULL,'content_en' => '','file_names' => '{"iEuzi_u__MNYA1gz5ELeZuVG9HvXtoQZ_1637127515.jpg":"DSCF6607-edit","6TLcA51Y427u1d35aBXN7aJaS5ofoWnc_1637127165.jpg":"劉先生個案相片.jpg"}','status' => '1','created_at' => '2021-11-17 13:41:38','updated_at' => '2021-11-17 13:41:38','updated_UID' => '1'),
        array('id' => '3','MID' => '13','content_tw' => '<p><strong><span style="font-size:20px;">關於樂屋</span></strong></p>
    ','content_cn' => NULL,'content_en' => '','file_names' => '{"8pyx-ZrLB3yAQTkxyat1vqOCw2WLhAMg_1637127648.jpg":"Image"}','status' => '1','created_at' => '2021-11-17 13:42:41','updated_at' => '2021-11-17 13:42:41','updated_UID' => '1')
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_type1}}');
    }
}
