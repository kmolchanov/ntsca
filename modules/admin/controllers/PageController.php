<?php

namespace app\modules\admin\controllers;

use app\models\Page;
use Exception;
use klisl\nestable\NodeMoveAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'nodeMove' => [
                'class' => NodeMoveAction::className(),
                'modelName' => Page::className(),
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => Url::to('@web/uploads/pages/images', true), // Directory URL address, where files are stored.
                'path' => '@webroot/uploads/pages/images', // Or absolute path to directory where files are stored.
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => Url::to('@web/uploads/pages/files', true), // Directory URL address, where files are stored.
                'path' => '@webroot/uploads/pages/files', // Or absolute path to directory where files are stored.
                'uploadOnlyImage' => false, // For any kind of files uploading.
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $rootPage = Page::find()->roots()->one();

        if ($rootPage === null) {
            $rootPage = new Page();
            $rootPage->slug = 'root-service-page-non-editable';
            $rootPage->title_ru = 'Root';
            $rootPage->title_en = 'Root';
            $rootPage->title_ky = 'Root';
            $rootPage->menu_title_ru = 'Root';
            $rootPage->menu_title_en = 'Root';
            $rootPage->menu_title_ky = 'Root';

            if (!$rootPage->makeRoot()) {
                throw new Exception('Базовая страница отсутствует.');
            }
        }

        $query = Page::find()->roots()->sortedByTree();

        return $this->render('index', [
            'query' => $query,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $rootPage = Page::find()->roots()->one();

        if ($rootPage === null) {
            $rootPage = new Page();
            $rootPage->slug = 'root-service-page-non-editable';
            $rootPage->title_ru = 'Root';
            $rootPage->title_en = 'Root';
            $rootPage->title_ky = 'Root';
            $rootPage->menu_title_ru = 'Root';
            $rootPage->menu_title_en = 'Root';
            $rootPage->menu_title_ky = 'Root';

            if (!$rootPage->makeRoot()) {
                throw new Exception('Базовая страница отсутствует.');
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->parent_id == null) {
                $model->appendTo($rootPage);
            } else {
                $parent = $this->findModel($model->parent_id);
                $model->appendTo($parent);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rootPage = Page::find()->roots()->one();

        if ($rootPage === null) {
            $rootPage = new Page();
            $rootPage->slug = 'root-service-page-non-editable';
            $rootPage->title_ru = 'Root';
            $rootPage->title_en = 'Root';
            $rootPage->title_ky = 'Root';
            $rootPage->menu_title_ru = 'Root';
            $rootPage->menu_title_en = 'Root';
            $rootPage->menu_title_ky = 'Root';

            if (!$rootPage->makeRoot()) {
                throw new Exception('Базовая страница отсутствует.');
            }
        }

        $parent = $model->parents(1)->one();
        $model->parent_id = $parent !== null ? $parent->id : null;
        $currentParentId = $parent !== null ? $parent->id : null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (empty($model->parent_id)) {
                if ($currentParentId == $rootPage->id) {
                    $model->save();
                } else {
                    $model->appendTo($rootPage);
                }
            } else {
                if ($model->parent_id != $currentParentId) {
                    $newParent = $this->findModel($model->parent_id);
                    $model->appendTo($newParent);
                } else {
                    $model->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithChildren();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
