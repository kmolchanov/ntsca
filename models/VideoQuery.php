<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Video]].
 *
 * @see Video
 */
class VideoQuery extends \yii\db\ActiveQuery
{
    /**
     * @return VideoQuery
     */
    public function sorted()
    {
        return $this->orderBy([Video::tableName() . '.title_ru' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return Video[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Video|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
