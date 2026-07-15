<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$defaultLang = Yii::$app->params['defaultLanguage'] ?? 'ru';
$languages = Yii::$app->params['languages'] ?? [];
$defaultLanguage = $languages[$defaultLang] ?? [];
$language = $languages[$lang] ?? $defaultLanguage;
$contactLabels = array_merge($defaultLanguage['contactPage'] ?? [], $language['contactPage'] ?? []);
$contacts = Yii::$app->params['contacts'] ?? [];
$address = $contactLabels['address'] ?? $contacts['address'] ?? '';
$mapQuery = $contacts['mapQuery'] ?? $contacts['address'] ?? '';
$mapCoordinates = $contacts['mapCoordinates'] ?? [];
$mapZoom = (int)($contacts['mapZoom'] ?? 17);
$mapLanguage = $contacts['mapLanguage'][$lang] ?? $lang;
$mapLanguageQuery = '&hl=' . rawurlencode($mapLanguage);
$mapCoordinatesQuery = '';

if (!empty($mapCoordinates['lat']) && !empty($mapCoordinates['lng'])) {
    $mapCoordinatesQuery = $mapCoordinates['lat'] . ',' . $mapCoordinates['lng'];
}

$mapSrc = $mapCoordinatesQuery
    ? 'https://www.google.com/maps?q=' . rawurlencode($mapCoordinatesQuery) . '&z=' . $mapZoom . $mapLanguageQuery . '&output=embed'
    : 'https://www.google.com/maps?q=' . rawurlencode($mapQuery) . $mapLanguageQuery . '&output=embed';

$this->title = $contactLabels['title'] ?? '';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = $address;
?>

<div class="site-contact d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 overflow-hidden login-split-card login-split-card-wide contact-card">
        <div class="row g-0">

            <div class="col-lg-4 d-flex login-brand-panel text-white">
                <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                    <div>
                        <?php if (!empty($contactLabels['badge'])): ?>
                            <div class="contact-brand-mark mb-4">
                                <?= Html::encode($contactLabels['badge']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($contactLabels['highlights']) && is_array($contactLabels['highlights'])): ?>
                            <div class="contact-highlights">
                                <?php foreach ($contactLabels['highlights'] as $highlight): ?>
                                    <div class="contact-highlight">
                                        <span class="contact-highlight-icon" aria-hidden="true">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        <span><?= Html::encode($highlight) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-3 login-brand-title">
                            <?= Html::encode($this->title) ?>
                        </h1>
                        <?php if (!empty($contactLabels['intro'])): ?>
                            <p class="opacity-75 mb-0 login-brand-text">
                                <?= Html::encode($contactLabels['intro']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="p-4 p-lg-5">
                    <div class="contact-list mb-4">
                        <div class="contact-list-column">
                            <?php if ($address): ?>
                                <div class="contact-item">
                                    <span class="contact-item-icon" aria-hidden="true">
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                    <div>
                                        <div class="contact-item-label"><?= Html::encode($contactLabels['addressLabel'] ?? '') ?></div>
                                        <div class="contact-item-value"><?= Html::encode($address) ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($contacts['whatsapp'])): ?>
                                <a class="contact-item contact-item-link" href="https://api.whatsapp.com/send/?phone=<?= Html::encode($contacts['whatsapp']) ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="contact-item-icon contact-item-icon-whatsapp" aria-hidden="true">
                                        <i class="fa fa-whatsapp"></i>
                                    </span>
                                    <span>
                                        <span class="contact-item-label"><?= Html::encode($contactLabels['whatsappLabel'] ?? '') ?></span>
                                        <span class="contact-item-value">
                                            <?= Html::encode($contacts['phoneDisplay'] ?? ('+' . $contacts['whatsapp'])) ?>
                                        </span>
                                    </span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($contacts['phone'])): ?>
                                <a class="contact-item contact-item-link" href="tel:+<?= Html::encode($contacts['phone']) ?>">
                                    <span class="contact-item-icon" aria-hidden="true">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <span>
                                        <span class="contact-item-label"><?= Html::encode($contactLabels['phoneLabel'] ?? '') ?></span>
                                        <span class="contact-item-value">
                                            <?= Html::encode($contacts['phoneDisplay'] ?? ('+' . $contacts['phone'])) ?>
                                        </span>
                                    </span>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="contact-list-column">
                            <?php if (!empty($contacts['instagram'])): ?>
                                <a class="contact-item contact-item-link" href="<?= Html::encode($contacts['instagram']) ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="contact-item-icon contact-item-icon-instagram" aria-hidden="true">
                                        <i class="fa fa-instagram"></i>
                                    </span>
                                    <span>
                                        <span class="contact-item-label"><?= Html::encode($contactLabels['instagramLabel'] ?? '') ?></span>
                                        <span class="contact-item-value">@newthinkingschool.kg</span>
                                    </span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($contacts['youtube'])): ?>
                                <a class="contact-item contact-item-link" href="<?= Html::encode($contacts['youtube']) ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="contact-item-icon contact-item-icon-youtube" aria-hidden="true">
                                        <i class="fa fa-youtube-play"></i>
                                    </span>
                                    <span>
                                        <span class="contact-item-label">YouTube</span>
                                        <span class="contact-item-value">@newthinkingschoolkg</span>
                                    </span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($contacts['facebook'])): ?>
                                <a class="contact-item contact-item-link" href="<?= Html::encode($contacts['facebook']) ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="contact-item-icon contact-item-icon-facebook" aria-hidden="true">
                                        <i class="fa fa-facebook"></i>
                                    </span>
                                    <span>
                                        <span class="contact-item-label">Facebook</span>
                                        <span class="contact-item-value">New Thinking School</span>
                                    </span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($mapCoordinatesQuery || $mapQuery): ?>
                        <section class="contact-map-section" aria-label="<?= Html::encode($contactLabels['mapTitle'] ?? '') ?>">
                            <h2 class="h5 fw-bold mb-3"><?= Html::encode($contactLabels['mapTitle'] ?? '') ?></h2>
                            <div class="contact-map">
                                <iframe
                                    src="<?= Html::encode($mapSrc) ?>"
                                    title="<?= Html::encode($contactLabels['mapTitle'] ?? '') ?>"
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
