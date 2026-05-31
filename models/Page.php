<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Exception;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

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
 * @property string|null $title Название
 * @property string|null $menu_title_ru Название в меню(Русский)
 * @property string|null $menu_title_en Название в меню(Английский)
 * @property string|null $menu_title_ky Название в меню(Кыргызский)
 * @property string|null $menuTitle Название в меню
 * @property string|null $content_ru Содержимое(Русский)
 * @property string|null $content_en Содержимое(Английский)
 * @property string|null $content_ky Содержимое(Кыргызский)
 * @property string|null $content Содержимое
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
            [['is_active', 'is_main', 'show_in_menu', 'show_subpages'], 'default', 'value' => self::IS_NO],
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
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getLocalizedAttribute('title');
    }

    /**
     * @return mixed|string|null
     */
    public function getMenuTitle()
    {
        return $this->getLocalizedAttribute('menu_title') ?: $this->title;
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

    public function getUrl(): array
    {
        $lang = Yii::$app->params['lang'] ?? 'ru';

        if ((int)$this->is_main === self::IS_YES) {
            return ['/site/index', 'lang' => $lang];
        }

        return [
            '/site/index',
            'lang' => $lang,
            'slug' => $this->slug,
        ];
    }

    public static function getMenuItems(): array
    {
        $rootPage = Page::find()->roots()->one();

        if ($rootPage === null) {
            $rootPage = new Page();
            $rootPage->slug = 'root-service-page-non-editable';
            $rootPage->title_ru = 'Root';
            $rootPage->title_en = 'Root';
            $rootPage->title_ky = 'Root';
            $rootPage->menu_title_ru = 'Root';
            $rootPage->menu_title_en = 'Root';
            $rootPage->menu_title_ky = 'Root';

            if (!$rootPage->makeRoot()) {
                throw new Exception('Базовая страница отсутствует.');
            }
        }

        $items = [];

        $children = $rootPage->children(1)->sortedByTree()->active()->visibleInMenu()->all();

        foreach ($children as $page) {
            $items[] = self::buildMenuItem($page);
        }

        $lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
        $language = Yii::$app->params['languages'][$lang] ?? [];

        $menu = $language['menu'] ?? [];

//        $items[] = [
//            'label' => $menu['news'] ?? 'Новости',
//            'url' => ['/news/index', 'lang' => $lang],
//        ];
//
//        $items[] = [
//            'label' => $menu['contacts'] ?? 'Контакты',
//            'url' => ['/site/contact', 'lang' => $lang],
//        ];

        return $items;
    }

    protected static function buildMenuItem(Page $page): array
    {
        $item = [
            'label' => Html::encode($page->menuTitle),
            'url' => $page->url,
        ];

        $children = $page->children(1)->sortedByTree()->active()->visibleInMenu()->all();

        if ($children) {
            $item['items'] = [];

            foreach ($children as $child) {
                $item['items'][] = self::buildMenuItem($child);
            }
        }

        return $item;
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = [];

        $parents = $this->parents()
            ->andWhere(['<>', 'slug', 'root-service-page-non-editable'])
            ->orderBy(['lft' => SORT_ASC])
            ->all();

        foreach ($parents as $parent) {
            if ((int)$parent->is_main === self::IS_YES) {
                continue;
            }

            $breadcrumbs[] = [
                'label' => $parent->menuTitle,
                'url' => $parent->url,
            ];
        }

        if ((int)$this->is_main !== self::IS_YES) {
            $breadcrumbs[] = $this->menuTitle;
        }

        return $breadcrumbs;
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
