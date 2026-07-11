<?php

use app\models\Gallery;
use app\models\Video;
use app\modules\admin\assets\RedactorContentBlocksAsset;
use app\modules\admin\components\RedactorSettings;
use kartik\widgets\Select2;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $contentEditorSettings = RedactorSettings::content(
        Url::to(['/admin/news/image-upload']),
        Url::to(['/admin/news/file-upload']),
        Url::to(['/admin/news/images'])
    ); ?>
    <?php $contentEditorPlugins = ['clips' => RedactorContentBlocksAsset::className()]; ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php foreach ($model->getImages() as $image): ?>
            <?= Html::img($image->getUrl('200x'), ['class' => 'img-thumbnail img-rounded']) ?>
        <?php endforeach; ?>
    </div>

    <?= $form->field($model, 'images')->fileInput(['accept' => 'image/*']); ?>

    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_ky')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_ru')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description_ky')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content_ru')->widget(
        Widget::className(),
        [
            'settings' => $contentEditorSettings,
            'plugins' => $contentEditorPlugins,
        ]
    ); ?>

    <?= $form->field($model, 'content_en')->widget(
        Widget::className(),
        [
            'settings' => $contentEditorSettings,
            'plugins' => $contentEditorPlugins,
        ]
    ); ?>

    <?= $form->field($model, 'content_ky')->widget(
        Widget::className(),
        [
            'settings' => $contentEditorSettings,
            'plugins' => $contentEditorPlugins,
        ]
    ); ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'top_gallery_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Gallery::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите галерею ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'bottom_gallery_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Gallery::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите галерею ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'top_video_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Video::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите видео ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'bottom_video_id')->widget(Select2::className(), [
        'id' => rand(),
        'data' => Video::getList(),
        'options' => [
            'encode' => false,
            'placeholder' => 'Выберите видео ...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
