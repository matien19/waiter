<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\MejaModel;
use app\models\MenuModel;
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
    protected function getRedirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return ['beranda/index'];
            case 'kasir':
                return ['beranda/kasir'];
            case 'koki':
                return ['beranda/koki'];
            default:
                return $this->goHome(); // fallback
        }
    }
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
    public function actionIndex()
    {
                
        $menuList = MenuModel::find()
            ->joinWith('kategori')
            ->all();

        $this->layout = 'main-menu'; 
        return $this->render('index', [
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
            return $this->redirect($this->getRedirectByRole(Yii::$app->user->identity->role));
        }

        $this->layout = 'main-login'; // Set a specific layout for the login page
        $model = new LoginForm();
    if ($model->load(Yii::$app->request->post())) {
        $user = User::findOne(['username' => $model->username]);

        if ($user && $user->validatePassword($model->password)) {
            Yii::$app->user->login($user);

            // arahkan sesuai role
            return $this->redirect($this->getRedirectByRole($user->role));
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

    public function actionCheckout()
    {
    $cartData = Yii::$app->request->post('cart_data');
    $cart = json_decode($cartData, true);

    if (!$cart) {
        Yii::$app->session->setFlash('error', 'Keranjang kosong.');
        return $this->redirect(['site/index']);
    }

    // simpan ke session biar bisa dipakai lagi
    Yii::$app->session->set('cart', $cart);

    $mejaList = MejaModel::find()->all();
    return $this->render('checkout', [
        'cart' => $cart,
        'mejaList' => $mejaList,
    ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
}
