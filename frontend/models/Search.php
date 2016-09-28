<?php
    namespace frontend\models;

    use common\models\Apartment;
    use common\models\House;
    use common\models\Realty;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;

    class Search extends Model{
        public $action_id;

        public $districtId;
        public $realtyTypeId;
        public $serviceTypeId;

        public $price;
        public $house_area;
        public $house_distance;

        public $apartment_area;
        public $apartment_rooms;

        public static function getPriceInterval($realtyTypeId){
            $minPrice = Realty::find()
                              ->where(['realty_type_id' => $realtyTypeId])
                              ->min('price');
            $maxPrice = Realty::find()
                              ->where(['realty_type_id' => $realtyTypeId])
                              ->max('price');

            return [
                $minPrice,
                $maxPrice
            ];
        }

        public static function getInterval($field, $table){

            /** @var Apartment|House $className */
            $className = 'common\models\\'.ucfirst($table);
            $minProp = $className::find()
                                 ->min($field);
            $maxProp = $className::find()
                                 ->max($field);

            return [
                $minProp,
                $maxProp
            ];
        }

        public function rules(){
            return [
                [
                    [
                        'action_id',
                        'districtId',
                        'realtyTypeId',
                        'serviceTypeId'
                    ],
                    'integer'
                ],
                [
                    [
                        'price',
                        'house_area',
                        'house_distance',
                        'apartment_area',
                    ],
                    'string'
                ],
                [
                    ['apartment_rooms'],
                    'safe'
                ]
            ];
        }

        public function attributeLabels(){
            return [
                'action_id' => 'Акции'
            ];
        }

        public function search($params){
            $query = Realty::find()
                           ->joinWith([
                                          'house h',
                                          'apartment ap'
                                      ]);
            $query->where([
                              'status' => [
                                  'active',
                                  'deposit'
                              ]
                          ]);
            $dataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                       'pagination' => [
                                                           'pageSize' => 9
                                                       ],
                                                   ]);

            $this->load($params);
            if(!$this->validate()){
                return $dataProvider;
            }

            $price = explode(';', $this->price);
            $hArea = explode(';', $this->house_area);
            $hDist = explode(';', $this->house_distance);
            $aArea = explode(';', $this->apartment_area);

            if($this->action_id){
                $query->joinWith(['actionModels'])
                      ->andFilterWhere(['action_id' => $this->action_id]);
            }

            $query->andFilterWhere([
                                       'district_id' => $this->districtId,
                                       'realty_type_id' => $this->realtyTypeId,
                                       'service_type_id' => $this->serviceTypeId
                                   ])
                  ->andFilterWhere([
                                       'between',
                                       'price',
                                       $price[0],
                                       $price[1]
                                   ])
                  ->andFilterWhere([
                                       'between',
                                       'h.house_area',
                                       $hArea[0],
                                       $hArea[1]
                                   ])
                  ->andFilterWhere([
                                       'between',
                                       'h.distance',
                                       $hDist[0],
                                       $hDist[1]
                                   ])
                  ->andFilterWhere([
                                       'between',
                                       'ap.area',
                                       $aArea[0],
                                       $aArea[1]
                                   ])
                  ->andFilterWhere([
                                       'in',
                                       'ap.room_count',
                                       $this->apartment_rooms,
                                   ]);

            return $dataProvider;
        }
    }