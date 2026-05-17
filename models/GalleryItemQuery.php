<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GalleryItem]].
 *
 * @see GalleryItem
 */
class GalleryItemQuery extends \yii\db\ActiveQuery
{
    /**
     * @return GalleryItemQuery
     */
    public function sorted()
    {
        return $this->orderBy(['position' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return GalleryItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GalleryItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
