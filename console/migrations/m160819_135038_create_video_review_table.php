<?php

use yii\db\Migration;

/**
 * Handles the creation for table `video_review`.
 */
class m160819_135038_create_video_review_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%video_review}}', [
            'id' => $this->primaryKey(),
            'video'=>$this->string(255)->notNull(),
            'description'=>$this->text(),
            'title'=>$this->string(255),
            'create_at'          => $this->integer(),
            'update_at'          => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%video_review}}');
    }
}
