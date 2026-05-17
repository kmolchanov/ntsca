<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%page}}`.
 */
class m260517_100729_add_additional_columns_to_page_table extends Migration
{
    private $tableName = '{{%page}}';
    private $galleryTableName = '{{%gallery}}';
    private $videoTableName = '{{%video}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'top_gallery_id', $this->integer()->comment('ID Галереи(сверху)')->after('content_ky'));
        $this->addColumn($this->tableName, 'bottom_gallery_id', $this->integer()->comment('ID Галереи(снизу)')->after('top_gallery_id'));
        $this->addColumn($this->tableName, 'top_video_id', $this->integer()->comment('ID Видео(сверху)')->after('bottom_gallery_id'));
        $this->addColumn($this->tableName, 'bottom_video_id', $this->integer()->comment('ID Видео(снизу)')->after('top_video_id'));

        $this->addForeignKey('fk_page_top_gallery_id', $this->tableName, 'top_gallery_id', $this->galleryTableName, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_page_bottom_gallery_id', $this->tableName, 'bottom_gallery_id', $this->galleryTableName, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_page_top_video_id', $this->tableName, 'top_video_id', $this->videoTableName, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_page_bottom_video_id', $this->tableName, 'bottom_video_id', $this->videoTableName, 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_page_bottom_video_id', $this->tableName);
        $this->dropForeignKey('fk_page_top_video_id', $this->tableName);
        $this->dropForeignKey('fk_page_bottom_gallery_id', $this->tableName);
        $this->dropForeignKey('fk_page_top_gallery_id', $this->tableName);

        $this->dropColumn($this->tableName, 'bottom_video_id');
        $this->dropColumn($this->tableName, 'top_video_id');
        $this->dropColumn($this->tableName, 'bottom_gallery_id');
        $this->dropColumn($this->tableName, 'top_gallery_id');
    }
}
