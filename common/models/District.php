<?php

    namespace common\models;

    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%district}}".
     *
     * @property integer $id
     * @property string $name
     *
     * @property Realty[] $realties
     */
    class District extends ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%district}}';
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
                'name' => 'Район/Направление',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRealties(){
            return $this->hasMany(Realty::className(), ['district_id' => 'id']);
        }
    }
