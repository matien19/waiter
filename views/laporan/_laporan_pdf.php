<h3 style="text-align:center">Laporan Pemasukan</h3>
<p>Periode: <?= $searchModel->date_start ?> s/d <?= $searchModel->date_end ?></p>

<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Pemasukan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($dataProvider->models as $tagihan): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= Yii::$app->formatter->asDatetime($tagihan->waktu_pembayaran, 'php:d F Y [H:i]') ?></td>
            <td><?= $tagihan->displayStatus() ?></td>
            <td>Rp <?= number_format((int)$tagihan->total, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align:right; font-weight:bold">Total Pemasukan</td>
            <td style="font-weight:bold">Rp <?= number_format($totalSemua, 0, ',', '.') ?></td>
        </tr>
    </tbody>
</table>
