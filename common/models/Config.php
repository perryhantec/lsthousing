<?php

namespace common\models;

use Yii;

class Config
{
    const LANG_DEFAULT = 'zh-TW'; // string only
//     const LANG_SUPPORTED = ['zh-TW', 'zh-CN', 'en']; // must be an array
    const LANG_SUPPORTED = ['zh-TW', 'en']; // must be an array

    //logo
    const LOGO_WIDTH = 1024;
    const LOGO_HEIGHT = 400;
    //icon
    const ICON_WIDTH = 100;
    const ICON_HEIGHT = 100;

    public static $fontSize = 's';

    public static function getLanguage() {
        if (!isset(Yii::$app->session['_lang']))
            return self::LANG_DEFAULT;
        else if (in_array(Yii::$app->session['_lang'], self::LANG_SUPPORTED))
            return Yii::$app->session['_lang'];
        return self::LANG_DEFAULT;
    }

    public static function refreshSetting() {
        self::refreshLanguageSetting();
        self::refreshFontSizeSetting();
        self::refreshViewModeSetting();
    }

    public static function refreshLanguageSetting() {
        if (isset($_GET['_lang']) && in_array($_GET['_lang'], self::LANG_SUPPORTED)) {
            Yii::$app->language = $_GET['_lang'];
            Yii::$app->session['lang'] = $_GET['_lang'];
        } else if (isset(Yii::$app->session['lang']) && in_array(Yii::$app->session['lang'], self::LANG_SUPPORTED)) {
            Yii::$app->language = Yii::$app->session['lang'];
        } else {
            // Yii::$app->language = Yii::$app->request->getPreferredLanguage(self::LANG_SUPPORTED);
            Yii::$app->language = self::LANG_DEFAULT;
        }
    }

    public static function getRequiredLanguageAttribute($attr_names) {
        if (self::LANG_DEFAULT == 'zh-TW')
            return $attr_names.'_tw';
        else if (self::LANG_DEFAULT == 'zh-CN')
            return $attr_names.'_cn';
        else if (self::LANG_DEFAULT == 'en')
            return $attr_names.'_en';
        return null;
    }

    public static function getRequiredLanguageAttributes($attr_names) {
        if (is_array($attr_names)) {
            $result = [];
            foreach ($attr_names as $attr_name) {
                $result = array_merge($result, self::getRequiredLanguageAttributes($attr_name));
            }
            return $result;

        } else {
            if (self::LANG_DEFAULT == 'zh-TW')
                return [$attr_names.'_tw'];
            else if (self::LANG_DEFAULT == 'zh-CN')
                return [$attr_names.'_cn'];
            else if (self::LANG_DEFAULT == 'en')
                return [$attr_names.'_en'];
            return [];
        }
    }

    public static function getAllLanguageAttributes($attr_names) {
        if (is_array($attr_names)) {
            $result = [];
            foreach ($attr_names as $attr_name) {
                $result = array_merge($result, self::getAllLanguageAttributes($attr_name));
            }
            return $result;

        } else {
            $result = self::getRequiredLanguageAttributes($attr_names);
            if (defined('self::LANG_SUPPORTED') && is_array(self::LANG_SUPPORTED)) {
                foreach (self::LANG_SUPPORTED as $lang) {
                    if ($lang == self::LANG_DEFAULT)
                        continue;
                    else if ($lang == 'zh-TW')
                        $result[] = $attr_names.'_tw';
                    // else if ($lang == 'zh-CN')
                    //     $result[] = $attr_names.'_cn';
                    // else if ($lang == 'en')
                    //     $result[] = $attr_names.'_en';
                }
            }
            return $result;
        }
    }

    public static function getNumberOfLanguage() {
        if (defined('self::LANG_SUPPORTED') && is_array(self::LANG_SUPPORTED)) {
            return sizeof(self::LANG_SUPPORTED);
        } else {
            return 0;
        }
    }

    public static function refreshFontSizeSetting() {
        if (isset($_GET['_fsize']) && in_array($_GET['_fsize'], ['s', 'm', 'l'])) {
            self::$fontSize = $_GET['_fsize'];
            Yii::$app->session['fsize'] = $_GET['_fsize'];
        } else if (isset(Yii::$app->session['fsize']) && in_array(Yii::$app->session['fsize'], ['s', 'm', 'l'])) {
            self::$fontSize = Yii::$app->session['fsize'];
        }
    }

    public static function refreshViewModeSetting() {
        if (isset($_GET['_layout']) && in_array($_GET['_layout'], ['app', 'main'])) {
            Yii::$app->layout = $_GET['_layout'];
            Yii::$app->session['layout'] = $_GET['_layout'];
        } else if (isset(Yii::$app->session['layout']) && in_array(Yii::$app->session['layout'], ['app', 'main'])) {
            Yii::$app->layout = Yii::$app->session['layout'];
        }
    }

    public static function checkLanguageSupported($lang) {
        if (in_array($lang, self::LANG_SUPPORTED))
            return true;
        return false;
    }

    public static function MenuBannerImagePath() {
        $path = Yii::getAlias('@content').'/title_banner/';
        self::checkFolderExist($path);
        return $path;
    }

    public static function MenuBannerImageDisplayPath() {
        $path = self::ContentDisplayPath().'title_banner/';
        //self::checkFolderExist($path);
        return $path;
    }

    public function MenuIconImagePath() {
        $path = Yii::getAlias('@content').'/menu/';
        self::checkFolderExist($path);
        return $path;
    }

    public function MenuIconImageDisplayPath() {
        $path = self::ContentDisplayPath().'menu/';
        //self::checkFolderExist($path);
        return $path;
    }

  //Path
  public static function PageType1FileThumbPath($id){
    $path = Yii::getAlias('@content').'/page/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType1FilePath($id){
    $path = Yii::getAlias('@content').'/page/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType1FileDisplayPath($id){
    $path = self::ContentDisplayPath().'page/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType1FileThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'page/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType2FilePath($id){
    $path = Yii::getAlias('@content').'/video/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType2FileDisplayPath($id){
    $path = self::ContentDisplayPath().'video/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType2ImagePath(){
    $path = Yii::getAlias('@content').'/video/thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType2ImageDisplayPath(){
    $path = self::ContentDisplayPath().'video/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType3FolderPath($id){
    $path = Yii::getAlias('@content').'/gallery/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType3FolderDisplayPath($id){
    $path = self::ContentDisplayPath().'gallery/'.$id.'/';
    return $path;
  }
  public static function PageType3ThumbFolderPath($id){
    $path = Yii::getAlias('@content').'/gallery/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType3ThumbFolderDisplayPath($id){
    $path = self::ContentDisplayPath().'gallery/'.$id.'/thumb/';
    return $path;
  }
  public static function PageType4FilePath($id){
    $path = Yii::getAlias('@content').'/blog/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType4FileThumbPath($id){
    $path = Yii::getAlias('@content').'/blog/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType4FileDisplayPath($id){
    $path = self::ContentDisplayPath().'blog/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType4FileThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'blog/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType4ImagePath(){
    $path = Yii::getAlias('@content').'/blog/image/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType4ImageDisplayPath(){
    $path = self::ContentDisplayPath().'blog/image/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType5FilePath($id){
    $path = Yii::getAlias('@content').'/document/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType5ThumbPath($id){
    $path = self::PageType5FilePath($id);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType5FileDisplayPath($id){
    $path = self::ContentDisplayPath().'document/'.$id.'/';
    return $path;
  }
  public static function PageType5ThumbDisplayPath($id){
    $path = self::PageType5FileDisplayPath($id);
    $path .= 'thumb/';
    return $path;
  }

  public static function PageType6ImagePath(){
    $path = self::ContentPath().'banner_image/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function PageType6ImageDisplayPath(){
    $path = self::ContentDisplayPath().'banner_image/';
    //self::checkFolderExist($path);
    return $path;
  }

  public static function PageType7PhotoPath(){
    $path = self::ContentPath().'committee/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function PageType7PhotoDisplayPath(){
    $path = self::ContentDisplayPath().'committee/';
    //self::checkFolderExist($path);
    return $path;
  }

  public static function PageType7PhotoThumbPath(){
    $path = self::ContentPath().'committee/thumb/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function PageType7PhotoThumbDisplayPath(){
    $path = self::ContentDisplayPath().'committee/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }

  public static function PageType9FilePath($id){
    $path = Yii::getAlias('@content').'/tender/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType9FileDisplayPath($id){
    $path = self::ContentDisplayPath().'tender/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType10FileThumbPath($id){
    $path = Yii::getAlias('@content').'/pageWithYoutube/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType10FilePath($id){
    $path = Yii::getAlias('@content').'/pageWithYoutube/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType10FileDisplayPath($id){
    $path = self::ContentDisplayPath().'pageWithYoutube/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType10FileThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'pageWithYoutube/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType11FilePath($id){
    $path = Yii::getAlias('@content').'/blog2/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType11FileThumbPath($id){
    $path = Yii::getAlias('@content').'/blog2/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType11FileDisplayPath($id){
    $path = self::ContentDisplayPath().'blog2/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType11FileThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'blog2/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType11ImagePath(){
    $path = Yii::getAlias('@content').'/blog2/image/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType11ImageDisplayPath(){
    $path = self::ContentDisplayPath().'blog2/image/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12FilePath($id){
    $path = Yii::getAlias('@content').'/blog3/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12FileThumbPath($id){
    $path = Yii::getAlias('@content').'/blog3/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12FileDisplayPath($id){
    $path = self::ContentDisplayPath().'blog3/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12FileThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'blog3/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12ImagePath(){
    $path = Yii::getAlias('@content').'/blog3/image/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12ImageDisplayPath(){
    $path = self::ContentDisplayPath().'blog3/image/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12PosterPath(){
    $path = Yii::getAlias('@content').'/blog3/poster/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function PageType12PosterDisplayPath(){
    $path = self::ContentDisplayPath().'blog3/poster/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function checkFolderExist($path){
    if(!file_exists($path))
        if(!mkdir($path, 0777, true))
            throw new CHttpException(404, 'Directory create error!');
  }

  public static function chmodFile($path){
    if(file_exists($path))
        chmod($path, 0777);
    return true;
  }

  //content
  public static function ContentPath(){
    $path = Yii::getAlias('@content').'/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function ContentDisplayPath(){
    $basename_temp = basename(Yii::getAlias('@web'));
    $name_array = ['admin'];
    if(in_array($basename_temp, $name_array)){
      if(dirname(Yii::getAlias('@web'))!='/'){
        $path = dirname(Yii::getAlias('@web')).'/'.basename(Yii::getAlias('@content')).'/';
      }else{
        $path = '/'.basename(Yii::getAlias('@content')).'/';
      }
    }else{
      $path = Yii::getAlias('@web').'/'.basename(Yii::getAlias('@content')).'/';
    }
    return $path;
  }
  public static function FileContentPath(){
    $path = Yii::getAlias('@file').'/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function FileContentDisplayPath(){
    $basename_temp = basename(Yii::getAlias('@web'));
    $name_array = ['admin'];
    if(in_array($basename_temp, $name_array)){
      if(dirname(Yii::getAlias('@web'))!='/'){
        $path = dirname(Yii::getAlias('@web')).'/'.basename(Yii::getAlias('@file')).'/';
      }else{
        $path = '/'.basename(Yii::getAlias('@file')).'/';
      }
    }else{
      $path = Yii::getAlias('@web').'/'.basename(Yii::getAlias('@file')).'/';
    }
    return $path;
  }
  //general
  public static function GeneralPath(){
    $path = self::ContentPath().'general/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function ContactUsPath(){
    $path = self::ContentPath().'contact_us/';
    self::checkFolderExist($path);
    return $path;
  }

  //banner
  public static function BannerPath(){
    $path = self::ContentPath().'banners/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function BannerDisplayPath(){
    $path = self::ContentDisplayPath().'banners/';
    //self::checkFolderExist($path);
    return $path;
  }
  //logo
  public static function LogoPath(){
    $path = self::ContentPath().'logo/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function LogoDisplayPath(){
    $path = self::ContentDisplayPath().'logo/';
    //self::checkFolderExist($path);
    return $path;
  }

  public static function ProductPicPath($id){
    $path = Yii::getAlias('@content').'/product/';
//     self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function ProductPicThumbPath($id){
    $path = self::ProductPicPath($id);
    $path .= 'pic_thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function ProductThumbFilePath($id){
    $path = self::ProductPicPath($id);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function ProductPicDisplayPath($id){
    $path = self::ContentDisplayPath().'product/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function ProductPicThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'product/'.$id.'/pic_thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function ProductThumbDisplayThumbPath($id){
    $path = self::ContentDisplayPath().'product/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }

  public static function InKindDonationImageFilePath($id){
    $path = Yii::getAlias('@data').'/in-kind-donation/'.$id.'/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function OnlineDonationReceiptFilePath($id){
    $path = Yii::getAlias('@data').'/online-donation/receipt/'.$id.'/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function DonationEventBannerImagePath() {
    $path = Yii::getAlias('@content').'/donation/banner/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function DonationEventBannerImageDisplayPath() {
    $path = self::ContentDisplayPath().'donation/banner/';
    //self::checkFolderExist($path);
    return $path;
  }

  public static function DonationEventStoryImagePath() {
    $path = Yii::getAlias('@content').'/donation/story/';
    self::checkFolderExist($path);
    return $path;
  }

  public static function DonationEventStoryImageDisplayPath() {
    $path = self::ContentDisplayPath().'donation/story/';
    //self::checkFolderExist($path);
    return $path;
  }

  // public static function ResponseFilePath($id){
  //   $path = Yii::getAlias('@content').'/response/';
  //   self::checkFolderExist($path);
  //   // $path .= $id.'/';
  //   // self::checkFolderExist($path);
  //   return $path;
  // }
  // public static function ResponseFileThumbPath($id){
  //   $path = Yii::getAlias('@content').'/response/';
  //   self::checkFolderExist($path);
  //   $path .= $id.'/';
  //   self::checkFolderExist($path);
  //   $path .= 'thumb/';
  //   self::checkFolderExist($path);
  //   return $path;
  // }
  // public static function ResponseFileDisplayPath($id){
  //   $path = self::ContentDisplayPath().'response/'.$id.'/';
  //   //self::checkFolderExist($path);
  //   return $path;
  // }
  // public static function ResponseFileThumbDisplayPath($id){
  //   $path = self::ContentDisplayPath().'response/'.$id.'/thumb/';
  //   //self::checkFolderExist($path);
  //   return $path;
  // }

  public static function FileFilePath($id){
    $path = Yii::getAlias('@content').'/files/';
    self::checkFolderExist($path);
    // $path .= $id.'/';
    // self::checkFolderExist($path);
    return $path;
  }
  public static function FileFileDisplayPath($id){
    $path = self::ContentDisplayPath().'files/';
    //self::checkFolderExist($path);
    return $path;
  }

  public static function RentalFilePath($id){
    $path = Yii::getAlias('@content').'/rental/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function RentalFileThumbPath($id){
    $path = Yii::getAlias('@content').'/rental/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function RentalFileDisplayPath($id){
    $path = self::ContentDisplayPath().'rental/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function RentalFileThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'rental/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }

  public function AboutUsIconImagePath() {
    $path = Yii::getAlias('@content').'/about-icon/';
    self::checkFolderExist($path);
    return $path;
  }

  public function AboutUsIconImageDisplayPath() {
      $path = self::ContentDisplayPath().'about-icon/';
      //self::checkFolderExist($path);
      return $path;
  }

  public static function AboutUsFileThumbPath($id){
    $path = Yii::getAlias('@content').'/about/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    $path .= 'thumb/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function AboutUsFilePath($id){
    $path = Yii::getAlias('@content').'/about/';
    self::checkFolderExist($path);
    $path .= $id.'/';
    self::checkFolderExist($path);
    return $path;
  }
  public static function AboutUsFileDisplayPath($id){
    $path = self::ContentDisplayPath().'about/'.$id.'/';
    //self::checkFolderExist($path);
    return $path;
  }
  public static function AboutUsFileThumbDisplayPath($id){
    $path = self::ContentDisplayPath().'about/'.$id.'/thumb/';
    //self::checkFolderExist($path);
    return $path;
  }
}