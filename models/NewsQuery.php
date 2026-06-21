<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class NewsQuery extends \yii\db\ActiveQuery
{
    /**
     * @return NewsQuery
     */
    public function active()
    {
        return $this->andWhere(['is_active' => News::IS_YES]);
    }

    /**
     * @return NewsQuery
     */
    public function sorted()
    {
        return $this->orderBy(['date' => SORT_DESC]);
    }

    /**
     * {@inheritdoc}
     * @return News[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
