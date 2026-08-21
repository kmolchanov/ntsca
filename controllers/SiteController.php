<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\News;
use app\models\Page;
use Yii;
use app\models\LoginForm;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Url;

class SiteController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly Security $security,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'transparent' => true,
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
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

        Yii::$app->response->cookies->add(new \yii\web\Cookie([
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

    /**
     * Displays page.
     *
     * @param $lang
     * @param $slug
     * @return string
     */
    public function actionIndex($lang = null, $slug = null)
    {
        $query = Page::find()->where(['is_active' => true]);

        if ($slug === null) {
            $page = $query->andWhere(['is_main' => true])->one();
        } else {
            $page = $query->andWhere(['slug' => $slug])->one();
        }

        if (!$page) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $latestNews = (int)$page->is_main === Page::IS_YES
            ? News::find()->active()->sorted()->limit(3)->all()
            : [];

        return $this->render('index', [
            'model' => $page,
            'latestNews' => $latestNews,
        ]);
    }

    public function actionLanguageRedirect(): Response
    {
        $languages = Yii::$app->params['languages'] ?? [];
        $defaultLanguage = Yii::$app->params['defaultLanguage'] ?? 'ru';
        $lang = Yii::$app->request->cookies->getValue('language', $defaultLanguage);

        if (!isset($languages[$lang])) {
            $lang = $defaultLanguage;
        }

        return $this->redirect(['/site/index', 'lang' => $lang], 301);
    }

    public function actionSitemap(): Response
    {
        $languages = array_keys(Yii::$app->params['languages'] ?? []);
        $urls = [];

        foreach ($languages as $lang) {
            $urls[] = [
                'loc' => Url::to(['/site/index', 'lang' => $lang], true),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ];

            $urls[] = [
                'loc' => Url::to(['/news/index', 'lang' => $lang], true),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];

            $urls[] = [
                'loc' => Url::to(['/site/contact', 'lang' => $lang], true),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        $pages = Page::find()->active()->sortedByTree()->all();
        foreach ($pages as $page) {
            foreach ($languages as $lang) {
                $urls[] = [
                    'loc' => Url::to(['/site/index', 'lang' => $lang, 'slug' => $page->is_main ? null : $page->slug], true),
                    'lastmod' => $page->updated_at ? date(DATE_W3C, (int)$page->updated_at) : null,
                    'changefreq' => $page->is_main ? 'weekly' : 'monthly',
                    'priority' => $page->is_main ? '1.0' : '0.8',
                ];
            }
        }

        $news = News::find()->active()->sorted()->all();
        foreach ($news as $model) {
            foreach ($languages as $lang) {
                $urls[] = [
                    'loc' => Url::to(['/news/view', 'lang' => $lang, 'slug' => $model->slug], true),
                    'lastmod' => $model->updated_at ? date(DATE_W3C, (int)$model->updated_at) : null,
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ];
            }
        }

        $uniqueUrls = [];
        foreach ($urls as $url) {
            $uniqueUrls[$url['loc']] = $url;
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/xml; charset=UTF-8');
        Yii::$app->response->content = $this->renderPartial('sitemap', [
            'urls' => array_values($uniqueUrls),
        ]);

        return Yii::$app->response;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm($this->security);

        if ($model->load($this->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact(): Response|string
    {
        return $this->render('contact');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }
}
