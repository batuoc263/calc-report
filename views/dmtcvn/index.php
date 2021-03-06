<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục TCVN';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dmtcvn-index">


    <div class="row">
        <div class="col-md-9">
            <img class="img-responsive" src="/images/dmtcvn/TCQG.png">
            <img id="tcqg_img" class="img-responsive img-reflection" src="/images/dmtcvn/TCQG_default.jpg">
            <div id="pdfView"></div>
        </div>
        <div class="col-md-3">
            <ul class="list-group">
                <h4>Danh sách file TCVN</h4>
                <?php foreach ($files as $file) { ?>
                    <li class="list-group-item"><a href="#" onclick="showDocument('<?= $file->filename ?>')"><?= $file->filename ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<script>
    function showDocument(filename) {
        $("#pdfView").html('<embed width="100%" height="600px" src="uploads/'+filename+'#toolbar=1" frameborder="0" type="application/pdf" />');
        $("#tcqg_img").hide();
    }
</script>