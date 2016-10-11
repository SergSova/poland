<?php

    namespace common\models;

    use common\models\Behaviors\ActionBehavior;
    use common\models\Behaviors\FileSaveBehavior;
    use yii\behaviors\TimestampBehavior;
    use yii\caching\DbDependency;

    /**
     * This is the model class for table "{{%action}}".
     *
     * @property integer       $id
     * @property string        $title
     * @property string        $name
     * @property string        $icon
     * @property integer       $date_start
     * @property integer       $date_end
     * @property string        $value
     * @property string        $status
     * @property integer       $create_at
     * @property integer       $update_at
     *
     * @property ActionModel[] $actionModels
     * @property Realty[]      $models
     */
    class Action extends \yii\db\ActiveRecord{

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%action}}';
        }

        public function behaviors(){
            return [
                [
                    'class'              => TimestampBehavior::className(),
                    'value'              => time(),
                ],
                ['class' => ActionBehavior::className()],
                ['class' => FileSaveBehavior::className(),],
            ];
        }


        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['title', 'name',], 'required',],
                ['status', 'string',],
                ['status', 'default', 'value' => 'active',],
                [['date_start', 'date_end',], 'integer',],
                ['title', 'string', 'max' => 150,],
                ['name', 'string', 'max' => 50,],
                [['icon', 'value'], 'string', 'max' => 255,],
                ['title', 'unique',],

                [['dateS', 'dateE'], 'string'],
                ['dateS', 'default', 'value' => date(DATE_ATOM, time()),],
                ['dateE', 'default', 'value' => date(DATE_ATOM, strtotime('12-12-2036')),],

            ];
        }

        public function scenarios(){
            return [
                'default' => [
                    'title',
                    'name',
                    'status',
                    'dateS',
                    'dateE',
                    'value',
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'         => 'ID',
                'title'      => 'Название',
                'name'       => 'Name',
                'icon'       => 'Иконка',
                'date_start' => 'Дата начала',
                'date_end'   => 'Дата окончания',
                'dateS'      => 'Дата начала',
                'dateE'      => 'Дата окончания',
                'value'      => 'Значение',
                'status'     => 'Статус',
                'imgPath'    => 'Иконка',
            ];
        }


        /**
         * @return \yii\db\ActiveQuery
         */
        public function getActionModels(){
            return $this->hasMany(ActionModel::className(), ['action_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getModels(){
            return $this->hasMany(Realty::className(), ['id' => 'model_id'])
                        ->viaTable(ActionModel::tableName(), ['action_id' => 'id']);
        }

        /**
         * @return mixed Return caching data
         */
        public static function getAll(){
            return self::getDb()
                       ->cache(function(){
                           return self::find()
                                      ->all();
                       }, 3600 * 24 * 30, new DbDependency(['sql' => 'SELECT MAX(update_at) FROM '.self::tableName()]));
        }
    }
