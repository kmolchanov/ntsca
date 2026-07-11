<?php

namespace app\modules\admin\components;

class RedactorSettings
{
    public static function content(string $imageUpload, string $fileUpload, string $imageManagerJson): array
    {
        return array_merge(self::base(), [
            'imageCaption' => true,
            'imagePosition' => true,
            'imageResizable' => true,
            'imageUpload' => $imageUpload,
            'imageManagerJson' => $imageManagerJson,
            'fileUpload' => $fileUpload,
            'buttons' => [
                'formatting',
                'bold',
                'italic',
                'unorderedlist',
                'orderedlist',
                'outdent',
                'indent',
                'link',
                'image',
                'file',
                'table',
                'alignment',
                'horizontalrule',
                'clips',
            ],
            'plugins' => [
                'imagemanager',
                'filemanager',
                'fullscreen',
                'table',
            ],
            'clips' => self::contentBlocks(),
        ]);
    }

    public static function description(): array
    {
        return array_merge(self::base(), [
            'minHeight' => 180,
            'buttons' => [
                'formatting',
                'bold',
                'italic',
                'unorderedlist',
                'orderedlist',
                'outdent',
                'indent',
                'link',
                'alignment',
            ],
            'plugins' => [
                'fullscreen',
            ],
        ]);
    }

    private static function base(): array
    {
        return [
            'minHeight' => 300,
            'iframe' => false,
            'replaceDivs' => false,
            'cleanOnPaste' => true,
            'cleanup' => true,
            'removeEmptyTags' => true,
            'removeSpaces' => true,
            'paragraphize' => true,
            'deniedTags' => [
                'script',
                'style',
                'iframe',
                'object',
                'embed',
            ],
            'buttonsHideOnMobile' => [
                'outdent',
                'indent',
                'alignment',
                'horizontalrule',
            ],
        ];
    }

    private static function contentBlocks(): array
    {
        $imageSlot = <<<HTML
<div class="content-image-slot">
    <div class="content-image-slot-note">
        <strong>Место для изображения</strong>
        <span>Поставьте курсор сюда и вставьте изображение через кнопку изображения.</span>
    </div>
</div>
HTML;

        return [
            [
                'Hero: текст слева, фото справа',
                <<<HTML
<div class="content-block content-hero content-hero-image-right content-bauhaus">
    <div class="content-block-text">
        <p class="content-block-kicker">Короткая подпись</p>
        <h2>Заголовок блока</h2>
        <p>Добавьте основной текст. На компьютере он будет рядом с изображением, а на телефоне аккуратно перенесётся над картинкой.</p>
    </div>
    <div class="content-block-media">
        {$imageSlot}
    </div>
</div>
HTML
            ],
            [
                'Hero: фото слева, текст справа',
                <<<HTML
<div class="content-block content-hero content-hero-image-left content-bauhaus">
    <div class="content-block-media">
        {$imageSlot}
    </div>
    <div class="content-block-text">
        <p class="content-block-kicker">Короткая подпись</p>
        <h2>Заголовок блока</h2>
        <p>Замените этот текст и изображение на нужные материалы. Блок автоматически станет вертикальным на мобильных устройствах.</p>
    </div>
</div>
HTML
            ],
            [
                'Цветной акцентный блок',
                <<<HTML
<div class="content-block content-accent content-bauhaus">
    <p class="content-block-kicker">Важно</p>
    <h2>Акцентный заголовок</h2>
    <p>Используйте этот блок для короткого важного сообщения, объявления, преимущества или вводного текста страницы.</p>
</div>
HTML
            ],
            [
                'Блок с подложкой и изображением',
                <<<HTML
<div class="content-block content-feature content-bauhaus">
    <div class="content-block-media">
        {$imageSlot}
    </div>
    <div class="content-block-text">
        <h2>Заголовок с изображением</h2>
        <p>Такой блок подходит для рассказа о программе, кампусе, подходе к обучению или событии.</p>
    </div>
</div>
HTML
            ],
            [
                'Две текстовые колонки',
                <<<HTML
<div class="content-block content-two-columns">
    <div>
        <h3>Первый заголовок</h3>
        <p>Текст первой колонки. На мобильных устройствах колонки станут друг под другом.</p>
    </div>
    <div>
        <h3>Второй заголовок</h3>
        <p>Текст второй колонки. Можно использовать для сравнения, описания этапов или преимуществ.</p>
    </div>
</div>
HTML
            ],
            [
                'Карточки преимуществ',
                <<<HTML
<div class="content-block content-cards">
    <div class="content-mini-card">
        <h3>Преимущество</h3>
        <p>Короткое описание.</p>
    </div>
    <div class="content-mini-card">
        <h3>Преимущество</h3>
        <p>Короткое описание.</p>
    </div>
    <div class="content-mini-card">
        <h3>Преимущество</h3>
        <p>Короткое описание.</p>
    </div>
</div>
HTML
            ],
            [
                'Этапы / шаги',
                <<<HTML
<div class="content-block content-steps">
    <div class="content-step">
        <span>01</span>
        <h3>Первый шаг</h3>
        <p>Описание шага.</p>
    </div>
    <div class="content-step">
        <span>02</span>
        <h3>Второй шаг</h3>
        <p>Описание шага.</p>
    </div>
    <div class="content-step">
        <span>03</span>
        <h3>Третий шаг</h3>
        <p>Описание шага.</p>
    </div>
</div>
HTML
            ],
            [
                'Цитата / крупный акцент',
                <<<HTML
<blockquote class="content-block content-quote content-bauhaus">
    <p>Крупная мысль, цитата или смысловой акцент страницы.</p>
    <footer>Подпись или источник</footer>
</blockquote>
HTML
            ],
        ];
    }
}
