<?php

use app\models\DmNhomBai;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DmTinhtoan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-tinhtoan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ten_bai_toan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duong_dan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nhom_id')->dropDownList(ArrayHelper::map(DmNhomBai::find()->all(), 'id', 'ten')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
