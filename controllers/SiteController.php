<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

/**
     * Displays homepage.
     *
     * @param $lang
     * @return string|Response
     */
    public function actionIndex($lang = 'ru')
    {
        $allowed = ['ru', 'en', 'kg'];

        if (!in_array($lang, $allowed)) {
            $lang = 'ru';
        }

        $langMap = [
            'ru' => 'ru-RU',
            'en' => 'en-US',
            'kg' => 'ky-KG',
        ];

        $appNameMap = [
            'ru' => 'Школа Нового Мышления в Центральной Азии',
            'en' => 'New Thinking School of Central Asia',
            'kg' => 'Борбордук Азиядагы Жаңы Ой Жүгүртүү Мектеби',
        ];

        Yii::$app->language = $langMap[$lang];
        Yii::$app->params['appName'] = $appNameMap[$lang];
        Yii::$app->params['lang'] = $lang;

        return $this->render('index', [
            'lang' => $lang
        ]);
    }
}
