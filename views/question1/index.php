<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

use yii\widgets\ActiveForm;

$this->title = 'Question';
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="container">
    <h2>Câu hỏi 1</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Câu hỏi</a></li>
        <li><a data-toggle="tab" href="#menu1">Giải thích</a></li>
        <li><a data-toggle="tab" href="#menu2">Trả lời</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
        <h3>Câu hỏi</h3>
        <?php $form = ActiveForm::begin(); ?>

            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">N = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varN" name ="varN"> MH
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">A = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varA" name ="varA"> &#13217;
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">l = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varl" name ="varl"> m
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">E = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varE" name ="varE"> Mpa
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">E1 = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varE1" name ="varE1"> Mpa
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">E2 = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varE2" name ="varE2"> Mpa
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">v1 = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varv1" name ="varv1"> -
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">v2 = </label>
                <div class="col-sm-10">
                <input type="text" class="form-control-plaintext" id="varv2" name ="varv2"> -
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

    <?php ActiveForm::end(); ?>
        </div>
        <div id="menu1" class="tab-pane fade">
        <h3>Giải thích</h3>
        <p>Giải thích</p>
        </div>
        <div id="menu2" class="tab-pane fade">
        <h3>Menu 2</h3>
        <p>Trả lời</p>
        </div>
    </div>
    </div>

