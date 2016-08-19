<?php

    namespace common\models;

    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%service_type}}".
     *
     * @property integer $id
     * @property string $name
     *
     * @property Realty[] $realties
     */
    class ServiceType extends ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%service_type}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    ['name'],
                    'required'
                ],
                [
                    ['name'],
                    'string',
                    'max' => 255
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id' => 'ID',
                'name' => 'Тип услуги',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRealties(){
            return $this->hasMany(Realty::className(), ['service_type_id' => 'id']);
        }
    }
