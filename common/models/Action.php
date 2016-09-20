<?php

    namespace common\models;

    use Yii;
    use yii\web\UploadedFile;

    /**
     * This is the model class for table "nad_action".
     *
     * @property integer       $id
     * @property string        $title
     * @property string        $name
     * @property string        $description
     * @property string        $icon
     * @property integer       $date_start
     * @property integer       $date_end
     * @property string        $value
     * @property string        $status
     *
     * @property ActionModel[] $actionModels
     * @property Realty[]      $models
     */
    class Action extends \yii\db\ActiveRecord{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return 'nad_action';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'title',
                        'name',
                        'description',
                        'date_start',
                        'date_end',
                        'value'
                    ],
                    'required'
                ],
                [
                    [
                        'description',
                        'status'
                    ],
                    'string'
                ],
                [
                    [
                        'date_start',
                        'date_end'
                    ],
                    'integer'
                ],
                [
                    ['title'],
                    'string',
                    'max' => 150
                ],
                [
                    ['name'],
                    'string',
                    'max' => 50
                ],
                [
                    [
                        'icon',
                        'value'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    ['title'],
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
                'title' => 'Название',
                'name' => 'Name',
                'description' => 'Описание',
                'icon' => 'Иконка',
                'date_start' => 'Дата начала',
                'date_end' => 'Дата окончания',
                'value' => 'Значение',
                'status' => 'Status',
                'imgPath' => 'Иконка',
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
                        ->viaTable('nad_action_model', ['action_id' => 'id']);
        }

        public function upload(){
            $file = UploadedFile::getInstance($this, 'icon');
            if($file){
                $basePath = Yii::getAlias('@wwwRoot');
                $fileName = 'img/'.$file->name;
                if(file_exists($basePath.DIRECTORY_SEPARATOR.$fileName)){
                    $this->icon = $fileName;

                    return true;
                }else{
                    $this->icon = $fileName;

                    return $file->saveAs($basePath.DIRECTORY_SEPARATOR.$fileName);
                }
            }
            $this->icon = $this->oldAttributes['icon'];
            return true;
        }

        public function getImgPath(){
            return Yii::getAlias('@wwwUrl').DIRECTORY_SEPARATOR.$this->icon;
        }

    }
