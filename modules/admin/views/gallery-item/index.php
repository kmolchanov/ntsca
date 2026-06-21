<?php

use himiklab\sortablegrid\SortableGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var app\models\Gallery $gallery */
/* @var $searchModel app\models\GalleryItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Элементы';
$this->params['breadcrumbs'][] = ['label' => 'Галереи', 'url' => ['gallery/index']];
$this->params['breadcrumbs'][] = ['label' => $gallery->title_ru, 'url' => ['gallery/view', 'id' => $gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить элемент', ['create', 'gallery_id' => $gallery->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Изображение',
                'format' => 'raw',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle; text-align: center; white-space: nowrap;',
                ],
                'value' => function ($model) {
                    return Html::img($model->thumbnailPicture, [
                        'style' => 'max-width:230px; border-radius:4px;',
                    ]);
                },
            ],
            [
                'attribute' => 'title_ru',
                'contentOptions' => ['style' => 'vertical-align: middle;'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'contentOptions' => ['style' => 'width:140px; vertical-align: middle; text-align: center; white-space: nowrap;'],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
