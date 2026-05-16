<?php

namespace app\components;

use app\assets\NestableAsset;
use klisl\nestable\Nestable as BaseNestable;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Nestable extends BaseNestable
{
    public $root = false;
    public $viewMinimized = false;

    /**
     * Register client assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        NestableAsset::register($view);
        $this->registerPlugin('nestable');
    }

    /**
    * Render the list items for the sortable widget
    *
    * @return string
    */
    protected function renderItems($_items = NULL)
    {
        $_items = is_null($_items) ? $this->items : $_items;
        $items = '';
        $dataid = 0;
        foreach ($_items as $item) {
            if (!$item['root']) {
                $options = ArrayHelper::getValue($item, 'options', ['class' => 'dd-item dd3-item']);
                $options = ArrayHelper::merge($this->itemOptions, $options);
                $dataId  = ArrayHelper::getValue($item, 'id', $dataid++);
                $options = ArrayHelper::merge($options, ['data-id' => $dataId]);

                $contentOptions = ArrayHelper::getValue($item, 'contentOptions', ['class' => 'dd3-content']);
                $content = $this->handleLabel;
            } else {
                $content = '';
            }

            if (!$item['root']) {
                $id = $item['id']; //id item

                //create links (GridView) for viewing and manipulating the items.
                if ($this->viewMinimized) {
                    $spanMinimized = Html::tag('span', null, ['class' => "glyphicon glyphicon-tree-deciduous"]);
                    $aMinimized = Html::tag('a', $spanMinimized . '&nbsp; ', ['title' => 'Дерево', 'aria-label' => 'View', 'data-pjax' => '0', 'href'=> $this->viewMinimized .'?id=' . $id]);
                }
                $spanView = Html::tag('span', null, ['class' => "glyphicon glyphicon-eye-open"]);
                $aView = Html::tag('a', $spanView . '&nbsp; ', ['title' => 'View', 'aria-label' => 'View', 'data-pjax' => '0', 'href'=> $this->viewItem .'?id=' . $id]);
                $spanUpdate = Html::tag('span', null, ['class' => "glyphicon glyphicon-pencil"]);
                $aUpdate = Html::tag('a', $spanUpdate . '&nbsp; ', ['title' => 'Update', 'aria-label' => 'Update', 'data-pjax' => '0', 'href'=> $this->update .'?id=' . $id]);
                $spanDelete = Html::tag('span', null, ['class' => "glyphicon glyphicon-trash"]);
                $aDelete = Html::tag('a', $spanDelete . '&nbsp; ', ['title' => 'Delete', 'aria-label' => 'Delete', 'data-pjax' => '0', 'data-confirm' => 'Are you sure you want to delete this item?', 'data-method' => 'post', 'href'=> $this->delete .'?id=' . $id]);

                if ($this->viewMinimized) {
                    $links = Html::tag('div', $aMinimized . $aView . $aUpdate . $aDelete, ['class' => "actionColumn"]);
                } else {
                    $links = Html::tag('div', $aView . $aUpdate . $aDelete, ['class' => "actionColumn"]);
                }
                $item['content'] .= $links;

                $content .= Html::tag('div', ArrayHelper::getValue($item, 'content', ''), $contentOptions);
            }

            $children = ArrayHelper::getValue($item, 'children', []);
            if (!empty($children)) {
                // recursive rendering children items
                $content .= Html::beginTag('ol', ['class' => 'dd-list']);
                $content .= $this->renderItems($children);
                $content .= Html::endTag('ol');
            }

            $items .= $item['root'] ? $content : Html::tag('li', $content, $options) . PHP_EOL;
        }

        return $items;
   }

   /**
    * put your comment there...
    *
    * @param $activeQuery \yii\db\ActiveQuery
    * @return array
    */
    protected function prepareItems($activeQuery)
    {
        $items = [];
        foreach ($activeQuery->all() as $model) {
            $name = ArrayHelper::getValue($this->modelOptions, 'name', 'name');
            $items[] = [
                'id' => $model->getPrimaryKey(),
                'root' => $model->depth == 0 ? true : false,
                'content' => (is_callable($name) ? call_user_func($name, $model) : $model->{$name}),
                'children' => $this->root ? $model->depth < 1 ? $this->prepareItems($model->children(1)) : false : $this->prepareItems($model->children(1)),
            ];
        }
        return $items;
    }
}
