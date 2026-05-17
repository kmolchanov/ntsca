<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить страницу и все её подстраницы?',
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
            'menu_title_ru',
            'menu_title_en',
            'menu_title_ky',
            'content_ru:html',
            'content_en:ntext',
            'content_ky:ntext',
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
            'is_main:boolean',
            'show_in_menu:boolean',
            'show_subpages:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
