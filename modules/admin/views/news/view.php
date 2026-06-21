<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эту новость?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'slug',
            'title_ru',
            'title_en',
            'title_ky',
            'description_ru:ntext',
            'description_en:ntext',
            'description_ky:ntext',
            'content_ru:ntext',
            'content_en:ntext',
            'content_ky:ntext',
            'date:date',
            [
                'attribute' => 'top_gallery_id',
                'value' => $model->topGallery !== null ? Html::a($model->topGallery->title_ru, ['gallery/view', 'id' => $model->topGallery->id]) : null,
                'format' => 'raw',
            ],
            [
                'attribute' => 'bottom_gallery_id',
                'value' => $model->bottomGallery !== null ? Html::a($model->bottomGallery->title_ru, ['gallery/view', 'id' => $model->bottomGallery->id]) : null,
                'format' => 'raw',
            ],
            [
                'attribute' => 'top_video_id',
                'value' => $model->topVideo !== null ? Html::a($model->topVideo->title_ru, ['video/view', 'id' => $model->topVideo->id]) : null,
                'format' => 'raw',
            ],
            [
                'attribute' => 'bottom_video_id',
                'value' => $model->bottomVideo !== null ? Html::a($model->bottomVideo->title_ru, ['video/view', 'id' => $model->bottomVideo->id]) : null,
                'format' => 'raw',
            ],
            'is_active:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
