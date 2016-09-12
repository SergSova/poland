<?php
    namespace frontend\assets;

    use yii\web\AssetBundle;

    class CatalogAsset extends AssetBundle{
        public $basePath = '@webroot';
        public $baseUrl = '@web';

        public $js = ['js/catalog.js'];

        public $depends = [
            'frontend\assets\AppAsset',
            'frontend\assets\IonRangeAsset'
        ];
    }