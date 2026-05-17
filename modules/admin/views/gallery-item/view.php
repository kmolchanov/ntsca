<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GalleryItem */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Галереи', 'url' => ['gallery/index']];
$this->params['breadcrumbs'][] = ['label' => $model->gallery->title_ru, 'url' => ['gallery/view', 'id' => $model->gallery->id]];
$this->params['breadcrumbs'][] = ['label' => 'Элементы', 'url' => ['index', 'gallery_id' => $model->gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gallery-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title_ru',
            [
                'attribute' => 'picture',
                'value' => Html::img($model->thumbnailPicture, [
                    'class' => 'img-thumbnail img-rounded',
                ]),
                'format' => 'raw',
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
