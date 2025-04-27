<?php

namespace common\utils;

use Yii;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Url;
use kartik\icons\Icon;
use kartik\widgets\FileInput;

class Html extends \yii\helpers\Html {

    public static function multilingualTextInput($form, $model, $attribute, $options = []) {
        $output = '<div class="multilang">';
        $dropdown = [];

        $label = ArrayHelper::getValue($options, 'label', true);
        if (!is_string($label)) {
            $label = $label ? ArrayHelper::getValue($model->attributeLabels(), $attribute) : false;
        }
        foreach (Yii::$app->params['languages'] as $key => $item) {
            $dropdown[] = ['label' => $item, 'url' => 'javascript:hideOtherLanguage("'.$key.'");'];
        }
        foreach (Yii::$app->params['languages'] as $key => $item) {
            $output .=$form->field($model, $attribute.(Yii::$app->language === $key ? '' : ('_'.$key)), [
                'addon' => [
                    'append' => [
                        'content' => \yii\bootstrap\ButtonDropdown::widget([
                            'label' => $item,
                            'dropdown' => [
                                'items' => $dropdown,
                                'options' => ['class' => 'lang-btn-menu']
                            ],
                            'options' => ['class' => 'btn-default'],
                        ]),
                        'asButton' => true
                    ]
                ],
                'options' => ['class' => 'form-group translatable-field lang-'.$key]
            ])->textInput(array_merge(['data-attribute' => $attribute], $options))->label($label);
        }
        $output .='</div>';
        return $output;
    }

    public static function multilingualTextArea($form, $model, $attribute, $options = []) {
        $output = '<div class="multilang">';
        $dropdown = [];

        $label = ArrayHelper::getValue($options, 'label', true);
        if (!is_string($label)) {
            $label = $label ? ArrayHelper::getValue($model->attributeLabels(), $attribute) : false;
        }
        foreach (Yii::$app->params['languages'] as $key => $item) {
            $dropdown[] = ['label' => $item, 'url' => 'javascript:hideOtherLanguage("'.$key.'");'];
        }
        foreach (Yii::$app->params['languages'] as $key => $item) {
            $output .=$form->field($model, $attribute.(Yii::$app->language === $key ? '' : ('_'.$key)), [
                'addon' => [
                    'append' => [
                        'content' => \yii\bootstrap\ButtonDropdown::widget([
                            'label' => $item,
                            'dropdown' => [
                                'items' => $dropdown,
                                'options' => ['class' => 'lang-btn-menu']
                            ],
                            'options' => ['class' => 'btn-default'],
                        ]),
                        'asButton' => true
                    ]
                ],
                'options' => ['class' => 'form-group translatable-field lang-'.$key]
            ])->textArea(array_merge(['data-attribute' => $attribute], $options))->label($label);
        }
        $output .='</div>';
        return $output;
    }

    public static function multilingualCKEditor($form, $model, $attribute, $options = []) {
        $output = '<div class="form-group">';
        $dropdown = [];
        foreach (Yii::$app->params['languages'] as $key => $item) {
            $dropdown[] = ['label' => $item, 'url' => 'javascript:hideOtherLanguage("'.$key.'");'];
        }
        foreach (Yii::$app->params['languages'] as $key => $item) {
            $output.=$form->field($model, $attribute.(Yii::$app->language === $key ? '' : ('_'.$key)), [
                'addon' => [
                    'append' => [
                        'content' => \yii\bootstrap\ButtonDropdown::widget([
                            'label' => $item,
                            'dropdown' => [
                                'items' => $dropdown,
                            ],
                            'options' => ['class' => 'btn-default']
                        ]),
                        'asButton' => true
                    ]
                ],
                'options' => ['class' => 'translatable-field lang-'.$key]
            ])->widget(CKEditor::className(), [
                'editorOptions' => $options,
            ])->label(ArrayHelper::getValue($model->attributeLabels(), $attribute));
        }
        return $output.'</div>';
    }

    public static function activeRecordErrorsToMobileListView($errors) {
        $html = '';
        foreach ($errors as $error) {
            foreach ($error as $item) {
                $html .= '• '.$item.'<br/>';
            }
        }
        
        return $html;
    }
    
  public static function backButton($label = null) {
    if (is_null($label))
      $label = Yii::t('app', '返回');
    return Html::a(Icon::show('reply', ['class' => 'fa-2x']).'<br/>'.$label, "#", ['class' => 'btn btn-default', "onclick" => "window.history.back();"]);
  }

  public static function backToIndexButton($to = ['index'], $label = null) {
    if (is_null($label))
      $label = Yii::t('app', '返回列表');
    return Html::a(Icon::show('reply', ['class' => 'fa-2x']).'<br/>'.$label, $to, ['class' => 'btn btn-default']);
  }

  public static function saveButton($label = null, $options = []) {
    if (is_null($label))
      $label = Yii::t('app', '儲　存');

    $options = array_merge(['class' => 'btn btn-success'], $options);
    return Html::submitButton(Icon::show('floppy-o', ['class' => 'fa-2x']).'<br/>'.$label, $options);
  }

  public static function customBoxToolButton($to, $icon, $label, $options = []) {
    $options = array_merge(["class" => "btn btn-box-tool"], $options);
    return Html::a($icon.$label, $to, $options);
  }

  public static function viewBoxToolButton($to, $icon = null, $label = null, $options = []) {
    if (is_null($icon))
      $icon = Icon::show('desktop');

    if (is_null($label))
      $label = Yii::t('app', '檢視');

    return Html::customBoxToolButton($to, $icon, $label, $options);
  }

  public static function createBoxToolButton($to, $icon = null, $label = null, $options = []) {
    if (is_null($icon))
      $icon = Icon::show('plus');

    if (is_null($label))
      $label = Yii::t('app', '新增');

    return Html::customBoxToolButton($to, $icon, $label, $options);
  }

  public static function reorderBoxToolButton($to, $icon = null, $label = null, $options = []) {
    if (is_null($icon))
      $icon = Icon::show('sort');

    if (is_null($label))
      $label = Yii::t('app', '排序');

    return Html::customBoxToolButton($to, $icon, $label, $options);
  }

  public static function updateBoxToolButton($to, $icon = null, $label = null, $options = []) {
    if (is_null($icon))
      $icon = Icon::show('edit');

    if (is_null($label))
      $label = Yii::t('app', '更新');

    return Html::customBoxToolButton($to, $icon, $label, $options);
  }

  public static function deleteBoxToolButton($to, $icon = null, $label = null, $options = []) {
    if (is_null($icon))
      $icon = Icon::show('trash');

    if (is_null($label))
      $label = Yii::t('app', '刪除');

    $options = array_merge(['class' => 'btn btn-box-tool', 'data-confirm' => Yii::t('app', '是否確定刪除？'), 'data-method' => 'post',], $options);

    return Html::customBoxToolButton($to, $icon, $label, $options);
  }

  public static function printBoolean($value) {
    if ($value === null)
      return;
    return $value ? Icon::show('check') : Icon::show('times');
  }

  public static function activeRecordErrorsToList($errors) {
    $html = '<ul>';
    foreach ($errors as $error) {
      foreach ($error as $item) {
        $html .= self::tag('li', $item);
      }
    }
    $html .= '</ul>';

    return $html;
  }

  public static function printLogTable($model, $created_at = 'created_at', $created_by = 'created_by', $updated_at = 'updated_at', $updated_by = 'updated_by') {
    if ($model != null && !$model->isNewRecord) {
      $html = '<div class="box box-default"><div class="box-body"><div class="row"><div class="col-xs-12 col-sm-6">';
      $html .= Html::tag('label', $model->getAttributeLabel('created_at')).': '.Yii::$app->formatter->asDatetime($model->{$created_at});
      $html .= '</div><div class="col-xs-12 col-sm-6">';
      $html .= Html::tag('label', $model->getAttributeLabel('created_by')).': '.Yii::$app->formatter->asNtext($model->{$created_by});
      $html .= '</div><div class="col-xs-12 col-sm-6">';
      $html .= Html::tag('label', $model->getAttributeLabel('updated_at')).': '.Yii::$app->formatter->asDatetime($model->{$updated_at});
      $html .= '</div><div class="col-xs-12 col-sm-6">';
      $html .= Html::tag('label', $model->getAttributeLabel('updated_by')).': '.Yii::$app->formatter->asNtext($model->{$updated_by});
      $html .= '</div></div></div></div>';
      return $html;
    }
  }

  public static function checkboxListWithTextInput($form, $model, $attribute, $items, $option_class, $option_id_attribute = 'option_id', $value_attribute = 'value', $label = false, &$counter = 1) {
    $option_model = new $option_class();
    $with_child = is_subclass_of($option_model, \common\override\models\OptionsWithParentActiveRecord::class);
    $html = '<div class="form-group field-'.strtolower($model->formName()).'-'.$attribute.' checkbox-list">'
    .'<label class="control-label">'.(($label) ?: $model->getAttributeLabel($attribute)).'</label>'
    .'<div class="hidden">'.$form->field($model, $attribute, ['template' => ''])->hiddenInput(['value' => '']).'</div>'
    .'<div id="'.strtolower($model->formName()).'-'.$attribute.'">'
    .'<div class="row display-flex">';
    $existing_option_ids = $model->{$attribute} ? ArrayHelper::getColumn($model->{$attribute}, $option_id_attribute) : [];

    foreach ($items as $item) {
      // $with_child = count($item->options)>0;
      $html .= self::generateCheckboxWithTextInput($form, $model, $attribute, $item, $option_model, $option_id_attribute, $value_attribute, $with_child, $existing_option_ids, $counter, "col-xs-12 col-sm-6 col-md-4 col-lg-3 checkbox-option-group");
      $counter++;
    }

    $html .= '</div></div></div>';
    return $html;
  }

  protected static function generateCheckboxWithTextInput($form, $model, $attribute, $item, $option_model, $option_id_attribute, $value_attribute, $with_child, $existing_option_ids, &$counter, $col_class) {
    $name = $model->formName()."[$attribute][$counter]";
    $html = '<div class="'.$col_class.'"><div class="mt-1"><label class="checkbox">';
    $pos = array_search($item->id, $existing_option_ids);
    if ($item->is_radio) {
      $name = ($item->hasAttribute('parent_option_id'))? $model->formName()."[$attribute][$item->parent_option_id]": $model->formName()."[$attribute]";
      $html .= self::radio($name."[$option_id_attribute]", $pos !== false, ['label' => $item->name, 'class' => ($item->is_text_input ? ' with-child' : ''), 'value' => $item->id]);
    }
    else {
      $html .= self::checkbox($name."[$option_id_attribute]", $pos !== false, ['label' => $item->name, 'class' => ($item->is_text_input ? ' with-child' : ''), 'value' => $item->id]);
    }
    if ($item->is_text_input) {
      $html .= '<div class="child">';
      $html .= $form->field($pos !== false ? $model->{$attribute}[$pos] : $option_model, $value_attribute, ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['name' => $name."[$value_attribute]"]);
      $html .= '</div>';
    }
    if ($with_child) {
      foreach ($item->getOptions()->defaultOrder()->all() as $child) {
        $html .= self::generateCheckboxWithTextInput($form, $model, $attribute, $child, $option_model, $option_id_attribute, $value_attribute, $with_child, $existing_option_ids, $counter, "col-xs-12");

        $counter++;
      }
    }
    $html .= '</label></div></div>';
    return $html;
  }

  public static function ajaxFileInput($form, $model, $file_key_attribute, $multiple = false, $preview_urls = []) {
    $html = '';
    $file_key_input_id = $file_key_attribute;
    $html .= $form->field($model, $file_key_attribute)->hiddenInput(['id' => $file_key_input_id])->label(false);
    $html .= FileInput::widget([
        'name' => 'files[]',
        'options' => ['multiple' => $multiple],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'uploadAsync' => false,
            'uploadUrl' => Url::to(['/site/upload-multiple']),
            'initialPreview' => $preview_urls,
            'initialPreviewAsData' => true,
            'showCaption' => false,
            'browseLabel' => Yii::t('app', '瀏覽'),
            'removeLabel' => Yii::t('app', '刪除'),
            'uploadLabel' => Yii::t('app', '上載'),
            'initialPreviewShowDelete' => false
        ],
        'pluginEvents' => [
            'filebatchuploadsuccess' => "function(event, data, previewId, index) {
              $('#$file_key_input_id').val(data.response.data[0].auth_key);
          }",
            'fileuploaded' => "function(event, previewId, index, fileId) {
            $('#$file_key_input_id').val(previewId.response.data[0].auth_key);
          }",
            'fileclear' => "function() {
            $('#$file_key_input_id').val('');
          }",
        ]
    ]);
    return $html;
  }

  public static function fileUpload($form, $model, $attribute, $options = [], $pluginOptions = []) {
    $pluginOptionsArray = array_merge([
        'uploadUrl' => Url::to(['/site/upload']),
    ], $pluginOptions);


    $fileInput = FileInput::widget([
        'name' => $attribute.'-files',
        'options' => $options,
        'pluginOptions' => $pluginOptionsArray,
        'pluginEvents' => [
            'filebatchuploadsuccess' => "function(event, data) {
            $('#$attribute').val(data.response.data.auth_key);
          }",
            'fileuploaded' => "function(event, data) {
            $('#$attribute').val(data.response.data.auth_key);
          }",
            'fileclear' => "function() {
            $('#$attribute').val('');
          }",
        ]
    ]);
    $html = $form->field($model, $attribute, ['template' => "{label}\n{input}\n$fileInput"])->hiddenInput(['id' => $attribute]);

    return $html;
  }


  public static function htmlDraw($model, $parent_id,  $template, $attribute_file, $attribute_file_key, $attribute_data) {
    $html = '';
    $html .= '<label>'.$model->getAttributeLabel($attribute_file).'</label><br>';

    $html .= self::a(Icon::show('pencil').Yii::t('app', '編輯'), Url::to(['draw','parent_id' => $parent_id, 'id' => $model->id, 'template' => $template, 'attribute_file' => $attribute_file, 'attribute_file_key' => $attribute_file_key, 'attribute_data' => $attribute_data]), ['class' => 'mb-1 btn btn-sm btn-default']).'&nbsp';

    $html .= $model->{$attribute_file} ? self::img(Url::to(['download', 'id' => $model->id, 'attribute' => $attribute_file, 'auth_key' => $model->{$attribute_file_key}]), ['class' => 'img-responsive', 'width' => '100%']) :
    self::img(Url::to(['get-template', 'module' => 'drawings', 'file_name' => $template]), ['class' => 'img-responsive', 'width' => '100%']);


    return $html;
  }
}
