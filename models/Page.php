<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id ID
 * @property int $lft Left
 * @property int $rgt Right
 * @property int $depth Depth
 * @property string $slug Slug
 * @property string|null $title_ru Название(Русский)
 * @property string|null $title_en Название(Английский)
 * @property string|null $title_ky Название(Кыргызский)
 * @property string|null $menu_title_ru Название в меню(Русский)
 * @property string|null $menu_title_en Название в меню(Английский)
 * @property string|null $menu_title_ky Название в меню(Кыргызский)
 * @property string|null $content_ru Содержимое(Русский)
 * @property string|null $content_en Содержимое(Английский)
 * @property string|null $content_ky Содержимое(Кыргызский)
 * @property int|null $top_gallery_id ID Галереи(сверху)
 * @property int|null $bottom_gallery_id ID Галереи(снизу)
 * @property int|null $top_video_id ID Видео(сверху)
 * @property int|null $bottom_video_id ID Видео(снизу)
 * @property int $is_active Активная
 * @property int $is_main Главная
 * @property int $show_in_menu Показывать в меню
 * @property int $show_subpages Показывать подстраницы
 * @property int|null $created_at Создана
 * @property int|null $updated_at Обновлена
 *
 * @property Gallery $topGallery
 * @property Gallery $bottomGallery
 * @property Video $topVideo
 * @property Video $bottomVideo
 */
class Page extends \yii\db\ActiveRecord
{
    const IS_NO = 0;
    const IS_YES = 1;

    public $parent_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'depth',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title_ru', 'title_en', 'title_ky', 'menu_title_ru', 'menu_title_en', 'menu_title_ky'], 'required'],
            [['parent_id', 'top_gallery_id', 'bottom_gallery_id', 'top_video_id', 'bottom_video_id', 'is_active', 'is_main', 'show_in_menu', 'show_subpages', 'created_at', 'updated_at'], 'integer'],
            [['slug'], 'string', 'max' => 128],
            [['title_ru', 'title_en', 'title_ky', 'menu_title_ru', 'menu_title_en', 'menu_title_ky'], 'string', 'max' => 255],
            [['content_ru', 'content_en', 'content_ky'], 'string'],
            [['slug'], 'unique', 'targetAttribute' => ['slug']],
            [['parent_id'], 'isNotChild'],
            [['parent_id'], 'isNotSame'],
            [['is_active', 'is_main', 'show_in_menu', 'show_subpages'], 'in', 'range' => [self::IS_NO, self::IS_YES]],
            [['is_active', 'is_main', 'show_in_menu', 'show_subpages'], 'default', 'value' => self::IS_YES],
            [['top_gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['top_gallery_id' => 'id']],
            [['bottom_gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['bottom_gallery_id' => 'id']],
            [['top_video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['top_video_id' => 'id']],
            [['bottom_video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['bottom_video_id' => 'id']],
        ];
    }

    /**
     * @param $attribute
     */
    public function isNotChild($attribute)
    {
        $parent = self::findOne($this->$attribute);

        if ($parent->isChildOf($this)) {
            $this->addError($attribute, 'Нельзя добавить к собственному потомку.');
        }
    }

    /**
     * @param $attribute
     */
    public function isNotSame($attribute)
    {
        $parent = self::findOne($this->$attribute);

        if ($parent->id == $this->id) {
            $this->addError($attribute, 'Родительская страница должна отличаться.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Родительская страница',
            'parent_id' => 'Родительская страница',
            'slug' => 'Slug',
            'title_ru' => 'Название(Русский)',
            'title_en' => 'Название(Английский)',
            'title_ky' => 'Название(Кыргызский)',
            'menu_title_ru' => 'Название в меню(Русский)',
            'menu_title_en' => 'Название в меню(Английский)',
            'menu_title_ky' => 'Название в меню(Кыргызский)',
            'content_ru' => 'Содержимое(Русский)',
            'content_en' => 'Содержимое(Английский)',
            'content_ky' => 'Содержимое(Кыргызский)',
            'top_gallery_id' => 'Галерея(сверху)',
            'bottom_gallery_id' => 'Галерея(снизу)',
            'top_video_id' => 'Видео(сверху)',
            'bottom_video_id' => 'Видео(снизу)',
            'is_active' => 'Активная',
            'is_main' => 'Главная',
            'show_in_menu' => 'Показывать в меню',
            'show_subpages' => 'Показывать подстраницы',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    /**
     * @inheritDoc
     */
    public function afterFind()
    {
        parent::afterFind();

        $parent = $this->parents(1)->one();
        $this->parent_id = !empty($parent) ? $parent->id : null;
    }

    /**
     * Checks whether page has a parent
     * @return bool
     */
    public function getHasParent()
    {
        if ($this->parents()->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks whether page has a child
     * @return bool
     */
    public function getHasChild()
    {
        if ($this->children()->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $list = [];
        $roots = self::find()->roots()->sortedByTree()->all();

        foreach ($roots as $root) {
            $pages = $root->children()->all();
            foreach ($pages as $page) {
                $spaces = str_repeat('&nbsp&nbsp&nbsp', $page->depth);
                $title = $spaces.$page->title_ru;
                $list[$page->id] = $title;
            }
        }

        return $list;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parents(1);
    }

    /**
     * @return mixed
     */
    public function getSubpages()
    {
        return $this->children(1)->all();
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
     * Gets query for [[BottomGallery]].
     *
     * @return \yii\db\ActiveQuery|GalleryQuery
     */
    public function getBottomGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'bottom_gallery_id']);
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
     * Gets query for [[BottomVideo]].
     *
     * @return \yii\db\ActiveQuery|VideoQuery
     */
    public function getBottomVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'bottom_video_id']);
    }

    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
