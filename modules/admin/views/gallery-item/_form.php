<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GalleryItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php foreach ($model->getImages() as $image): ?>
            <?= Html::img($image->getUrl('200x'), ['class' => 'img-thumbnail img-rounded']) ?>
        <?php endforeach; ?>
    </div>

    <?= $form->field($model, 'images')->fileInput(['accept' => 'image/*']); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
