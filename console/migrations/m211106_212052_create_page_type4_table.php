<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_type4}}`.
 */
class m211106_212052_create_page_type4_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_type4}}', [
            'id'                     => $this->primaryKey(),
            'MID'                    => $this->integer()->unsigned(),
            'display_at'             => $this->date()->notNull(),
            'author'                 => $this->string(),
            'category_id'            => $this->integer()->unsigned(),
            'title_tw'               => $this->string(),
            'title_cn'               => $this->string(),
            'title_en'               => $this->string(),
            'summary_tw'             => $this->text(),
            'summary_cn'             => $this->text(),
            'summary_en'             => $this->text(),
            'content_tw'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_cn'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'content_en'             => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'youtube_id'             => $this->string(),
            'image_file_name'        => $this->text(),
            'file_names'             => $this->text(),
            'file_names_backup'      => $this->text(),
            'view_counter'           => $this->integer(10)->unsigned()->defaultValue(0),
            'status'                 => $this->tinyInteger()->defaultValue(1),
            'created_at'             => $this->dateTime().' DEFAULT NOW()',
            'updated_at'             => $this->timestamp(),
            'updated_UID'            => $this->integer(),
        ]);

        $this->batchInsert('{{%page_type4}}', [
            'id',
            'MID',
            'display_at',
            'author',
            'category_id',
            'title_tw',
            'title_cn',
            'title_en',
            'summary_tw',
            'summary_cn',
            'summary_en',
            'content_tw',
            'content_cn',
            'content_en',
            'youtube_id',
            'image_file_name',
            'file_names',
            'file_names_backup',
            'view_counter',
            'status',
            'created_at',
            'updated_at',
            'updated_UID',
        ], [
            array('id' => '1','MID' => '3','display_at' => '2021-10-09','author' => NULL,'category_id' => NULL,'title_tw' => '樂善堂2年內推1542伙過渡房屋','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '<p>剛出爐的《施政報告》增撥116億元、提供多5,000個至20,000個過渡性社會房屋，短期解決了一批輪候公屋家庭的經濟和住屋壓力。九龍樂善堂預期，在未來2年內，樂善堂提供至少1,542個新的過渡性社會房屋單位，當中包括改裝荃灣象山邨校舍作社會房屋、在彩虹彩興路興建組合屋、以及由會德豐免費租出大埔黃魚灘用地興建組合屋等。</p>

            <p>樂善堂分享一個個案，指一名70多歲鄧婆婆和患有眼疾的丈夫，以及就讀小學的孫兒，一家三口原本居於九龍城土瓜灣一幢唐樓九樓的天台屋，2018年颱風山竹襲港，鄧婆婆的屋頂被狂風吹襲，全個屋頂被吹起，全屋水浸，傢俬和日用品被浸至破爛，為擋風雨，兩老和孫兒合力撿拾一些棄掉的帆布製的橫額及塑膠製的廣告展板蓋著屋頂，臨時阻擋風雨。</p>
            
            <p>破爛的天台屋，面積100多平方呎，鄧婆婆當時仍以$5,000月租租用，每日接送孫兒上學放學、或陪同丈夫覆診，需要行足9層樓，致雙膝和全身骨痛。天台屋的環境狹窄，又有蟲鼠出沒，孫兒日常只在上下隔床活動，包括食飯、學習、玩玩具等，影響到他的社交和學習能力。</p>
            
            <p>樂善堂當年在運輸及房屋局推動，愛心地產商恆基以$1象徴式租金租出九龍城福佬村道全幢唐樓，推出了全港首個過渡性社會房屋「樂屋」，社工家訪後，安排鄧婆婆一家三口入住過渡性社會房屋。</p>
            
            <p>鄧婆婆一家其後再入住樂善堂位於九龍城龍崗道第一個改裝學校作過渡性社會房屋項目「樂善堂小學樂屋」。最近，鄧婆婆一家獲房署安排了深水埗區的公共屋邨，終於實現了「上樓之夢」，鄧婆婆形容人生中1次六合彩已經好幸運，入住了樂善堂過渡性社會房屋，每月租金減半，空間大了一倍，孫兒變得有心機讀書，又認識了一班朋友，現在再上公屋，簡直是中第2次六合彩，非常幸運，感恩有特區政府和樂善堂提供過渡性社會房屋，她期望孫兒長大後能回饋社會。</p>
            
            <p><a href="https://www.facebook.com/headlinehk" target="_blank">想睇最新消息，立即 like 頭條日報FB專頁！&gt;&gt;</a></p>
            
            <ul>
                <li><a href="https://hd.stheadline.com/news/realtime/pp/2157436/" target="_blank">恒基元朗錦田東匯路項目申建過渡性房屋</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2162380/" target="_blank">酒店賓館轉過渡屋 批出資助531間</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2186340/" target="_blank">調查指3成劏房戶無意住過渡房屋 嫌租期短及搬遷困難</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2197165/" target="_blank">樂善堂首個酒店式「樂屋」 今正式投入服務</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2209357/" target="_blank">九龍樂善堂獲頒傑出抗逆貢獻管理大獎 以嘉許抗疫貢獻</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2220973/" target="_blank">深水埗過渡性房屋「雅匯」可申請 提供205個單位料明年2月入伙</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2241529/" target="_blank">兩過渡房屋項目獲批資助 涉款7.63億元</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2245534/" target="_blank">元朗錦上路站旁建逾千過渡屋 首批2023年中入伙</a></li>
                <li><a href="https://hd.stheadline.com/news/realtime/hk/2249470/" target="_blank">民建聯提多項建議 促10年內告別劏房大增公營房屋</a></li>
            </ul>
            
            <hr />
            <p style="text-align: center;">總機 : 2798 2323 日報(祇適用廣告查詢) : 3181 3666 網上(祇適用廣告查詢) : 3181 3666<br />
            廣告查詢電郵 : adv@hkheadline.com<br />
            私隱政策聲明 │ 使用條款 │ QR Code 使用條款及細則 │ 版權告示<br />
            聯絡我們： web_info@hkheadline.com Copyright 2021 hkheadline.com. All rights reserved.</p>
            ','content_cn' => NULL,'content_en' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '{"q55HLFxPDSVpEkxu-1vSEdhHoWInYInE_1637034928.jpg":"鄧婆婆孫兒入住了樂善堂社會房屋後，透過一班來自HART義工的「樂善學舍」結識了一班好朋友。","iVNtXfYWX0C2fm0vYS7n_YisqmJ_niec_1637034928.jpg":"鄧婆婆孫兒入住了樂善堂社會房屋後，透過一班來自HART義工的「樂善學舍」結識了一班好朋友。"}','file_names_backup' => NULL,'view_counter' => '0','status' => '1','created_at' => '2021-11-16 11:56:28','updated_at' => '2021-11-16 11:56:28','updated_UID' => '1'),
              array('id' => '2','MID' => '3','display_at' => '2021-10-06','author' => NULL,'category_id' => NULL,'title_tw' => '【施政報告2021】九龍樂善堂：歡迎政府增加過渡性房屋供應 冀 更多發展商借地建屋','title_cn' => '','title_en' => '','summary_tw' => '','summary_cn' => NULL,'summary_en' => '','content_tw' => '<p>今年度《施政報告》提出增加本港過渡性房屋供應，由1.5萬個增至2萬個, 並投放約116億元興建。九龍樂善堂對此表示歡迎，並相信可令更多輪候公屋之基層家庭受惠。</p>
            
            <p>樂善堂總幹事劉愛詩表示，每當有此類項目推出，超額申請至少10倍或以上，可見基層對住屋需求十分殷切。她強調，社會房屋最重要是紓緩基層住屋的經濟壓力。根據組織過往所錄數字，入住社會房屋後，家庭經濟壓力減少至少3成至5成，且為家庭關係和兒童成長提供正面效果。她又期望將來會有更多發展商借出土地興建社會房屋；又建議運輸及房屋局善用閒置地方，撥出土地或建築物予非牟利機構，合作增加此類住屋供應，惠及基層市民。</p>
            
            <p>據了解，樂善堂2017年起以自資形式推行首個樂善堂社會房屋計劃「樂屋」項目，積極與政府及各地區組織，探討善用政府、發展商及私人閒置建築及 土地，興建過渡性社會房屋。至今營運及規劃的項目，包括 4期「樂屋」、改建樂善堂小學、宋皇臺道及土瓜灣道組合屋計劃、全港首個酒店改作過渡性社會房屋項目、前荃灣信義學校項目、彩興路組合屋項目、大埔組合屋項目等。</p>
            
            <p>責任編輯：唐健恒</p>
            ','content_cn' => NULL,'content_en' => '','youtube_id' => NULL,'image_file_name' => '','file_names' => '{"9U8302GM4E36MtDvLfM2Wzk6ISntUA25_1637035952.jpg":"樂善堂首個社會房屋計劃「樂屋」。","XBpJqYet-W_1DB0VZURXKnUmbHpkohIf_1637035952.jpg":"樂善堂組合屋項目。","-qHtGA52zF4xgycdDWDFzQKEfRSiVSz__1637035952.jpg":"樂善堂小學示範單位","sWxFuO_f9WWuguIVArFC73tuqEDlROOl_1637035952.jpg":"樂善堂小學","bgjANUhTly7YJYxRZSmZTxorhhXnSH-p_1637035952.jpg":"樂善堂酒店項目。","_EOKY1sdR_E148HSGxLyXuSQ3bj0uyQZ_1637035952.jpg":"樂善堂總幹事劉愛詩 (資料圖片)"}','file_names_backup' => NULL,'view_counter' => '0','status' => '1','created_at' => '2021-11-16 12:15:49','updated_at' => '2021-11-16 12:15:49','updated_UID' => '1')
        ]);        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_type4}}');
    }
}
