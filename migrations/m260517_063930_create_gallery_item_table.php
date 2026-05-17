<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `{{%gallery_item}}`.
 */
class m260517_063930_create_gallery_item_table extends Migration
{
    private $tableName = '{{%gallery_item}}';
    private $galleryTableName = '{{%gallery}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'gallery_id' => $this->integer()->notNull()->comment('ID Галереи'),
            'title_ru' => $this->string()->comment('Название(Русский)'),
            'position' => $this->integer()->notNull()->defaultValue(0)->comment('Позиция'),
            'created_at' => $this->integer()->comment('Создана'),
            'updated_at' => $this->integer()->comment('Обновлена'),
        ], $this->tableOptions);

        $this->addForeignKey('fk_gallery_item_gallery_id', $this->tableName, 'gallery_id', $this->galleryTableName, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_gallery_item_gallery_id', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
