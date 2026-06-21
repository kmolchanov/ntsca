<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'slug',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle;',
                ],
            ],
            [
                'attribute' => 'title_ru',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle;',
                ],
            ],
            [
                'attribute' => 'title_en',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle;',
                ],
            ],
            [
                'attribute' => 'title_ky',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle;',
                ],
            ],
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
                'attribute' => 'date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'dateFormat' => 'yyyy-MM-dd'
                ]),
                'format' => 'date',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle; text-align: center; white-space: nowrap;',
                ],
            ],
            [
                'attribute' => 'is_active',
                'format' => 'boolean',
                'contentOptions' => [
                    'style' => 'width:140px; vertical-align: middle; text-align: center; white-space: nowrap;',
                ],
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
