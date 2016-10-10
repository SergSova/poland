<?php

    namespace common\models;

    use cebe\markdown\Markdown;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\caching\ChainedDependency;
    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;
    use yii\db\Expression;

    /**
     * This is the model class for table "{{%realty}}".
     *
     * @property integer       $id
     * @property integer       $realty_type_id
     * @property integer       $service_type_id
     * @property integer       $district_id
     * @property integer       $price
     * @property string        $address
     * @property string        $map_coord
     * @property string        $short_description
     * @property string        $full_description
     * @property string        $status
     * @property integer       $create_at
     * @property integer       $update_at
     *
     *
     * @property ActionModel[] $actionModels
     * @property Action[]      $actions
     * @property Apartment     $apartment
     * @property House         $house
     * @property RealtyType    $realtyType
     * @property ServiceType   $serviceType
     * @property District      $district
     *
     * @method getActionForModel(ActiveRecord $this) parses and processes model->actions, generates @property newPrice if the model is linked to
     *         action discount
     */
    class Realty extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%realty}}';
        }

        public function behaviors(){
            return [
                'discount' => [
                    'class' => ActionForModelBehavior::className(),
                    'price' => 'price',
                ],
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
        public function rules(){
            return [
                [
                    [
                        'realty_type_id',
                        'service_type_id',
                        'district_id',
                        'price'
                    ],
                    'integer'
                ],
                [
                    [
                        'realty_type_id',
                        'service_type_id',
                        'district_id',
                        'price',
                        'address',
                        'map_coord',
                        'short_description',
                        'full_description'
                    ],
                    'required'
                ],
                [
                    [
                        'short_description',
                        'full_description',
                        'status'
                    ],
                    'string'
                ],
                [
                    [
                        'address',
                        'map_coord'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    ['realty_type_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => RealtyType::className(),
                    'targetAttribute' => ['realty_type_id' => 'id']
                ],
                [
                    ['service_type_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => ServiceType::className(),
                    'targetAttribute' => ['service_type_id' => 'id']
                ],
                [
                    ['district_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => District::className(),
                    'targetAttribute' => ['district_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id' => 'ID',
                'realty_type_id' => 'Realty Type ID',
                'service_type_id' => 'Тип услуги',
                'district_id' => 'Район/направление',
                'price' => 'Цена',
                'address' => 'Адрес',
                'map_coord' => 'Map Coord',
                'short_description' => 'Краткое описание',
                'full_description' => 'Полное описание',
                'status' => 'Статус',
            ];
        }


        /**
         * @return \yii\db\ActiveQuery
         */
        public function getActionModels(){
            return $this->hasMany(ActionModel::className(), ['model_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getActions(){
            return $this->hasMany(Action::className(), ['id' => 'action_id'])
                        ->viaTable(ActionModel::tableName(), ['model_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getApartment(){
            return $this->hasOne(Apartment::className(), ['realty_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getHouse(){
            return $this->hasOne(House::className(), ['realty_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRealtyType(){
            return $this->hasOne(RealtyType::className(), ['id' => 'realty_type_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getServiceType(){
            return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getDistrict(){
            return $this->hasOne(District::className(), ['id' => 'district_id']);
        }

        public function afterFind(){
            $this->getActionForModel($this);
        }

        /**
         * @param string  $name  name for action
         * @param integer $limit limits the size, if not specified returns all records
         *
         * @return array|\yii\db\ActiveRecord[]
         */
        public static function getModelWithActionName($name, $limit = null){
            $dependency = new ChainedDependency([
                                                    'dependencies' => [
                                                        new DbDependency(['sql' => 'SELECT MAX(update_at) FROM '.Realty::tableName()]),
                                                        new DbDependency(['sql' => 'SELECT MAX(update_at) FROM '.Action::tableName()]),
                                                        new DbDependency(['sql' => 'SELECT MAX(update_at) FROM '.ActionModel::tableName()]),
                                                    ],
                                                ]);

            $cache = self::getDb()
                         ->cache(function($db) use ($name, $limit){
                             $actions = Action::findOne(['name' => $name]);
                             if(!is_null($actions) && $actions->status = 'active'){
                                 return $actions->getActionModels()
                                                ->joinWith('model')
                                                ->where([
                                                            'status' => [
                                                                'active',
                                                                'deposit'
                                                            ]
                                                        ])
                                                ->orderBy(['id' => SORT_DESC])
                                                ->limit($limit)
                                                ->all();
                             }else{
                                 return [];
                             }
                         }, 3600 * 24 * 30, $dependency);
            $test = $dependency->getHasChanged($cache);
            if($test){
                Yii::$app->cache->flush();
            }

            return $cache;
        }

        /**
         * Combine and formatting coordinates realty for markers on the map
         * @return array
         */
        public static function getMarkerData(){
            $models = self::getDb()
                          ->cache(function($db){
                              return self::find()
                                         ->where([
                                                     'status' => [
                                                         'active',
                                                         'deposit'
                                                     ]
                                                 ])
                                         ->all();
                          });
            $markersData = [];
            foreach($models as $realty){
                $coord = explode(';', $realty->map_coord);
                $content = Yii::$app->controller->renderPartial('_map_prev', ['model' => $realty]);
                $markersData[] = [
                    'position' => [
                        'lat' => $coord[0] * 1,
                        'lng' => $coord[1] * 1
                    ],
                    'content' => $content
                ];
            }

            return $markersData;
        }

        public static function getAll(){
            return self::getDb()
                       ->cache(function(){
                           return self::find()
                                      ->all();
                       }, 3600 * 24 * 30, new DbDependency(['sql' => 'SELECT MAX(update_at) FROM '.self::tableName()]));
        }

        public function getBr_short_description(){
            return nl2br($this->short_description);
        }
        public function getBr_full_description(){
            return nl2br($this->full_description);
        }
    }
