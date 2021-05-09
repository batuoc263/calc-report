<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

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

    <?= froala\froalaeditor\FroalaEditorWidget::widget([
        'model' => $model,
        'attribute' => 'description',
        'options' => [
            // html attributes
            'id' => 'description'
        ],
        'excludedPlugins'=>['markdown', 'track_changes'],
        'clientOptions' => [
            'toolbarInline' => false,
            'theme' => 'royal', //optional: dark, red, gray, royal
            'language' => 'en_gb' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>