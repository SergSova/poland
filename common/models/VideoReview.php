<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%video_review}}".
 *
 * @property integer $id
 * @property string $video
 * @property string $description
 * @property string $title
 */
class VideoReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%video_review}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video', 'description', 'title'], 'required'],
            [['description'], 'string'],
            [['video', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video' => 'Video',
            'description' => 'Description',
            'title' => 'Title'
        ];
    }
}
