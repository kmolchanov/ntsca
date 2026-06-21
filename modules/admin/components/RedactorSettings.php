<?php

namespace app\modules\admin\components;

class RedactorSettings
{
    public static function content(string $imageUpload, string $fileUpload): array
    {
        return array_merge(self::base(), [
            'imageCaption' => true,
            'imagePosition' => true,
            'imageResizable' => true,
            'imageUpload' => $imageUpload,
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
            ],
            'plugins' => [
                'imagemanager',
                'filemanager',
                'fullscreen',
                'table',
            ],
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
}
