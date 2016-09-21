<?php

namespace common\models;

/**
 * This is the model class for table "nad_action_model".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $action_id
 *
 * @property Action $action
 * @property Realty $model
 */
class ActionModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nad_action_model';
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
