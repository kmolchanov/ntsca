<?php

namespace app\modules\admin\controllers;

use app\models\Gallery;
use app\models\GalleryItem;
use app\models\GalleryItemSearch;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * GalleryItemController implements the CRUD actions for GalleryItem model.
 */
class GalleryItemController extends BaseController
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
     * @return array
     */
    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => GalleryItem::className(),
            ],
        ];
    }

    /**
     * Lists all GalleryItem models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($gallery_id)
    {
        $gallery = $this->findGallery($gallery_id);

        $searchModel = new GalleryItemSearch();
        $searchModel->gallery_id = $gallery->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['position' => SORT_ASC];

        return $this->render('index', [
            'gallery' => $gallery,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GalleryItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($gallery_id)
    {
        $gallery = $this->findGallery($gallery_id);

        $model = new GalleryItem();
        $model->gallery_id = $gallery->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->images = UploadedFile::getInstances($model, 'images');

            if ($model->save()) {
                if ($uploadedImages = UploadedFile::getInstances($model, 'images')) {
                    foreach ($uploadedImages as $uploadedImage) {
                        $path = Yii::getAlias('@webroot/uploads/images/store/') . time() . '.' . $uploadedImage->extension;
                        $uploadedImage->saveAs($path);
                        $model->attachImage($path);
                        @unlink($path);
                    }
                }

                return $this->redirect(['index', 'gallery_id' => $model->gallery_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GalleryItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $gallery_id = $model->gallery_id;

        $model->delete();

        return $this->redirect(['index', 'gallery_id' => $gallery_id]);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findGallery($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }

    /**
     * Finds the GalleryItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GalleryItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GalleryItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
