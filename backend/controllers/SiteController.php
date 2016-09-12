<?php
    namespace backend\controllers;

    use backend\models\EmailChangeRequestForm;
    use backend\models\LoginForm;
    use backend\models\PasswordResetRequestForm;
    use backend\models\ResetPasswordForm;
    use common\models\Callback;
    use common\models\Feedback;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\data\ActiveDataProvider;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;

    /**
     * Site controller
     */
    class SiteController extends Controller{

        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => [
                                'login',
                                'error',
                                'request-password-reset',
                                'reset-password',
                            ],
                            'allow'   => true,
                        ],
                        [
                            'actions' => [
                                'logout',
                                'index',
                                'profile',
                                'reset-password-current',
                                'change-email-token',
                                'request-change-email'
                            ],
                            'allow'   => true,
                            'roles'   => ['@'],
                        ],
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ];
        }

        public function actions(){
            return [
                'error'   => [
                    'class' => 'yii\web\ErrorAction',
                ],
                'captcha' => [
                    'class'           => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
            ];
        }

        public function actionIndex(){
            $callbackProvider = new ActiveDataProvider([
                                                        'query' => Callback::find(),
                                                    ]);
            $feedbackProvider = new ActiveDataProvider([
                                                        'query' => Feedback::find(),
                                                    ]);

            return $this->render('index', ['callbackProvider' => $callbackProvider, 'feedbackProvider' => $feedbackProvider]);
        }

        public function actionLogin(){
            if(!Yii::$app->user->isGuest){
                return $this->goHome();
            }

            $model = new LoginForm();
            if($model->load(Yii::$app->request->post()) && $model->login()){
                return $this->goBack();
            }else{
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }

        public function actionLogout(){
            Yii::$app->user->logout();

            return $this->goHome();
        }

        public function actionResetPasswordCurrent(){
            $model = new PasswordResetRequestForm();
            $model->email = Yii::$app->user->identity->email;
            if($model->sendEmail()){
                Yii::$app->session->setFlash('success', 'Проверьте вашу почту для дальнейших инструкций.');

                return $this->goHome();
            }
        }

        public function actionRequestPasswordReset(){
            $model = new PasswordResetRequestForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->sendEmail()){
                    Yii::$app->session->setFlash('success', 'Проверьте вашу почту для дальнейших инструкций.');

                    return $this->goHome();
                }else{
                    Yii::$app->session->setFlash('error', 'К сожалению мы не смогли восстановить пароль для электронной почты.');
                }
            }

            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }

        public function actionResetPassword($token){
            try{
                $model = new ResetPasswordForm($token);
            }catch(InvalidParamException $e){
                throw new BadRequestHttpException($e->getMessage());
            }

            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()){
                Yii::$app->session->setFlash('success', 'Новый пароль был сохранен.');

                return $this->goHome();
            }

            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }

        public function actionProfile(){
            return $this->render('profile', [
                'model' => Yii::$app->user->identity,
            ]);
        }

        public function actionRequestChangeEmail(){
            $model = new EmailChangeRequestForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->sendEmail()){
                    Yii::$app->session->setFlash('success', 'Проверьте вашу почту для дальнейших инструкций.');

                    return $this->goHome();
                }
            }

            return $this->render('changeEmail', ['model' => $model]);
        }

        public function actionChangeEmailToken($token, $email){
            try{
                EmailChangeRequestForm::changeEmail($token, $email);
            }catch(InvalidParamException $e){
                throw new BadRequestHttpException($e->getMessage());
            }

            Yii::$app->session->setFlash('success', 'Новая почта была сохранена.');

            return $this->goHome();
        }
    }
