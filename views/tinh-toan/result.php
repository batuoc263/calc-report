<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Tính toán';
$this->params['breadcrumbs'][] = ['label' => 'Tính toán', 'url' => ['index']];
?>
<div class="tinhtoan-content">
    
    <embed width="100%" height="700px" src="https://view.officeapps.live.com/op/view.aspx?src=<?= $_SERVER['HTTP_HOST'] . $filePath ?>" frameborder="0" />
            
</div>