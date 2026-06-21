<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m260614_141422_create_news_table extends Migration
{
    private $tableName = '{{%news}}';
    private $galleryTableName = '{{%gallery}}';
    private $videoTableName = '{{%video}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'slug' => $this->string(128)->notNull()->comment('Slug'),
            'title_ru' => $this->string()->comment('Название(Русский)'),
            'title_en' => $this->string()->comment('Название(Английский)'),
            'title_ky' => $this->string()->comment('Название(Кыргызский)'),
            'description_ru' => $this->text()->comment('Краткое описание(Русский)'),
            'description_en' => $this->text()->comment('Краткое описание(Английский)'),
            'description_ky' => $this->text()->comment('Краткое описание(Кыргызский)'),
            'content_ru' => $this->text()->comment('Содержимое(Русский)'),
            'content_en' => $this->text()->comment('Содержимое(Английский)'),
            'content_ky' => $this->text()->comment('Содержимое(Кыргызский)'),
            'date' => $this->date()->notNull()->comment('Дата'),
            'top_gallery_id' => $this->integer()->comment('ID Галереи(сверху)'),
            'bottom_gallery_id' => $this->integer()->comment('ID Галереи(снизу)'),
            'top_video_id' => $this->integer()->comment('ID Видео(сверху)'),
            'bottom_video_id' => $this->integer()->comment('ID Видео(снизу)'),
            'is_active' => $this->boolean()->notNull()->defaultValue(false)->comment('Активная'),
            'created_at' => $this->integer()->comment('Создана'),
            'updated_at' => $this->integer()->comment('Обновлена'),
        ], $this->tableOptions);

        $this->createIndex('news_slug_unique', $this->tableName, ['slug'], true);

        $this->addForeignKey('fk_news_top_gallery_id', $this->tableName, 'top_gallery_id', $this->galleryTableName, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_news_bottom_gallery_id', $this->tableName, 'bottom_gallery_id', $this->galleryTableName, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_news_top_video_id', $this->tableName, 'top_video_id', $this->videoTableName, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_news_bottom_video_id', $this->tableName, 'bottom_video_id', $this->videoTableName, 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_news_bottom_video_id', $this->tableName);
        $this->dropForeignKey('fk_news_top_video_id', $this->tableName);
        $this->dropForeignKey('fk_news_bottom_gallery_id', $this->tableName);
        $this->dropForeignKey('fk_news_top_gallery_id', $this->tableName);

        $this->dropIndex('news_slug_unique', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
