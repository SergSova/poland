<?php

    namespace backend\controllers;

    use common\models\Service;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\filters\VerbFilter;
    use yii\web\Controller;

    class ServiceController extends Controller{
        public function behaviors(){
            return [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }

        public function actionIndex(){
            $dataProvider = new ActiveDataProvider([
                                                       'query' => Service::find()
                                                   ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider
            ]);
        }

        public function actionCreate(){
            $model = new Service();

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }

            return $this->render('create', ['model' => $model]);
        }

        public function actionUpdate($id){
            $model = Service::findOne($id);

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }

            return $this->render('update', ['model' => $model]);
        }

        public function actionDelete($id){
            Service::findOne($id)
                   ->delete();

            return $this->redirect(['index']);
        }
    }