<?php
    namespace frontend\controllers;

    use common\models\Callback;
    use common\models\Feedback;
    use common\models\Realty;
    use common\models\Service;
    use common\models\VideoReview;
    use frontend\models\Search;
    use frontend\models\ServiceCallModel;
    use Yii;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\web\NotFoundHttpException;

    /**
     * Site controller
     */
    class SiteController extends Controller{
        public function behaviors(){
            return [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'feedback' => ['post'],
                        'service-call' => ['post'],
                    ],
                ],
            ];
        }

        public function actions(){
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ]
            ];
        }

        public function actionIndex(){
            return $this->render('landing', [
                'feedback' => new Feedback(),
                'videoReview' => VideoReview::getDb()
                                            ->cache(function(){
                                                return VideoReview::find()
                                                                  ->limit(1)
                                                                  ->one();
                                            })
            ]);
        }

        public function actionCatalog(){
            $searchModel = new Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('catalog', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        public function actionRealty($id){
            $realty = Realty::findOne(['id' => $id]);
            if($realty->status == 'inactive' or $realty->status == 'sale'){
                throw new NotFoundHttpException('Page not found');
            }

            return $this->render('realty', [
                'realty' => $realty,
                'requestEmail' => new Feedback(['subject' => $realty->id]),
                'requestCall' => new Callback(['subject' => $realty->id])
            ]);
        }

        public function actionVideoReview(){
            return $this->render('video-review', [
                'models' => VideoReview::getDb()
                                       ->cache(function(){
                                           return VideoReview:: find()
                                                             ->all();
                                       })
            ]);
        }

        public function actionFeedback($m){
            $modelName = 'common\models\\'.ucfirst($m);
            /**
             * @var Callback|Feedback $model
             */
            $model = new $modelName();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->sendMail();
                $model->save();

                return $this->renderAjax('_successFeedback', ['message' => $model->successMessage]);
            }

            return $this->renderAjax('_form'.ucfirst($m), ['model' => $model]);
        }

        public function actionServiceCall(){
            $model = new ServiceCallModel();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->sendMail();

                return true;
            }

            return false;
        }

        public function actionSendMail(){
            $model = new Feedback();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->sendMail();
                $model->save();

                return json_encode([
                                       'message' => $model->successMessage
                                   ]);
            }

            return json_encode([
                                   'message' => $model->errors
                               ]);
        }

        public function actionService($id = null){
            if(is_null($id)){
                return $this->render('service', [
                    'model' => Service::getDb()
                                      ->cache(function(){
                                          return Service::find()
                                                        ->all();
                                      })
                ]);
            }

            return $this->render('service_item', ['model' => Service::findOne($id)]);
        }

        public function actionTechnology(){
            return $this->render('technology');
        }
    }
