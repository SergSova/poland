<?php

    namespace console\controllers;

    use yii\console\Controller;

    class RbacController extends Controller{

        public function actionInit(){
            $authManager = \Yii::$app->authManager;

            // Create roles
            $admin = $authManager->createRole('admin');

            $author = $authManager->createPermission('author');

            // Add permissions in Yii::$app->authManager
            $authManager->add($author);

            // Add roles in Yii::$app->authManager
            $authManager->add($admin);

            // Add permission-per-role in Yii::$app->authManager

            // Admin
            $authManager->addChild($admin, $author);
        }
    }