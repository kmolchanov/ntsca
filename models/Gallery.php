<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property int $id ID
 * @property string|null $title_ru Название(Русский)
 * @property int|null $created_at Создана
 * @property int|null $updated_at Обновлена
 *
 * @property GalleryItem[] $items
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gallery}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Название',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        foreach ($this->items as $item) {
            $item->delete();
        }

        return parent::beforeDelete();
    }

        /**
     * @return array
     */
    public static function getList()
    {
        $galleries = self::find()->sorted()->asArray()->all();

        $list = ArrayHelper::map($galleries, 'id', 'title_ru');

        return $list;
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery|GalleryItemQuery
     */
    public function getItems()
    {
        return $this->hasMany(GalleryItem::className(), ['gallery_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GalleryQuery(get_called_class());
    }
}
