<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SI Resto</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->nama ?? '' ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php

                                            use hail812\adminlte\widgets\Menu;

            $userRole = Yii::$app->user->identity->role ?? '';
            $menuItems = [];
            if ($userRole == 'admin') {
                $menuItems[] = ['label' => 'Beranda', 'icon' => 'tachometer-alt', 'url' => ['beranda/index']];
                $menuItems[] = ['label' => 'Pesanan', 'icon' => 'clipboard-list', 'url' => ['pesanan/index']];
                $menuItems[] = ['label' => 'Laporan', 'icon' => 'chart-line', 'url' => ['laporan/index']];

                
                if ($userRole == 'admin') {
                    $menuItems[] = [
                        'label' => 'Master Data',
                        'icon' => 'database',
                        'items' => [
                            [
                                'label' => 'Kasir',
                                'iconStyle' => 'far',
                                'url' => ['kasir/index'],
                                'active' => Yii::$app->controller->id === 'kasir',
                            ],
                            [
                                'label' => 'Koki',
                                'iconStyle' => 'far',
                                'url' => ['koki/index'],
                                'active' => Yii::$app->controller->id === 'koki',
                            ],
                            [
                                'label' => 'Meja',
                                'iconStyle' => 'far',
                                'url' => ['meja/index'],
                                'active' => Yii::$app->controller->id === 'meja',
                            ],
                            [
                                'label' => 'Kategori',
                                'iconStyle' => 'far',
                                'url' => ['kategori/index'],
                                'active' => Yii::$app->controller->id === 'kategori',
                            ],
                            [
                                'label' => 'Menu',
                                'iconStyle' => 'far',
                                'url' => ['menu/index'],
                                'active' => Yii::$app->controller->id === 'menu',
                            ],
                        ],
                    ];
                }


            } elseif($userRole == 'kasir') {
                $menuItems = [
                    ['label' => 'Beranda', 'icon' => 'tachometer-alt', 'url' => ['beranda/kasir']],
                    ['label' => 'Pesanan', 'icon' => 'clipboard-list', 'url' => ['pesanan/index']],
                    ['label' => 'Laporan', 'icon' => 'chart-line', 'url' => ['laporan/index']],
                ];
                
            } else{
                $menuItems = [
                    ['label' => 'Beranda', 'icon' => 'tachometer-alt', 'url' => ['beranda/koki']],
                    ['label' => 'Pesanan', 'icon' => 'clipboard-list', 'url' => ['pesanan/index']],
                ];
            }

            echo Menu::widget([
                'items' => $menuItems,
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>