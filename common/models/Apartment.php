<?php

    namespace common\models;

    use Yii;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%apartment}}".
     *
     * @property integer $id
     * @property integer $realty_id
     * @property string  $house_year
     * @property string  $house_material
     * @property integer $house_floor_count
     * @property integer $room_count
     * @property string  $bathroom_type
     * @property double  $area
     * @property integer $floor
     * @property string  $rooms_area
     * @property string  $balcony
     * @property integer $kitchen_area
     * @property string $cover
     * @property string $photos
     *
     * @property Realty  $realty
     */
    class Apartment extends ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%apartment}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'realty_id',
                        'house_floor_count',
                        'room_count',
                        'floor',
                        'kitchen_area'
                    ],
                    'integer'
                ],
                [
                    [
                        'house_year',
                        'house_floor_count',
                        'room_count',
                        'bathroom_type',
                        'area',
                        'floor'
                    ],
                    'required'
                ],
                [
                    ['house_year'],
                    'safe'
                ],
                [
                    ['bathroom_type', 'photos'],
                    'string'
                ],
                [
                    ['area'],
                    'number'
                ],
                [
                    ['house_material'],
                    'string',
                    'max' => 50
                ],
                [
                    [
                        'rooms_area',
                        'balcony',
                        'cover'
                    ],
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
                'house_year' => 'Год постройки',
                'house_material' => 'Материл дома',
                'house_floor_count' => 'Этажность дома',
                'room_count' => 'Количество комнат',
                'bathroom_type' => 'Тип санузла',
                'area' => 'Площадь',
                'floor' => 'Этаж',
                'rooms_area' => 'Площадь комнат',
                'balcony' => 'Балкон',
                'kitchen_area' => 'Площадь кухни',
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
