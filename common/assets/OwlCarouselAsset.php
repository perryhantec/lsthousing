<?php

namespace common\assets;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\web\AssetBundle;

/**
 * Description of OwlCarouselAsset
 *
 * @author jamesli
 */
class OwlCarouselAsset extends AssetBundle {

    public $sourcePath = '@bower/owl.carousel/dist';
    public $css = [
        'assets/owl.carousel.css',
        'assets/owl.theme.default.css',
    ];
    public $js = [
        'owl.carousel.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
