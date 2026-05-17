<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Видео', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="video-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить данное видео?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php if ($model->youtubePlayerHtml): ?>
        <div class="text-center" style="margin-bottom: 40px;">
            <div style="max-width: 700px; margin: 0 auto;">
                <?= $model->youtubePlayerHtml ?>
            </div>
        </div>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title_ru',
            'title_en',
            'title_ky',
            'description_ru:ntext',
            'description_en:ntext',
            'description_ky:ntext',
            'url:url',
            'descriptionPositionString',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
