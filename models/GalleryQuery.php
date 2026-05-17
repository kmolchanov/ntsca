<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Gallery]].
 *
 * @see Gallery
 */
class GalleryQuery extends \yii\db\ActiveQuery
{
    /**
     * @return GalleryQuery
     */
    public function sorted()
    {
        return $this->orderBy(['title_ru' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return Gallery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Gallery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
