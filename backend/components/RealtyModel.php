<?php
    namespace backend\components;

    use common\models\ActionModel;
    use common\models\Apartment;
    use common\models\House;
    use common\models\Realty;
    use Yii;
    use yii\base\Exception;
    use yii\base\Object;
    use yii\helpers\FileHelper;

    class RealtyModel extends Object{
        public $baseModel;
        public $entityModel;
        public $errors = [];

        /**
         * RealtyModel constructor.
         *
         * @param Realty $realty
         * @param House|Apartment $entity
         */
        public function __construct($realty, $entity){
            $this->baseModel = $realty;
            $this->entityModel = $entity;

            parent::__construct();
        }

        public function load($data){
            if($this->baseModel->load($data) && $this->entityModel->load($data)){
                return true;
            }

            return false;
        }

        public function create(){
            if(!$this->validate()){
                return false;
            }
            $dir = '';
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$this->baseModel->save()){
                    throw new \Exception($this->baseModel->getErrors());
                }
                $this->addModelToAction();

                $dir = $this->baseModel->id;
                $uploadedPhoto = Yii::$app->session->get('uploadedPhoto');
                $photos = [];
                if(is_array($uploadedPhoto)){
                    foreach($uploadedPhoto as $photo){
                        if(is_file(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$photo['path'])){
                            $img = new RealtyPhoto($photo['path']);
                            $photos[] = $img->savePhoto($dir);
                        }
                    }
                }

                $this->entityModel->realty_id = $this->baseModel->id;
                $this->entityModel->photos = json_encode($photos);
                if(!$this->entityModel->save()){
                    throw new \Exception($this->entityModel->getErrors());
                }
                $transaction->commit();
            }catch(Exception $e){
                if(is_dir(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.$dir)){
                    FileHelper::removeDirectory(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.$dir);
                }
                $transaction->rollBack();
                throw $e;
            }

            return true;
        }

        public function update(){
            if(!$this->validate()){
                return false;
            }
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$this->baseModel->save()){
                    throw new \Exception($this->baseModel->getErrors());
                }

                $this->addModelToAction();

                $uploadedPhoto = Yii::$app->session->get('uploadedPhoto');
                if(!empty($this->entityModel->photos)){
                    $photos = json_decode($this->entityModel->photos);
                }else{
                    $photos = [];
                }
                if(is_array($uploadedPhoto)){
                    foreach($uploadedPhoto as $photo){
                        if(is_file(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.$photo['path'])){
                            $img = new RealtyPhoto($photo['path']);
                            $photos[] = $img->savePhoto($this->baseModel->id);
                        }
                    }
                }
                $this->entityModel->photos = json_encode($photos);
                if(!$this->entityModel->save()){
                    throw new \Exception($this->entityModel->getErrors());
                }

                $transaction->commit();
            }catch(Exception $e){
                $transaction->rollBack();
                throw $e;
            }

            return true;
        }

        public function delete(){
            FileHelper::removeDirectory(Yii::getAlias('@storage').DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.$this->baseModel->id);
            $this->entityModel->delete();
            $this->baseModel->delete();
        }

        protected function validate(){
            if(!$this->baseModel->validate()){
                $this->errors['baseModel'] = $this->baseModel->getErrors();
            }

            if(!$this->entityModel->validate()){
                $this->errors['entityModel'] = $this->entityModel->getErrors();
            }

            if(empty($this->errors)){
                return true;
            }else{
                return false;
            }
        }

        private function addModelToAction(){
            $actions = Yii::$app->request->post('actions');
            foreach($actions as $action){
                if(!$this->baseModel->getActionModels()
                                    ->where(['action_id' => $action])
                                    ->exists()
                ){
                    $actionModel = new ActionModel([
                                                       'model_id' => $this->baseModel->id,
                                                       'action_id' => $action
                                                   ]);
                    if(!$actionModel->save()){
                        throw new \Exception($actionModel->getErrors());
                    }
                }
            }
            $removedAction = $this->baseModel->getActionModels()->where(['not in','action_id',$actions])->all();
            foreach($removedAction as $item){
                $item->delete();
            }
        }


    }