<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class RealtyAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $js = [
           'js/realty.js'
        ];

        public $depends = [
            'frontend\assets\AppAsset',
            'frontend\assets\MapAsset',
            'frontend\assets\SlickAsset'
        ];
    }