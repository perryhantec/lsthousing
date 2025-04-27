<?php

namespace common\components;

use yii\helpers\Html;
use yii\helpers\Json;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\AssetsCallBack;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageFieldWidget
 *
 * @author jamesli
 */
class ImageField extends InputFile {

    public $filter = 'image';
    public $multiple = false;
    public $template = '<div class="form-group input-group"><span class="input-group-btn">{button}</span>{input}</div>{div}';
    public $buttonOptions = ['class' => 'btn btn-default'];

    public function run() {

        if ($this->hasModel()) {
            $replace['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->options);
        }
        else {
            $replace['{input}'] = Html::textInput($this->name, $this->value, $this->options);
        }
        $replace['{div}'] = '<div id="'.$this->options['id'].'_thumbnail"></div>';

        $replace['{button}'] = Html::tag($this->buttonTag, $this->buttonName, $this->buttonOptions);


        echo strtr($this->template, $replace);

        AssetsCallBack::register($this->getView());
        if (empty($this->callbackFunction)) {
            if (!empty($this->multiple))
                $this->getView()->registerJs("mihaildev.elFinder.register(".Json::encode($this->options['id']).", function(files, id){ var _f = []; for (var i in files) { _f.push(files[i].url); } \$('#' + id).val(_f.join(', ')).trigger('change'); return true;}); $(document).on('click','#".$this->buttonOptions['id']."', function(){mihaildev.elFinder.openManager(".Json::encode($this->_managerOptions).");});");
            else
                $this->getView()->registerJs("mihaildev.elFinder.register(".Json::encode($this->options['id']).", function(file, id){ \$('#' + id).val(file.url).trigger('change');; return true;}); $(document).on('click', '#".$this->buttonOptions['id']."', function(){mihaildev.elFinder.openManager(".Json::encode($this->_managerOptions).");});");
        }else {
            $this->getView()->registerJs("mihaildev.elFinder.register(".Json::encode($this->options['id']).", ".Json::encode($this->callbackFunction).");  $(document).on('click','#".$this->buttonOptions['id']."', function(){mihaildev.elFinder.openManager(".Json::encode($this->_managerOptions).");});");
        }
        $this->getView()->registerJs('
            function img_thumbnail(id){
                $("#"+id+"_thumbnail").empty();
                if($("#"+id).val() != ""){
                    $("#"+id+"_thumbnail").prepend("<img src=\'"+$("#"+id).val()+"\' class=\'img-responsive img-thumbnail max-img-thumbnail\'>") 
                }
            }
            img_thumbnail("'.$this->options['id'].'");
            $("#'.$this->options['id'].'").change(function() {
                img_thumbnail($(this).attr("id"));
            });');
    }

}
