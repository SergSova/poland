<?php

    namespace backend\controllers;

    use backend\components\RealtyModel;
    use backend\components\RealtyPhoto;
    use backend\models\RealtySearch;
    use backend\models\UploadModel;
    use common\models\RealtyType;
    use Yii;
    use common\models\Realty;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\Response;
    use yii\web\UploadedFile;

    class RealtyController extends Controller{

        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => [
                                'index',
                                'create',
                                'update',
                                'delete',
                                'upload-photo',
                                'delete-photo',
                                'view'
                            ],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'upload-photo' => ['POST'],
                        'delete-photo' => ['POST']
                    ],
                ],
            ];
        }

        public function actionIndex(){
            $searchModel = new RealtySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        public function actionView($id){
            $realty = $this->findRealty($id);
            $realtyType = $realty->realtyType->realty_table;
            $model = new RealtyModel($realty, $realty->$realtyType);

            return $this->render('view', [
                'model' => $model,
                'realtyType' => $realtyType
            ]);
        }

        public function actionCreate($realtyType){
            $realtyTypeClass = 'common\models\\'.ucfirst($realtyType);
            $realtyTypeModel = RealtyType::findOne(['realty_table'=> $realtyType]);
            if(is_null($realtyTypeModel)){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            $model = new RealtyModel(new Realty(), new $realtyTypeClass());

            if($model->load(Yii::$app->request->post()) && $model->create()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->baseModel->id
                                       ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'realtyType' => $realtyType
                ]);
            }
        }

        public function actionUpdate($id){
            $realty = $this->findRealty($id);
            $realtyType = $realty->realtyType->realty_table;
            $model = new RealtyModel($realty, $realty->$realtyType);

            if($model->load(Yii::$app->request->post()) && $model->update()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->baseModel->id
                                       ]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                    'realtyType' => $realtyType
                ]);
            }

        }

        public function actionDelete($id){
            $realty = $this->findRealty($id);
            $realtyType = $realty->realtyType->realty_table;
            $model = new RealtyModel($realty, $realty->$realtyType);

            $model->delete();

            return $this->redirect(['index']);
        }

        public function actionUploadPhoto(){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new UploadModel();

            $model->photo = UploadedFile::getInstanceByName('picture');
            if($model->upload()){
                $result = $model->result;
            }else{
                $result = [
                    'error' => ['uploadError' => $model->getErrors('photo')[0]]
                ];
            }

            return $result;
        }

        public function actionDeletePhoto(){
            $path = Yii::$app->request->post('path');
            if($path){
                RealtyPhoto::deletePhoto($path);
                return true;
            }

            return false;

        }

        protected function findRealty($id){
            if(($model = Realty::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }
