<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Page;
use Yii;
use app\models\ContactForm;
use app\models\LoginForm;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
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

        return $this->render('index', [
            'model' => $page,
        ]);
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
        $model = new ContactForm();

        $contact = $model->load($this->request->post()) && $model->contact(
            $this->mailer,
            Yii::$app->params['adminEmail'],
            Yii::$app->params['senderEmail'],
            Yii::$app->params['senderName'],
        );

        if ($contact) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for contacting us. We will respond to you as soon as possible.',
            );

            return $this->refresh();
        }

        return $this->render('contact', ['model' => $model]);
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
