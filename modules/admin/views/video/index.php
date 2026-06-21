<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Видео';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить видео', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Превью',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->youtubePreviewHtml;
                },
                'contentOptions' => ['style' => 'vertical-align: middle; text-align: center; white-space: nowrap;'],
            ],
            [
                'attribute' => 'title_ru',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],
            [
                'attribute' => 'url',
                'format' => 'url',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle; text-align: center; white-space: nowrap;',
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
