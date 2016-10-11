<?php

    namespace backend\controllers;

    use common\models\Action;
    use common\models\ActionModel;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\web\Controller;

    class ActionController extends Controller{

        public function actionIndex(){
            $query = Action::find();
            $dataProvider = new ActiveDataProvider(['query' => $query]);

            return $this->render('index', ['dataProvider' => $dataProvider]);
        }

        public function actionCreate(){
            $model = new Action();
            $model->status = 'inactive';

            if($model->load(Yii::$app->request->post())&& $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }

            return $this->render('create_action', ['model' => $model]);
        }

        public function actionUpdate($id){
            $model = Action::findOne($id);

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }

            return $this->render('update_action', ['model' => $model]);
        }


        public function actionView($id){
            $action = Action::findOne($id);
            $query = $action->getActionModels();
            $dataProvider = new ActiveDataProvider(['query' => $query]);

            return $this->render('action_model', [
                'dataProvider' => $dataProvider,
                'action' => $action
            ]);
        }

        public function actionDelete($id){
            $model = Action::findOne($id);
            if(count($model->models) > 0){
                return $this->redirect([
                                           'view',
                                           'id' => $id
                                       ]);
            }
            $model->delete();

            return $this->redirect(['index']);
        }

        public function actionRemoveModel($action_model_id){
            $model = ActionModel::findOne($action_model_id);
            $id = $model->action_id;
            $model->delete();

            return $this->redirect([
                                       'view',
                                       'id' => $id
                                   ]);
        }


    }