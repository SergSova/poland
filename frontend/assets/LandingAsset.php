<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class LandingAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $js = [
            'js/myscrollbar.js', 'https://www.youtube.com/iframe_api', 'js/player.js', 'js/landing.js'
        ];

        public $depends = [
            'frontend\assets\AppAsset',
            'frontend\assets\MapAsset',
            'frontend\assets\IonRangeAsset'
        ];
    }