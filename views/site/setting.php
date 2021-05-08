<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\editors\Summernote;
use mihaildev\ckeditor\CKEditor;

$this->title = 'Setting';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <!-- 
CKEditor::widget([
    'editorOptions' => [
        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
        'inline' => false, //по умолчанию false
    ]
]); -->
    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= Summernote::widget([
        'model' => $model,
        'attribute' => 'description',
        'value' => '',
        'useKrajeeStyle' => true,
        'useKrajeePresets' => true,
        'enableFullScreen' => true,
        'enableCodeView' => false,
        'enableHelp' => false,
        'enableHintEmojis' => true,
        'hintMentions' => ['jayden', 'sam', 'alvin', 'david']
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>