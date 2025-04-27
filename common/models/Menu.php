<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\imagine\Image;

/**
 * This is the model class for table "menu".
 */
 class Menu extends \common\components\BaseActiveRecord
{

    const CROP_WIDTH = 1920;
    const CROP_HEIGHT = 300;
    const TOP_BANNER = true;
    const HAVE_ICON = true;
    const MAX_LAYER = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [Yii::$app->config->getAllLanguageAttributes('name'), 'trim'],
            [['MID', 'seq', 'home_seq', 'page_type', 'link_target', 'display_home', 'status', 'show_after_login', 'updated_UID'], 'integer'],
            [Yii::$app->config->getAllLanguageAttributes('name'), 'required'],
            [['url'], 'unique'],
            [['url', 'page_type'], 'required'],
            [['link'], 'string'],
            [['url', 'name_tw', 'name_cn', 'name_en', 'banner_image_file_name', 'icon_file_name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'MID' => Yii::t('app', 'Belong to'),
            'name_tw' => Yii::t('app', 'Name').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'name_cn' => Yii::t('app', 'Name').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'name_en' => Yii::t('app', 'Name').' '.Yii::t('app', '(English Version)'),
            'url' => Yii::t('app', 'URL'),
            'page_type' => Yii::t('app', 'Page Type'),
            'link' => Yii::t('app', 'Link'),
            'link_target' => Yii::t('app', 'New Window'),
            'display_member' => Yii::t('app', 'For Member Only'),
            'display_home' => Yii::t('app', 'Show In Home Page'),
            'status' => Yii::t('app', 'Status'),
            'show_after_login' => '登入後才顯示',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated Dt'),
            'updated_UID' => Yii::t('app', 'Updated UID'),
            'image_file' => Yii::t('app', 'Banner'),
        ];
    }

    public function updateSeq($MID=NULL) {
        $models = Menu::find()
            ->where(['MID'=>$MID, 'status' => 1])
            ->orderBy('seq')
            ->all();
        $seq = 0;
        foreach ($models as $model) {
            $model->seq = $seq;
            $model->save();
            $seq++;
        }
    }

    public function getLayer(){
        $type = 0;
        $_menu = $this;

        do {
            $type++;
        } while($_menu = $_menu->menu);

        return $type;
    }
    public function getType(){
        return $this->getLayer();
    }

    public function getIconImagePath(){
        return Config::MenuIconImagePath();
    }
    public function getImagePath(){
        return Config::MenuBannerImagePath();
    }

    public function getIconDisplayPath(){
        if ($this->icon_file_name != "")
            return Config::MenuIconImageDisplayPath().$this->icon_file_name;
    }

    public function getMenuNumbers($MID){
        $count = count(Menu::findAll(['MID'=>$MID, 'status' => 1]));
        return $count;
    }

    public function getMenu(){
        return $this->hasOne(Menu::className(), ['id' => 'MID']);
    }

    public function getTopMenu(){
        $result = $this;
        while ($result->menu != null) {
            $result = $result->menu;
        }
        return $result;
    }

    public function getSubMenu(){
        return $this->hasMany(Menu::className(), ['MID' => 'id']);
    }

    public function getActiveSubMenu(){
        return $this->getSubMenu()->andWhere(['status' => 1]);
    }

    public function getName() {
        if (Yii::$app->language == 'en')
          return $this->name_en;
        else if (Yii::$app->language == 'zh-CN')
          return $this->name_cn;
        else
          return $this->name_tw;
    }

    public function getAllSubMenu() {
        $result = [];
        if ($this->menu != null) {
            $result = array_merge($this->menu->getAllSubMenu(), [$this->menu]);
        }
        return $result;
    }

    public function getNameWithSubmenu($separator = " > ") {
        if ($this->menu != null) {
            return $this->menu->getNameWithSubmenu($separator).$separator.$this->name;
        }
        return $this->name;
    }

    public function getAllLanguageName() {
        $result = [];
        foreach (Yii::$app->config->getAllLanguageAttributes('name') as $attr) {
            $result[] = $this->{$attr};
        }
        return implode(' ', $result);
    }

    public function getRoute() {
        return $this->url;
    }

    public function getAUrl() {
        // return $this->page_type === 0 ? ($this->link == '' ? "javascript:;" : $this->link) : ['/'.$this->url];
        return $this->page_type === 0 ? ($this->link == '' ? "javascript:;" : ['/'.$this->link]) : ['/'.$this->url];
    }

    public function getIsActive() {
        return (isset(Yii::$app->params['page_route']) && $this->route == Yii::$app->params['page_route']) ||
            ($this->page_type === 0 && $this->link == Yii::$app->request->url);
    }

    public function getAllTopMenus() {
        return $this->menu !== null ? ArrayHelper::merge([$this->menu], $this->menu->menu !== null ? [$this->menu->menu] : []) : [];
    }

    public function getAllChildMenus($activeOnly=true) {
        $result = [];

        $_subMenu = $this->getSubMenu();
        if ($activeOnly)
            $_subMenu->andWhere(['status' => 1]);

        foreach ($_subMenu->all() as $_subMenu_model) {
            $result[] = $_subMenu_model;
            $result = ArrayHelper::merge($result, $_subMenu_model->getAllChildMenus($activeOnly));
        }

        return $result;
    }

    public static function getAllMenus($MID=null, $activeOnly=true, $parentOnly=false) {
        return self::find()->where(['status' => $activeOnly ? 1 : 0, 'MID' => $MID])->orderBy(['seq' => SORT_ASC])->all();
    }

    public static function getAllMenusForFrontendNavX($model = null) {
        $result = null;
        // $_subMenus = $model == null ? self::find()->where(['MID' => null, 'status' => 1])->orderBy(['seq' => SORT_ASC])->all() : $model->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all();
        if (Yii::$app->user->isGuest) {
            $_subMenus = $model == null ? self::find()->where(['show_after_login' => 0, 'MID' => null, 'status' => 1])->orderBy(['seq' => SORT_ASC])->all() : $model->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all();
        } else {
            $_subMenus = $model == null ? self::find()->where(['MID' => null, 'status' => 1])->orderBy(['seq' => SORT_ASC])->all() : $model->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all();
        }
        if ($model != null) {
            $result = [
                'label' => $model->name,
                'url' => ($model->page_type === null ? 'javascript:void(0)' : $model->aUrl),
                'linkOptions' => ($model->page_type === 0 && $model->link_target == 1 ? ['target' => '_blank'] : []),
                'active' => $model->isActive,
                'options' => [
                    'style' => [
                        'flex' => (mb_strlen($model->name) > 2 ? mb_strlen($model->name) : 3)
                    ]
                ],
            ];
        }
        if (sizeof($_subMenus) > 0) {
            $_subMenus_result = [];
            foreach ($_subMenus as $_subMenu) {
                $_subMenu_result = self::getAllMenusForFrontendNavX($_subMenu);
                if ($_subMenu_result['active'] && $result != null)
                    $result['active'] = true;
                $_subMenus_result[] = $_subMenu_result;
            }
            if ($result != null)
                $result['items'] = $_subMenus_result;
            else
                $result = $_subMenus_result;
        }

        return $result;
    }

    public static function getAllMenusForDropdown($MID=null, $activeOnly=true, $maxLayer=null, $currentLayer=null, $checkRole=false) {
        if ($maxLayer != null && $currentLayer != null && $currentLayer >= $maxLayer) {
            return [];
        } else if ($MID != null) {
            $_model = self::findOne($MID);
            if ($_model == null)
                return [];
            if ($currentLayer == null)
                $currentLayer = $_model->layer;
        }
        $result = [];

        $query = self::find()->where(['MID' => $MID]);
        if ($activeOnly)
            $query->andWhere(['status' => 1]);
        $models = $query->orderBy(['seq' => SORT_ASC])->all();

        foreach ($models as $model) {
            if ($checkRole == false || \backend\components\AccessRule::checkRole(['page.'.$model->id, 'page.allpages']))
                $result[$model->id] = $model->getNameWithSubmenu();
            $_subMenu = self::getAllMenusForDropdown($model->id, $activeOnly, $maxLayer, $currentLayer+1, $checkRole);
            if ($_subMenu != null) {
                $result = $result + $_subMenu;
            }
        }

        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('menu_edit_user', ['menu_id' => 'id']);
    }

/*
    public static function getAllMenusForDropdown($MID=null, $activeOnly=true, $maxLayer=null, $layer=null) {
        if ($maxLayer != null && $layer != null && $layer >= $maxLayer) {
            return null;
        } else if ($MID != null) {
            $_model = self::findOne($MID);
            if ($_model == null)
                return null;
            if ($layer == null)
                $layer = $_model->layer;
        }
        $result = [];

        $models = self::find()->where(['status' => $activeOnly ? 1 : 0, 'MID' => $MID])->orderBy(['seq' => SORT_ASC])->all();

        foreach ($models as $model) {
            $_subMenu = self::getAllMenusForDropdown($model->id, $activeOnly, $maxLayer, $layer+1);
            if ($_subMenu == null) {
                $result[$model->id] = $model->name;
            } else {
                $result[$model->name] = $_subMenu;
            }
        }

        return $result;
    }
*/
}
