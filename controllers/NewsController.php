<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class NewsController extends Controller
{
    public function beforeAction($action)
    {
        $lang = Yii::$app->request->get('lang');

        $languages = Yii::$app->params['languages'];
        $defaultLanguage = Yii::$app->params['defaultLanguage'];

        if (!$lang || !isset($languages[$lang])) {
            $lang = Yii::$app->request->cookies->getValue('language', $defaultLanguage);
        }

        if (!isset($languages[$lang])) {
            $lang = $defaultLanguage;
        }

        Yii::$app->language = $languages[$lang]['locale'];
        Yii::$app->params['lang'] = $lang;
        Yii::$app->params['appName'] = $languages[$lang]['appName'];

        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'language',
            'value' => $lang,
            'expire' => time() + 3600 * 24 * 365,
        ]));

        Yii::$app->i18n->translations['yii/bootstrap5'] = [
            'class' => \yii\i18n\PhpMessageSource::class,
            'basePath' => '@app/messages',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'yii/bootstrap5' => 'bootstrap5.php',
            ],
        ];

        return parent::beforeAction($action);
    }

    public function actionIndex($lang = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()
                ->active()
                ->sorted(),
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($lang = null, $slug = null)
    {
        $model = News::find()
            ->active()
            ->andWhere(['slug' => $slug])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException('Новость не найдена.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

}
