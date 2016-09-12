<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class AppAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [
            'css/style.css',
        ];
        public $js = [
            'js/fullHeight.js'
        ];

        public $depends = [
            'yii\web\YiiAsset',
            'macgyer\yii2materializecss\assets\MaterializeAsset',
            'macgyer\yii2materializecss\assets\MaterializePluginAsset',
        ];
    }