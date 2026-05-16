<?php

/**
 * @copyright Copyright &copy; Arno Slatius 2015
 * @package yii2-nestable
 * @version 1.0
 */

namespace app\assets;

/**
 * Nestable bundle for \klisl\nestable\Sortable
 *
 * @author Arno Slatius <a.slatius@gmail.com>
 * @since 1.0
 */
class NestableAsset extends \kartik\base\AssetBundle {

    public function init() {
        $this->setupAssets('js', ['js/jquery.nestable']);
        $this->setupAssets('css', ['css/nestable']);
        parent::init();
    }

    /**
     * Set up CSS and JS asset arrays based on the base-file names
     *
     * @param string $type whether 'css' or 'js'
     * @param array $files the list of 'css' or 'js' basefile names
     */
    protected function setupAssets($type, $files = [])
    {
        if ($this->$type === self::KRAJEE_ASSET) {
            $srcFiles = [];
            foreach ($files as $file) {
                $srcFiles[] = "{$file}.{$type}";
            }
            $this->$type = $srcFiles;
        } elseif ($this->$type === self::EMPTY_ASSET) {
            $this->$type = [];
        }
    }
}