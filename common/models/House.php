<?php

    namespace common\models;

    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%house}}".
     *
     * @property integer $id
     * @property integer $realty_id
     * @property double  $house_area
     * @property double  $land_area
     * @property double  $distance
     * @property string  $house_type
     * @property string  $communication_water
     * @property string  $communication_electro
     * @property string  $communication_gas
     * @property string  $communication_sewage
     * @property string  $cover
     * @property string  $photos
     * @property string  $decor_inside
     * @property string  $decor_outside
     * @property string  $bath_count
     *
     * @property Realty  $realty
     */
    class House extends ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%house}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    ['realty_id'],
                    'integer'
                ],
                [
                    [
                        'house_area',
                        'land_area',
                        'distance',
                        'house_type'
                    ],
                    'required'
                ],
                [
                    [
                        'house_area',
                        'land_area',
                        'distance'
                    ],
                    'number'
                ],
                [
                    ['photos'],
                    'string'
                ],
                [
                    ['house_type'],
                    'string',
                    'max' => 10
                ],
                [
                    [
                        'communication_water',
                        'communication_electro',
                        'communication_gas',
                        'communication_sewage'
                    ],
                    'string',
                    'max' => 50
                ],
                [
                    ['decor_inside', 'decor_outside'],
                    'string',
                    'max' => 150
                ],
                [
                    ['cover', 'bath_count'],
                    'string',
                    'max' => 255
                ],
                [
                    ['realty_id'],
                    'unique'
                ],
                [
                    ['realty_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Realty::className(),
                    'targetAttribute' => ['realty_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id' => 'ID',
                'realty_id' => 'Realty ID',
                'house_area' => 'Площадь дома',
                'land_area' => 'Площадь Участка',
                'distance' => 'Расстояние от МКАД',
                'house_type' => 'Размер дома',
                'communication_water' => 'Вода',
                'communication_electro' => 'Электричество',
                'communication_gas' => 'Газ',
                'communication_sewage' => 'Канализация',
                'cover' => 'Cover',
                'photos' => 'Photos',
                'decor_inside' => 'Внутрення отделка',
                'decor_outside' => 'Внешняя отделка'
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRealty(){
            return $this->hasOne(Realty::className(), ['id' => 'realty_id']);
        }

        public function beforeSave($insert){
            if(empty($this->cover)){
                $photos = json_decode($this->photos);
                if(!empty($photos)){
                    $this->cover = $photos[0];
                }
            }

            return true;
        }
    }
