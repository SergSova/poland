<?php
    namespace frontend\models;

    use common\models\Realty;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use yii\db\Query;

    class Search extends Model{
        public $districtId;
        public $realtyTypeId;
        public $serviceTypeId;

        public $price;
        public $house_area;
        public $house_distance;

        public $apartment_area;
        public $apartment_rooms;

        public static function getPriceInterval($realtyTypeId){
            $query = new Query();
            $price = $query->select('price')
                           ->from(Realty::tableName())
                           ->where(['realty_type_id' => $realtyTypeId]);
            $minPrice = $price->min('price');
            $maxPrice = $price->max('price');

            return [$minPrice, $maxPrice];
        }

        public static function getInterval($field, $table){
            $className = 'common\models\\'.ucfirst($table);
            $query = new Query();
            $prop = $query->select($field)
                          ->from($className::tableName());
            $minProp = $prop->min($field);
            $maxProp = $prop->max($field);

            return [$minProp, $maxProp];
        }

        public function rules(){
            return [
                [
                    [
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

        public function search($params){
            $query = Realty::find()
                           ->joinWith([
                                          'house h',
                                          'apartment ap'
                                      ]);
            $query->where(['status'=>['active', 'deposit']]);
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