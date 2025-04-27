<?php

namespace common\components;

use Yii;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use demogorgorn\sudoslider\SudosliderAssets;

/**
 * Yii2 widget for jQuery SudoSlider (http://webbies.dk/SudoSlider/index.html).
 *
 * Example of ajax mode configuration:
 * ```php
 * echo \demogorgorn\uikit\sudoslider\Sudoslider::widget([
 *   'configuration' => [
 *      'ajax' => [
 *         \Yii::$app->request->getBaseUrl() . '/images/slider/01.jpg',
 *         \Yii::$app->request->getBaseUrl() . '/images/slider/02.jpg',
 *         \Yii::$app->request->getBaseUrl() . '/images/slider/03.jpg',
 *      ],
 *      'numeric' => false,
 *      'continuous' => true,
 *      'effect' => 'fade',
 *      'auto' => true,
 *      'prevNext' => false
 *   ],
 * ]);
 * ```
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 */

class MySudoslider extends \yii\base\Widget {

    /**
     * @var array items
     */
    public $items = [];

    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];

    /**
     * @var array of the slider js options
     * @see http://webbies.dk/SudoSlider/help/
     */
    public $configuration = [];

    /**
     * Initializes the widget.
     */
    public function init() {

        parent::init();

        if (!isset($this->options['id']))
            $this->options['id'] = $this->getId();

    }

    /**
     * Renders the widget.
     */
    public function run() {

        SudosliderAssets::register($this->view);

        $items_html = "";

        if (is_array($this->items))
            foreach ($this->items as $item) {
                if (is_array($item)) {
                    if (!$item['link'] || empty($item['link']))
                        $items .= Html::tag('div', Html::img(Yii::getAlias('@web').$item['src'], ['class' => '']));
                    else
                        $items .= Html::tag('div', Html::a(Html::img(Yii::getAlias('@web').$item['src'], ['class' => '']), $item['link'], ['target' => $item['target']]));
                } else
                    $items .= $item;
            }

        echo Html::tag('div', $items, $this->options);

        $this->registerScript();
    }

    public function getConfig() {

        if (!isset($this->configuration) || !is_array($this->configuration) || empty($this->configuration))
            throw new InvalidConfigException("You should define 'configuration' option and add values according to the documentation!");

        $rtn = \yii\helpers\Json::encode($this->configuration);
        if (isset($this->configuration['indexBanner']) && $this->configuration['indexBanner'])
            return substr($rtn, 0, strlen($rtn)-1);
        return $rtn;
    }

    protected function registerScript()
    {
        $this->getView()->registerJs("
            var sudoSlider_" . $this->options['id'] . " = $('#" . $this->options['id'] . "').sudoSlider(" . $this->getConfig() . ((isset($this->configuration['indexBanner']) && $this->configuration['indexBanner']) ?
                            ', beforeAnimation : function (t, slider, speed) {
                                $(this).fadeTo(speed, 1);
                                slider.find(".slide").not($(this)).fadeTo(speed, 0);
                                $(this).prev().children("a").attr("tabindex","-1");
                            },
                            afterAnimation : function (t, slider) {
                                $(this).children("a").attr("tabindex","0");
                            },
                            initCallback: function () {
                                $(".index-banner a").attr("tabindex","-1");
                                var currentSlide = this.getSlide(this.getValue("currentSlide"));
                                currentSlide.fadeTo(0, 1);
                                //this.find(".slide").not(currentSlide).fadeTo(0, 0.5);
                                this.find(".slide").not(currentSlide).fadeTo(0, 0);
                                //$(".banner_slider .slide:nth-child(2) a").attr("tabindex","0");
                                $(".index-banner .controls").wrap( "<div class=\'container\'></div>" );
                                $("#' . $this->options['id'] . '").width("auto");
                                centerSlider();
                                $(".index-banner").css("visibility", "visible");
                            } }' : '' ) . ")".
            ( (isset($this->configuration) && is_array($this->configuration) && isset($this->configuration['slideCount']) && $this->configuration['slideCount'] > 1) ? '
            if ($(window).width() < 768)
                sudoSlider_' . $this->options['id'] . '.setOption("slideCount", 1);

            $(window).resize(function () {
                if ($(window).width() < 768)
                    sudoSlider_' . $this->options['id'] . '.setOption("slideCount", 1);
                else
                    sudoSlider_' . $this->options['id'] . '.setOption("slideCount", '.$this->configuration['slideCount'].');
            });':'
            $(window).resize(function () {
                sudoSlider_' . $this->options['id'] . '.adjust();
            });')
        );
    }

}
