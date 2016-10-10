<?php

    namespace common\models;

    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%realty_type}}".
     *
     * @property integer $id
     * @property string $name
     * @property string $realty_table
     *
     * @property Realty[] $realties
     */
    class RealtyType extends ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%realty_type}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'name',
                        'realty_table'
                    ],
                    'required'
                ],
                [
                    ['name'],
                    'string',
                    'max' => 255
                ],
                [
                    ['realty_table'],
                    'string',
                    'max' => 50
                ],
                [
                    ['realty_table'],
                    'unique'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id' => 'ID',
                'name' => 'Тип недвижимости',
                'realty_table' => 'Realty Table',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRealties(){
            return $this->hasMany(Realty::className(), ['realty_type_id' => 'id']);
        }
    }
