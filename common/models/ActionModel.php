<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%action_model}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $action_id
 * @property integer $create_at
 * @property integer $update_at

 *
 * @property Action $action
 * @property Realty $model
 */
class ActionModel extends \yii\db\ActiveRecord
{
    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_at',
                'updatedAtAttribute' => 'update_at',
                'value' => time(),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action_model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'action_id'], 'required'],
            [['model_id', 'action_id'], 'integer'],
            [['model_id', 'action_id'], 'unique', 'targetAttribute' => ['model_id', 'action_id'], 'message' => 'The combination of Model ID and Action ID has already been taken.'],
            [['action_id'], 'exist', 'skipOnError' => true, 'targetClass' => Action::className(), 'targetAttribute' => ['action_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Realty::className(), 'targetAttribute' => ['model_id' => 'id']],
            [['create_at','update_at'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'action_id' => 'Action ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Realty::className(), ['id' => 'model_id']);
    }
}
