<?php

namespace app\controllers;

use app\models\MejaModel;
use app\models\MejaSearchModel;
use Endroid\QrCode\Builder\Builder;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MejaController implements the CRUD actions for MejaModel model.
 */
class MejaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MejaModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MejaSearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MejaModel model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MejaModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MejaModel();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MejaModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $totalMeja = (int)$request->post('total_meja', 0);

            if ($totalMeja > 0) {
                // Hapus semua data lama
                MejaModel::deleteAll();

                // Generate meja baru dari 1 sampai total
                for ($i = 1; $i <= $totalMeja; $i++) {
                    $meja = new MejaModel();
                    $meja->no_meja = $i;
                    $meja->save(false);
                }

                Yii::$app->session->setFlash('success', "Total meja berhasil diupdate menjadi {$totalMeja}.");
            } else {
                Yii::$app->session->setFlash('error', "Total meja tidak valid.");
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing MejaModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MejaModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MejaModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MejaModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}