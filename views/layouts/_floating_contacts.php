<?php

use yii\helpers\Html;

$contacts = Yii::$app->params['contacts'] ?? [];
?>

<div class="floating-contacts">
    <?php if (!empty($contacts['whatsapp'])): ?>
        <?= Html::a('<i class="fa fa-whatsapp"></i>', 'https://api.whatsapp.com/send/?phone=' . $contacts['whatsapp'], [
            'class' => 'floating-contact floating-contact-whatsapp',
            'target' => '_blank',
            'rel' => 'noopener noreferrer',
            'aria-label' => 'WhatsApp',
        ]) ?>
    <?php endif; ?>

    <?php if (!empty($contacts['phone'])): ?>
        <?= Html::a('<i class="fa fa-phone"></i>', 'tel:+' . $contacts['phone'], [
            'class' => 'floating-contact floating-contact-phone',
            'aria-label' => 'Позвонить',
        ]) ?>
    <?php endif; ?>

    <?php if (!empty($contacts['instagram'])): ?>
        <?= Html::a('<i class="fa fa-instagram"></i>', $contacts['instagram'], [
            'class' => 'floating-contact floating-contact-instagram',
            'target' => '_blank',
            'rel' => 'noopener noreferrer',
            'aria-label' => 'Instagram',
        ]) ?>
    <?php endif; ?>
</div>
