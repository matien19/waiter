<?php

namespace app\controllers;

use app\models\DetailPesananModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\MejaModel;
use app\models\MenuModel;
use app\models\PesananModel;
use app\models\TagihanModel;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::class,
            //     'only' => ['logout', 'dashboard', 'checkout'],
            //     'rules' => [
            //         [
            //             'actions' => ['login', 'error'],
            //             'allow' => true,
            //         ],
            //         [
            //             'actions' => ['logout', 'dashboard', 'checkout', 'order', 'index'],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
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
    public function actionIndex($no_meja = null)
    {
                
        $menuList = MenuModel::find()
            ->joinWith('kategori')
            ->all();

        $this->layout = 'main-menu'; 
        return $this->render('index', [
            'menuList' => $menuList,
            'no_meja' => $no_meja,
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
        $noMeja = Yii::$app->request->post('no_meja'); // ambil dari hidden input di index

        if (!$cart) {
            Yii::$app->session->setFlash('error', 'Keranjang kosong.');
            return $this->redirect(['site/index']);
        }

        // simpan ke session biar bisa dipakai lagi
        Yii::$app->session->set('cart', $cart);
        Yii::$app->session->set('no_meja', $noMeja);

        return $this->render('checkout', [
            'cart' => $cart,
            'noMeja' => $noMeja,
        ]);
    }


    public function actionOrder()
    {
        $request = Yii::$app->request;
        $nama = $request->post('nama');
        $noMeja = $request->post('no_meja');

        // ambil cart dari session
        $cart = Yii::$app->session->get('cart', []);

        if (empty($cart)) {
            Yii::$app->session->setFlash('error', 'Keranjang kosong.');
            return $this->redirect(['site/index']);
        }

        // cari id meja dari no_meja
        $meja = MejaModel::findOne(['no_meja' => $noMeja]);
        if (!$meja) {
            Yii::$app->session->setFlash('error', 'Nomor meja tidak ditemukan.');
            return $this->redirect(['site/index']);
        }

        // mulai transaksi
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // simpan pesanan
            $pesanan = new PesananModel();
            $pesanan->nama = $nama;
            $pesanan->meja_id = $meja->no_meja;
            $pesanan->waktu = date('Y-m-d H:i:s');
            $pesanan->status_pesanan = PesananModel::STATUS_PESANAN_TERPESAN;

            if (!$pesanan->save()) {
                throw new \Exception('Gagal simpan pesanan: ' . json_encode($pesanan->errors));
            }
            $total_taggihan = 0;
            // simpan detail pesanan
            foreach ($cart as $item) {

                $detail = new DetailPesananModel();
                $detail->pesanan_id = $pesanan->id;
                $detail->menu_id = $item['id'];
                $detail->jumlah = $item['qty'];
                $detail->harga = $item['harga'];
                $detail->subtotal = $item['total'];
                
                $total_taggihan += $item['total'];

                if (!$detail->save()) {
                    throw new \Exception('Gagal simpan detail: ' . json_encode($detail->errors));
                }
            }

            $tagihan = new TagihanModel();
            $tagihan->pesanan_id = $pesanan->id;
            $tagihan->total = $total_taggihan;
            $tagihan->bayar = 0; // belum dibayar
            $tagihan->kembalian = 0; // belum ada kembalian
            $tagihan->waktu_pembayaran = date('Y-m-d H:i:s');
            $tagihan->status = TagihanModel::STATUS_PENDING;
            if (!$tagihan->save()) {
                throw new \Exception('Gagal simpan tagihan: ' . json_encode($tagihan->errors));
            }
    
            // bersihkan session cart
            Yii::$app->session->remove('cart');
            Yii::$app->session->remove('no_meja');

            Yii::$app->session->setFlash('success', 'Pesanan berhasil disimpan untuk Meja ' . $noMeja);
            $transaction->commit();
            return $this->redirect(['site/index', 'no_meja' => $noMeja]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat menyimpan pesanan.' . $e->getMessage());
            // return $this->redirect(['site/checkout']);
            return $this->redirect(['site/index', 'no_meja' => $noMeja]);
        }
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
}
