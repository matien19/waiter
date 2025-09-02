<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'dashboard'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'dashboard'],
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
    public function actions()
    {
        $this->layout = 'main-menu';
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
    public function actionIndex($meja = null, $kategori = null)
    {
                
        // Dummy Data
        $mejaList = [
            ['id' => 1, 'nama' => 'Meja 1'],
            ['id' => 2, 'nama' => 'Meja 2'],
            ['id' => 3, 'nama' => 'Meja 3'],
            ['id' => 4, 'nama' => 'Meja 4'],
        ];

        $kategoriList = [
            ['id' => 1, 'nama' => 'Makanan', 'icon' => '🍜'],
            ['id' => 2, 'nama' => 'Minuman', 'icon' => '🥤'],
        ];

        $menuList = [
            1 => [
                ['id' => 101, 'nama' => 'Nasi Goreng', 'harga' => 20000],
                ['id' => 102, 'nama' => 'Mie Ayam', 'harga' => 15000],
            ],
            2 => [
                ['id' => 201, 'nama' => 'Es Teh', 'harga' => 5000],
                ['id' => 202, 'nama' => 'Kopi', 'harga' => 8000],
            ]
        ];
        $this->layout = 'main-menu'; 
        return $this->render('index', [
            'mejaList' => $mejaList,
            'kategoriList' => $kategoriList,
            'menuList' => $menuList,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login'; // Set a specific layout for the login page
        $model = new LoginForm();
    if ($model->load(Yii::$app->request->post())) {
        $user = User::findOne(['username' => $model->username]);

        if ($user && $user->validatePassword($model->password)) {
        Yii::$app->user->login($user);

        // Redirect based on role
        if ($user->role === 'admin') {
                return $this->redirect(['beranda/index']);
            } elseif ($user->role === 'kasir') {
                return $this->redirect(['beranda/kasir']);
            } elseif ($user->role === 'koki') {
                return $this->redirect(['beranda/koki']);
            } else {
                return $this->goBack();
            }
        }

        Yii::$app->session->setFlash('error', 'Username atau password salah.');
    }
    
        $model->password = '';
    
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
}
