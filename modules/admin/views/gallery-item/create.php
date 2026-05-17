<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GalleryItem */

$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Галереи', 'url' => ['gallery/index']];
$this->params['breadcrumbs'][] = ['label' => $model->gallery->title_ru, 'url' => ['gallery/view', 'id' => $model->gallery->id]];
$this->params['breadcrumbs'][] = ['label' => 'Элементы', 'url' => ['index', 'gallery_id' => $model->gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
