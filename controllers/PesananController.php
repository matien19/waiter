<?php

namespace app\controllers;

use app\models\PesananModel;
use app\models\PesananSearchModel;
use app\models\TagihanModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PesananController implements the CRUD actions for PesananModel model.
 */
class PesananController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete', 'nota'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PesananModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PesananSearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);

        $role = Yii::$app->user->identity->role;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $role,
        ]);
    }

    /**
     * Displays a single PesananModel model.
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
     * Creates a new PesananModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PesananModel();

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
     * Updates an existing PesananModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PesananModel model.
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
     * Finds the PesananModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PesananModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PesananModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionNota($id)
    {
        $pesanan = PesananModel::findOne($id);
        $pesananDetail = $pesanan ? $pesanan->getPesananDetails()->all() : [];

        return $this->renderPartial('_nota', [
            'pesanan' => $pesanan,
            'pesananDetail' => $pesananDetail,
        ]);
    }


    public  function actionConfirmTerkirim($id)
    {
        $model = $this->findModel($id);
        if ($model->status_pesanan === PesananModel::STATUS_PESANAN_TERPESAN) {
            $model->status_pesanan = PesananModel::STATUS_PESANAN_TERKIRIM;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Status pesanan berhasil diubah menjadi terkirim.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal mengubah status pesanan.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Status pesanan tidak valid untuk diubah menjadi terkirim.');
        }

        return $this->redirect(['index']);
    }

    public  function actionVerifikasiTransfer($id)
    {
        $model = TagihanModel::findOne($id);
        if ($model->status === TagihanModel::STATUS_PENDING) {
            $total = $model->total;
            $model->status = TagihanModel::STATUS_TERBAYAR;
            $model->bayar = $total;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Pembayaran transfer berhasil diverifikasi.');
            } else {
                Yii::$app->session->setFlash('error', 'Gagal memverifikasi pembayaran transfer.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Status pesanan tidak valid untuk verifikasi pembayaran transfer.');
        }
       
        return $this->redirect(['index']);
    }

    public function actionVerifikasiCash()
    {
        $id = Yii::$app->request->post('tagihan_id');
        $model = TagihanModel::findOne($id);

        if ($model && $model->status === TagihanModel::STATUS_PENDING) {
            $nominal = Yii::$app->request->post('nominal');
            $total = $model->total;
            $kembalian = $nominal - $total;

            if ($nominal >= $total) {
                $model->status = TagihanModel::STATUS_TERBAYAR;
                $model->bayar = $nominal;
                $model->kembalian = $kembalian;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Pembayaran cash berhasil diverifikasi.');
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal memverifikasi pembayaran cash.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Nominal yang dibayarkan kurang dari total tagihan.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Tagihan tidak ditemukan atau sudah terverifikasi.');
        }
        return $this->redirect(['index']);
    }
}
