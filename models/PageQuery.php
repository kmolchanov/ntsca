<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Page
 */
class PageQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    /**
     * @return PageQuery
     */
    public function active()
    {
        return $this->andWhere(['is_active' => Page::IS_YES]);
    }

    /**
     * @return PageQuery
     */
    public function visibleInMenu()
    {
        return $this->andWhere(['show_in_menu' => Page::IS_YES]);
    }

    /**
     * @return PageQuery
     */
    public function sortedByTree()
    {
        return $this->orderBy('lft');
    }

    /**
     * {@inheritdoc}
     * @return Page[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Page|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
