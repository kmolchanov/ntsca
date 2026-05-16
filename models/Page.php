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
 * @property int $is_active Активная
 * @property int $is_main Главная
 * @property int $show_in_menu Показывать в меню
 * @property int $show_subpages Показывать подстраницы
 * @property int|null $created_at Создана
 * @property int|null $updated_at Обновлена
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
            [['parent_id', 'is_active', 'is_main', 'show_in_menu', 'show_subpages', 'created_at', 'updated_at'], 'integer'],
            [['slug'], 'string', 'max' => 128],
            [['title_ru', 'title_en', 'title_ky', 'menu_title_ru', 'menu_title_en', 'menu_title_ky'], 'string', 'max' => 255],
            [['slug'], 'unique', 'targetAttribute' => ['slug']],
            [['parent_id'], 'isNotChild'],
            [['parent_id'], 'isNotSame'],
            [['is_active', 'is_main', 'show_in_menu', 'show_subpages'], 'in', 'range' => [self::IS_NO, self::IS_YES]],
            [['is_active', 'is_main', 'show_in_menu', 'show_subpages'], 'default', 'value' => self::IS_YES],
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
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
