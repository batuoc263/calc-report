<?php
foreach ($menu as $key => $value) { ?>
    <div class="text-center bg-success">
        <h4 style="padding: 5px;"><strong> <?= $value['ten'] ?> </strong></h4>
    </div>

    <ul class="nav nav-pills nav-stacked">
        <?php foreach ($value['children'] as $child) { ?>
            <li <?= $child['duong_dan'] == $dmtt->duong_dan ? 'class="active"' : '' ?>><a href="<?= $child['duong_dan'] ?>"><?= $child['ten_bai_toan'] ?> <span class="badge"><?= $child['luot_giai'] ?></span></a></li>
        <?php } ?>
    </ul>

<?php } ?>