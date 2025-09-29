<?php

namespace app\controllers;

use app\models\TagihanModel;
use app\models\TagihanSearchModel;
use Mpdf\Mpdf;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LaporanController implements the CRUD actions for LaporanModel model.
 */
class LaporanController extends Controller
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
     * Lists all TagihanModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TagihanSearchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = TagihanModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    
    public function actionPdf($date_start = null, $date_end = null)
    {
        $searchModel = new TagihanSearchModel();
        $dataProvider = $searchModel->search([
            'TagihanSearchModel' => [
                'date_start' => $date_start,
                'date_end' => $date_end,
            ]
        ]);
        $dataProvider->pagination = false;

        $query = clone $dataProvider->query;
        $totalSemua = (int) $query->sum('total');

        $content = $this->renderPartial('_laporan_pdf', [
            'dataProvider' => $dataProvider,
            'totalSemua' => $totalSemua,
            'searchModel' => $searchModel,
        ]);

        $pdf = new Mpdf();
        $pdf->WriteHTML($content);
        return $pdf->Output('Laporan-Pemasukan.pdf', 'I');
    }
}
