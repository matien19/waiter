<?php

namespace app\controllers;

use app\models\PesananModel;
use app\models\PesananSearchModel;
use app\models\TagihanModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class BerandaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index', 'dashboard', 'koki', 'kasir'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'dashboard', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Hanya admin yang bisa akses index & dashboard
                            return in_array(Yii::$app->user->identity->role, ['admin']);
                        },
                    ],
                    [
                        'actions' => ['koki', 'confirm-terkirim'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Hanya koki yang bisa akses koki dan confirm-terkirim
                            return Yii::$app->user->identity->role === 'koki';
                        },
                    ],
                    [
                        'actions' => ['kasir'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Hanya kasir yang bisa akses kasir
                            return Yii::$app->user->identity->role === 'kasir';
                        },
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('/beranda/index');
    }
    public function actionKoki()
    {
        $searchModel = new PesananSearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $today = date('Y-m-d');
        $dataProvider->query->andWhere(['DATE(waktu)' => $today]);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);

        $role = Yii::$app->user->identity->role;

        return $this->render('/beranda/koki', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $role,
        ]);
    }
    public function actionKasir()
    {
        $searchModel = new PesananSearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $today = date('Y-m-d');
        $dataProvider->query->andWhere(['DATE(waktu)' => $today]);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);

        $role = Yii::$app->user->identity->role;

        return $this->render('/beranda/kasir', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $role,
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

        return $this->redirect(['koki']);
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
       
        return $this->redirect(['kasir']);
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
        return $this->redirect(['kasir']);
    }

    /**
     * Finds the PesananModel based on its primary key value.
     * @param integer $id
     * @return PesananModel the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PesananModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Pesanan tidak ditemukan.');
    }
}
