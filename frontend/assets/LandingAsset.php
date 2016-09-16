<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class LandingAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl  = '@web';

        public $js = [
            'js/myscrollbar.js',
            'js/player.js',
            'js/landing.js'
        ];

        public $depends = [
            'frontend\assets\AppAsset',
            'yii\web\JqueryAsset',
            'frontend\assets\MapAsset',
            'frontend\assets\IonRangeAsset',
            'frontend\assets\YoutubeAsset',
        ];
    }