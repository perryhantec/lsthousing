<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\components\MultipleInput;
use unclead\multipleinput\TabularColumn;

$this->title = Yii::t('app', 'Home');
?>

<div class="index-right-form">

  <div class="index-right-form">

      <?php $form = ActiveForm::begin(); ?>
        <?php if ($model::HAVE_TOP_YOUTUBE) { ?>
<?php if (0) { ?>
        <?php for ($num=0; $num<$model::NUM_OF_YOUTUBE; $num++) { ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, "top_youtube_id[$num]", ['addon' => ['prepend' => ['content' => 'https://www.youtube.com/watch?v=']]])->textInput()->label($num > 0 ? false : Yii::t('app', 'Youtube ID')) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, "top_youtube_title[$num]")->textInput()->label($num > 0 ? false : Yii::t('app', 'Youtube Title')) ?>
                </div>
            </div>
        <?php } ?>
            <hr />
<?php } ?>
    <?=
        $form->field($model, 'youtube', ['options' => ['id' => 'youtube']])->widget(MultipleInput::class, [
            'sortable' => true,
            'columns' => [
                [
                    'name'  => 'top_youtube_prefix',
                    'type'  => 'static',
                    'title' => 'Youtube ID',
                    'headerOptions' => [
                        'style' => 'width: 230px;',
                    ],
                    'value' => function($data) {
                        return 'https://www.youtube.com/watch?v=';
                    },
                ], 
                [
                    'name'  => 'top_youtube_id',
                    'type'  => TabularColumn::TYPE_TEXT_INPUT,
                    'options' => [
                      'class' => 'menu-type-width',
                    ]
                ], 
                [
                  'name'  => 'top_youtube_title',
                  'type'  => TabularColumn::TYPE_TEXT_INPUT,
                  'title' => 'Youtube Title',
                  'headerOptions' => [
                      'style' => 'width: 50%;',
                  ],
                  'options' => [
                    'class' => 'menu-sub-type-width',
                  ]
                ], 
            ]
        ])->label(false);
    ?>
        <?php } ?>
        
        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('content') as $attr_name)
                echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                      'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => (' content-index content'), 'allowedContent' => true]),
                    ]);
        ?>

      <div class="form-group">
          <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
      </div>

      <?php ActiveForm::end(); ?>

  </div>


</div>
