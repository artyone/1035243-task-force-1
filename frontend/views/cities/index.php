<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>
    <h1>Countries</h1>

    <ul>

        <?php foreach ($cities as $city): ?>
            <li>
                <?= Html::encode("{$city->id} ({$city->name})") ?>:
                <?= $city->latitude ?>
                <?= $city->longitude ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>