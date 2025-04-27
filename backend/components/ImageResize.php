<?php
namespace backend\components;

use Yii;
use yii\imagine\Image;


Class ImageResize
{
  public $file_path;
  public $new_file_path;
  public $new_size_w = 1000;
  public $new_size_h = NULL;
  public $thumb_file_path;
  public $thumb_size_w = 200;
  public $thumb_size_h = 200;


  public function __construct($config = [])
  {
    $this->file_path = $config['file_path'];
    if(isset($config['new_size_w'])){
      $this->new_size_w = $config['new_size_w'];
    }
    if(isset($config['new_size_h'])){
      $this->new_size_h = $config['new_size_h'];
    }
    if(isset($config['thumb_size_w'])){
      $this->thumb_size_w = $config['thumb_size_w'];
    }
    if(isset($config['thumb_size_h'])){
      $this->thumb_size_h = $config['thumb_size_h'];
    }
    $this->new_file_path = self::getNewFilePath();
    $this->thumb_file_path = self::getThumbnailFilePath();
  }

  public function getNewFilePath(){
    $image_path_temp = $this->file_path;
    do{
      $image_path_temp_array = explode('/', $image_path_temp, 2);
      $image_path_temp = $image_path_temp_array[1];
    }while( $image_path_temp_array[0]!='content');//$image_path_temp_array[0]!='content')
    return '/'.$image_path_temp;
  }

  public function getThumbnailFilePath(){
    $image_path_temp = $this->new_file_path;
    $image_path_temp_array = explode('/', $image_path_temp);

    $file_name_temp = $image_path_temp_array[count($image_path_temp_array)-1];

    $file_name_temp_array = explode('.', $file_name_temp,2);
    $file_name_temp = $file_name_temp_array[0].'_thumb.'.$file_name_temp_array[1];

    $image_path_temp_array[count($image_path_temp_array)-1] = $file_name_temp;
    $image_path = implode("", $image_path_temp_array);

    return $image_path;
  }

  public function setThumbnail(){
     Image::thumbnail(Yii::getAlias('@content').$this->new_file_path, $this->thumb_size_w, $this->thumb_size_h)
         ->save(Yii::getAlias('@content').'/thumb/'.$this->thumb_file_path, ['quality' => 100]);
  }

  public function resize(){
     Image::thumbnail(Yii::getAlias('@content').$this->new_file_path, $this->new_size_w, $this->new_size_h)
         ->save(Yii::getAlias('@content').$this->new_file_path, ['quality' => 100]);
  }

}
