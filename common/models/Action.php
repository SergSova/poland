<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\caching\DbDependency;
    use yii\db\Expression;
    use yii\debug\models\search\Db;
    use yii\helpers\ArrayHelper;
    use yii\web\UploadedFile;

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
        public $dateS;
        public $dateE;

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
                    'createdAtAttribute' => 'create_at',
                    'updatedAtAttribute' => 'update_at',
                    'value'              => time(),
                ],
                ['class' => ActionBehavior::className()],
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
                [['icon', 'value', 'dateS', 'dateE'], 'string', 'max' => 255,],
                ['dateS', 'default', 'value' => date(DATE_ATOM, time()),],
                ['dateE', 'default', 'value' => date(DATE_ATOM, strtotime('12-12-2036')),],
                ['title', 'unique',],
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


    }
