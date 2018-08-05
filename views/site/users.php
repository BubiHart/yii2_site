<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Users';

$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?= Html::encode("{$user->_id}: {$user->login}, {$user->password}") ?>
        </li>
    <?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
