<?php

namespace app\models;

use rico\yii2images\behaviors\ImageBehave;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id ID
 * @property string $slug Slug
 * @property string|null $title_ru Название(Русский)
 * @property string|null $title_en Название(Английский)
 * @property string|null $title_ky Название(Кыргызский)
 * @property string|null $description_ru Краткое описание(Русский)
 * @property string|null $description_en Краткое описание(Английский)
 * @property string|null $description_ky Краткое описание(Кыргызский)
 * @property string|null $content_ru Содержимое(Русский)
 * @property string|null $content_en Содержимое(Английский)
 * @property string|null $content_ky Содержимое(Кыргызский)
 * @property string $date Дата
 * @property int|null $top_gallery_id ID Галереи(сверху)
 * @property int|null $bottom_gallery_id ID Галереи(снизу)
 * @property int|null $top_video_id ID Видео(сверху)
 * @property int|null $bottom_video_id ID Видео(снизу)
 * @property int $is_active Активная
 * @property int|null $created_at Создана
 * @property int|null $updated_at Обновлена
 *
 * @property Gallery $bottomGallery
 * @property Video $bottomVideo
 * @property Gallery $topGallery
 * @property Video $topVideo
 */
class News extends \yii\db\ActiveRecord
{
    const IS_NO = 0;
    const IS_YES = 1;

    public $images;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title_ru', 'title_en', 'title_ky', 'date'], 'required'],
            [['description_ru', 'description_en', 'description_ky', 'content_ru', 'content_en', 'content_ky'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['top_gallery_id', 'bottom_gallery_id', 'top_video_id', 'bottom_video_id', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['slug'], 'string', 'max' => 128],
            [['title_ru', 'title_en', 'title_ky'], 'string', 'max' => 255],
            [['is_active'], 'in', 'range' => [self::IS_NO, self::IS_YES]],
            [['is_active'], 'default', 'value' => self::IS_NO],
            [['slug'], 'unique'],
            [['images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
            [['bottom_gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['bottom_gallery_id' => 'id']],
            [['bottom_video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['bottom_video_id' => 'id']],
            [['top_gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['top_gallery_id' => 'id']],
            [['top_video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['top_video_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title_ru' => 'Название(Русский)',
            'title_en' => 'Название(Английский)',
            'title_ky' => 'Название(Кыргызский)',
            'images' => 'Изображение',
            'description_ru' => 'Краткое описание(Русский)',
            'description_en' => 'Краткое описание(Английский)',
            'description_ky' => 'Краткое описание(Кыргызский)',
            'content_ru' => 'Содержимое(Русский)',
            'content_en' => 'Содержимое(Английский)',
            'content_ky' => 'Содержимое(Кыргызский)',
            'date' => 'Дата',
            'top_gallery_id' => 'Галерея(сверху)',
            'bottom_gallery_id' => 'Галерея(снизу)',
            'top_video_id' => 'Видео(сверху)',
            'bottom_video_id' => 'Видео(снизу)',
            'is_active' => 'Активная',
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
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getLocalizedAttribute('title');
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getLocalizedAttribute('description');
    }

    /**
     * @return string|null
     */
    public function getContent()
    {
        return $this->getLocalizedAttribute('content');
    }

    /**
     * @param string $attribute
     * @return string|null
     */
    protected function getLocalizedAttribute(string $attribute): ?string
    {
        $lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
        $field = $attribute . '_' . $lang;

        return $this->{$field} ?: $this->{$attribute . '_ru'};
    }

    /**
     * Gets query for [[BottomGallery]].
     *
     * @return \yii\db\ActiveQuery|GalleryQuery
     */
    public function getBottomGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'bottom_gallery_id']);
    }

    /**
     * Gets query for [[BottomVideo]].
     *
     * @return \yii\db\ActiveQuery|VideoQuery
     */
    public function getBottomVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'bottom_video_id']);
    }

    /**
     * Gets query for [[TopGallery]].
     *
     * @return \yii\db\ActiveQuery|GalleryQuery
     */
    public function getTopGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'top_gallery_id']);
    }

    /**
     * Gets query for [[TopVideo]].
     *
     * @return \yii\db\ActiveQuery|VideoQuery
     */
    public function getTopVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'top_video_id']);
    }

    /**
     * {@inheritdoc}
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }
}
