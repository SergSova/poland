<?php
    Yii::setAlias('@webroot', __DIR__.'/../../www');
    Yii::setAlias('@web', '/');
    return [
        'jsCompressor' => 'java -jar compiler.jar --js {from} --js_output_file {to} --jscomp_off uselessCode --warning_level QUIET',
        'cssCompressor' => 'java -jar yuicompressor.jar --type css {from} -o {to}',
        'bundles' => [
            \yii\widgets\PjaxAsset::className(),
            \yii\validators\ValidationAsset::className(),
            \yii\widgets\MaskedInputAsset::className(),
            \frontend\assets\AppAsset::className(),
            \frontend\assets\MapAsset::className(),
            \frontend\assets\GoogleMapAsset::className(),
            \frontend\assets\IonRangeAsset::className(),
            \frontend\widgets\SliderWidget\assets\SliderWidgetAsset::className(),
            \frontend\assets\YoutubeAsset::className(),
            \frontend\assets\LandingAsset::className(),
            \frontend\assets\CatalogAsset::className(),
            \frontend\assets\RealtyAsset::className(),
            \frontend\assets\SlickAsset::className(),
            \yii\widgets\ActiveFormAsset::className()

        ],
        'targets' => [

            'basic' => [
                'class' => \yii\web\AssetBundle::className(),
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/basic-{hash}.js',
                'css' => 'css/basic-{hash}.css',
                'depends' => [
                    \yii\web\JqueryAsset::className(),
                    \yii\web\YiiAsset::className(),
                    \yii\widgets\PjaxAsset::className(),
                    \yii\validators\ValidationAsset::className(),
                    \yii\widgets\MaskedInputAsset::className(),
                    \macgyer\yii2materializecss\assets\MaterializeAsset::className(),
                    \macgyer\yii2materializecss\assets\MaterializePluginAsset::className(),
                    \macgyer\yii2materializecss\assets\MaterializeFontAsset::className(),
                    \frontend\assets\AppAsset::className(),
                ],
            ],
            'map' => [
                'class' => 'yii\web\AssetBundle',
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/map-{hash}.js',
                'css' => 'css/map-{hash}.css',
                'depends' => [
                    \frontend\assets\GoogleMapAsset::className(),
                    \frontend\assets\MapAsset::className(),
                ],
            ],
            'form' => [
                'class' => 'yii\web\AssetBundle',
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/form-{hash}.js',
                'css' => 'css/form-{hash}.css',
                'depends' => [
                    \yii\widgets\ActiveFormAsset::className()
                ],
            ],
            'ionRange' => [
                'class' => 'yii\web\AssetBundle',
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/ionRange-{hash}.js',
                'css' => 'css/ionRange-{hash}.css',
                'depends' => [
                    \frontend\assets\IonRangeAsset::className()
                ],
            ],
            'slider' => [
                'class' => 'yii\web\AssetBundle',
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/slider-{hash}.js',
                'css' => 'css/slider-{hash}.css',
                'depends' => [
                    \frontend\widgets\SliderWidget\assets\SliderWidgetAsset::className(),
                ],
            ],
            'landing' => [
                'class' => 'yii\web\AssetBundle',
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/landing-{hash}.js',
                'css' => 'css/landing-{hash}.css',
                'depends' => [
                    \frontend\assets\YoutubeAsset::className(),
                    \frontend\assets\LandingAsset::className(),
                ],
            ],
            'catalog' => [
                'class' => 'yii\web\AssetBundle',
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/catalog-{hash}.js',
                'css' => 'css/catalog-{hash}.css',
                'depends' => [
                    \frontend\assets\CatalogAsset::className(),
                ]
            ],
            'realty' => [
                'class' => 'yii\web\AssetBundle',
                'basePath' => '@webroot/assets',
                'baseUrl' => '@web/assets',
                'js' => 'js/realty-{hash}.js',
                'css' => 'css/realty-{hash}.css',
                'depends' => [
                    \frontend\assets\SlickAsset::className(),
                    \frontend\assets\RealtyAsset::className(),
                ]

            ]
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
        ],
    ];