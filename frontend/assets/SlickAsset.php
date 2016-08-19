<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class SlickAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $css = ['css/slick.css', 'css/slick-theme.css', 'css/slick-style.css'];
        public $js = ['js/slick.js'];

        public $depends = [
            'yii\web\JqueryAsset'
        ];
    }