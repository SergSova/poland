<?php
    namespace backend\models;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\Realty;

    /**
     * RealtySearch represents the model behind the search form about `common\models\Realty`.
     */
    class RealtySearch extends Realty{
        //adding relation fields to filter
        public function attributes(){
            return array_merge(parent::attributes(), [
                'realtyType.name',
                'serviceType.name',
                'district.name',
            ]);
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'id',
                        'price',
                    ],
                    'integer'
                ],
                [
                    [
                        'address',
                        'status',
                        'realtyType.name',
                        'serviceType.name',
                        'district.name',
                    ],
                    'safe'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function scenarios(){
            // bypass scenarios() implementation in the parent class
            return Model::scenarios();
        }

        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function search($params){
            $query = Realty::find()
                           ->joinWith([
                                          'realtyType rt',
                                          'serviceType st',
                                          'district d'
                                      ]);

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                   ]);

            $this->load($params);

            if(!$this->validate()){
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                                       $this->tableName().'.id' => $this->id,
                                       'status' => $this->status
                                   ])
                  ->andFilterWhere([
                                       'like',
                                       'address',
                                       $this->address
                                   ])
                  ->andFilterWhere([
                                       'LIKE',
                                       'rt.name',
                                       $this->getAttribute('realtyType.name')
                                   ])
                  ->andFilterWhere([
                                       'LIKE',
                                       'st.name',
                                       $this->getAttribute('serviceType.name')
                                   ])
                  ->andFilterWhere([
                                       'LIKE',
                                       'd.name',
                                       $this->getAttribute('district.name')
                                   ]);
            //grid sorting conditions for relations
            $dataProvider->sort->attributes['realtyType.name'] = [
                'asc' => ['rt.name' => SORT_ASC],
                'desc' => ['rt.name' => SORT_DESC]
            ];
            $dataProvider->sort->attributes['serviceType.name'] = [
                'asc' => ['st.name' => SORT_ASC],
                'desc' => ['st.name' => SORT_DESC]
            ];
            $dataProvider->sort->attributes['district.name'] = [
                'asc' => ['d.name' => SORT_ASC],
                'desc' => ['d.name' => SORT_DESC]
            ];

            return $dataProvider;
        }
    }
