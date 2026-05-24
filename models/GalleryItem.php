<?php

namespace app\models;

use himiklab\sortablegrid\SortableGridBehavior;
use rico\yii2images\behaviors\ImageBehave;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%gallery_item}}".
 *
 * @property int $id ID
 * @property int $gallery_id ID Галереи
 * @property string|null $title_ru Название(Русский)
 * @property int $position Позиция
 * @property int|null $created_at Создана
 * @property int|null $updated_at Обновлена
 *
 * @property Gallery $gallery
 */
class GalleryItem extends \yii\db\ActiveRecord
{
    public $images;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gallery_item}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'image' => [
                'class' => ImageBehave::className(),
            ],
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'position',
                'scope' => function ($query) {
                    $query->andWhere(['gallery_id' => $this->gallery_id]);
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gallery_id', 'title_ru', 'images'], 'required'],
            [['gallery_id', 'position', 'created_at', 'updated_at'], 'integer'],
            [['title_ru'], 'string', 'max' => 255],
            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp'],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * @param $attribute
     * @return void
     */
    public function validateImageRequired($attribute)
    {
        if ($this->isNewRecord && empty($this->$attribute)) {
            $this->addError($attribute, 'Необходимо загрузить изображение.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gallery_id' => 'Галерея',
            'title_ru' => 'Название',
            'position' => 'Позиция',
            'images' => 'Изображение',
            'picture' => 'Изображение',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        $this->removeImages();

        return parent::beforeDelete();
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->getImage()->getUrl();
    }

    /**
     * @return mixed
     */
    public function getThumbnailPicture()
    {
        return $this->getImage()->getUrl('300x');
    }

    /**
     * @return mixed
     */
    public function getPictures()
    {
        $list = [];
        foreach ($this->getImages() as $image) {
            $list[] = [
                'picture' => $image->getUrl(),
                'thumbnailPicture' => $image->getUrl('300x'),
                'isMain' => $image->isMain,
            ];
        }

        return $list;
    }

    /**
     * Gets query for [[Gallery]].
     *
     * @return \yii\db\ActiveQuery|GalleryQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }

    /**
     * {@inheritdoc}
     * @return GalleryItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GalleryItemQuery(get_called_class());
    }
}
