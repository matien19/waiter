<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

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
                        'actions' => ['koki'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Hanya koki yang bisa akses koki
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
        return $this->render('/beranda/koki');
    }
    public function actionKasir()
    {
        return $this->render('/beranda/kasir');
    }
    
}
