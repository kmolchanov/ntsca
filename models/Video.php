<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property int $id ID
 * @property string|null $title_ru Название(Русский)
 * @property string|null $title_en Название(Английский)
 * @property string|null $title_ky Название(Кыргызский)
 * @property string|null $description_ru Описание(Русский)
 * @property string|null $description_en Описание(Английский)
 * @property string|null $description_ky Описание(Кыргызский)
 * @property string $url Ссылка
 * @property int $description_position Расположение описания
 * @property string $descriptionPositionString Расположение описания
 * @property int|null $created_at Создано
 * @property int|null $updated_at Обновлено
 */
class Video extends \yii\db\ActiveRecord
{
    const DESCRIPTION_POSITION_NONE = 0;
    const DESCRIPTION_POSITION_TOP = 1;
    const DESCRIPTION_POSITION_BOTTOM = 2;
    const DESCRIPTION_POSITION_LEFT = 3;
    const DESCRIPTION_POSITION_RIGHT = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
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
            [['title_ru', 'title_en', 'title_ky', 'url', 'description_position'], 'required'],
            [['title_ru', 'title_en', 'title_ky', 'url'], 'string', 'max' => 255],
            [['description_ru', 'description_en', 'description_ky'], 'string'],
            [['url'], 'url'],
            [['description_position'], 'integer'],
            [['description_position'], 'in', 'range' => [self::DESCRIPTION_POSITION_NONE, self::DESCRIPTION_POSITION_TOP, self::DESCRIPTION_POSITION_BOTTOM, self::DESCRIPTION_POSITION_LEFT, self::DESCRIPTION_POSITION_RIGHT]],
            [['description_position'], 'default', 'value' => self::DESCRIPTION_POSITION_NONE],
            [['created_at', 'updated_at'], 'integer'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Название(Русский)',
            'title_en' => 'Название(Английский)',
            'title_ky' => 'Название(Кыргызский)',
            'description_ru' => 'Описание(Русский)',
            'description_en' => 'Описание(Английский)',
            'description_ky' => 'Описание(Кыргызский)',
            'url' => 'Ссылка',
            'description_position' => 'Расположение описания',
            'descriptionPositionString' => 'Расположение описания',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return string|null
     */
    public function getYoutubePlayerHtml(): ?string
    {
        if (!$this->youtubeEmbedUrl) {
            return null;
        }

        return '
            <div class="embed-responsive embed-responsive-16by9">
                <iframe
                    class="embed-responsive-item"
                    src="' . Html::encode($this->youtubeEmbedUrl) . '"
                    allowfullscreen>
                </iframe>
            </div>
        ';
    }

    /**
     * @return string|null
     */
    public function getYoutubePreviewHtml(): ?string
    {
        if (!$this->youtubeEmbedUrl) {
            return null;
        }

        return '
            <div style="width: 180px;">
                <iframe
                    src="' . Html::encode($this->youtubeEmbedUrl) . '"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
            </div>
        ';
    }

    /**
     * @return string|null
     */
    public function getYoutubeId(): ?string
    {
        if (!$this->url) {
            return null;
        }

        $patterns = [
            '~youtube\.com/watch\?v=([^&]+)~',
            '~youtu\.be/([^?&]+)~',
            '~youtube\.com/embed/([^?&]+)~',
            '~youtube\.com/shorts/([^?&]+)~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getYoutubeEmbedUrl(): ?string
    {
        $id = $this->getYoutubeId();

        return 'https://www.youtube.com/embed/' . $id . '?' . http_build_query([
            'rel' => 0,
            'modestbranding' => 1,
            'controls' => 1,
            'showinfo' => 0,
        ]);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $apps = self::find()->sorted()->asArray()->all();

        $list = ArrayHelper::map($apps, 'id', 'title_ru');

        return $list;
    }

    /**
     * @return array
     */
    public static function getDescriptionPositionOptions()
    {
        return [
            self::DESCRIPTION_POSITION_NONE => 'Без текста',
            self::DESCRIPTION_POSITION_TOP => 'Описание сверху',
            self::DESCRIPTION_POSITION_BOTTOM => 'Описание снизу',
            self::DESCRIPTION_POSITION_LEFT => 'Описание слева',
            self::DESCRIPTION_POSITION_RIGHT => 'Описание справа',
        ];
    }

    /**
     * @return string
     */
    public function getDescriptionPositionString()
    {
        $options = self::getDescriptionPositionOptions();

        return $options[$this->description_position];
    }

    /**
     * {@inheritdoc}
     * @return VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VideoQuery(get_called_class());
    }
}
