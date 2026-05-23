<?php

use app\modules\admin\components\Nestable;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $query yii\db\Query */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
        <span id="nestable-menu">
            <button class="btn btn-default" type="button" data-action="expand-all">Развернуть</button>
            <button class="btn btn-default" type="button" data-action="collapse-all">Свернуть</button>
        </span>
    </p>

    <?= Nestable::widget([
        'type' => Nestable::TYPE_WITH_HANDLE,
        'query' => $query,
        'modelOptions' => [
            'name' => 'title_ru',
        ],
        'pluginEvents' => [
            'change' => 'function(e) {}',
        ],
        'pluginOptions' => [
            'maxDepth' => 100,
        ],
        'update' => Url::to(['update']),
        'delete' => Url::to(['delete']),
        'viewItem' => Url::to(['view']),
    ]); ?>

</div>
