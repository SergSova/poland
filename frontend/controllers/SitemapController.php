<?php

    namespace frontend\controllers;

    use common\models\Realty;
    use common\models\Service;
    use Yii;
    use yii\helpers\Url;
    use yii\web\Controller;
    use yii\web\Response;

    class SitemapController extends Controller{
        public function actionIndex(){
            if(!$xml_sitemap = Yii::$app->cache->get('sitemap')){
                $urls = [];
                /**
                 * SiteController Link
                 */
                $urls[] = ['loc'=>Url::to(['site/index'])];
                $urls[] = ['loc'=>Url::to(['site/catalog'])];
                $urls[] = ['loc'=>Url::to(['site/video-review'])];
                $urls[] = ['loc'=>Url::to(['site/technology'])];
                $urls[] = ['loc'=>Url::to(['site/service'])];

                $realty = Realty::getAll();
                foreach($realty as $item){
                    $urls[] = [
                        'loc'        => Url::to(['site/realty', 'id' => $item->id]),
                        'lastmod'    => $item->update_at,
                        'changefreq' => 'weekly',
                    ];
                }

                $service = Service::find()->all();
                foreach($service as $item){
                    $urls[] = [
                        'loc'        => Url::to(['site/service', 'id' => $item->id]),
                        'lastmod'    => $item->update_at,
                        'changefreq' => 'monthly',
                    ];
                }

                $xml_sitemap = $this->renderPartial('index', ['host' => Yii::$app->request->hostInfo, 'urls' => $urls]);
//                Yii::$app->cache->set('sitemap', $xml_sitemap, 3600*12);
            }
            Yii::$app->response->format = Response::FORMAT_XML;

            return $xml_sitemap;
        }
    }