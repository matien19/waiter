<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pesanan".
 *
 * @property int $id
 * @property int $meja_id
 * @property string $waktu
 * @property string $status_pesanan
 */
class PesananModel extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PESANAN_TERPESAN = 'Terpesan';
    const STATUS_PESANAN_TERKIRIM = 'Terkirim';
    const STATUS_PESANAN_TERBAYAR = 'Terbayar';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pesanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meja_id', 'waktu', 'status_pesanan'], 'required'],
            [['meja_id'], 'integer'],
            [['waktu'], 'safe'],
            [['status_pesanan'], 'string'],
            ['status_pesanan', 'in', 'range' => array_keys(self::optsStatusPesanan())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Pemesan',
            'meja_id' => 'No. Meja',
            'waktu' => 'Waktu',
            'status_pesanan' => 'Status Pesanan',
        ];
    }


    /**
     * column status_pesanan ENUM value labels
     * @return string[]
     */
    public static function optsStatusPesanan()
    {
        return [
            self::STATUS_PESANAN_TERPESAN => 'Terpesan',
            self::STATUS_PESANAN_TERKIRIM => 'Terkirim',
            self::STATUS_PESANAN_TERBAYAR => 'Terbayar',
        ];
    }

    /**
     * @return string
     */
    public function displayStatusPesanan()
    {
        return self::optsStatusPesanan()[$this->status_pesanan];
    }

    /**
     * @return bool
     */
    public function isStatusPesananTerpesan()
    {
        return $this->status_pesanan === self::STATUS_PESANAN_TERPESAN;
    }

    public function setStatusPesananToTerpesan()
    {
        $this->status_pesanan = self::STATUS_PESANAN_TERPESAN;
    }

    /**
     * @return bool
     */
    public function isStatusPesananTerkirim()
    {
        return $this->status_pesanan === self::STATUS_PESANAN_TERKIRIM;
    }

    public function setStatusPesananToTerkirim()
    {
        $this->status_pesanan = self::STATUS_PESANAN_TERKIRIM;
    }

    /**
     * @return bool
     */
    public function isStatusPesananTerbayar()
    {
        return $this->status_pesanan === self::STATUS_PESANAN_TERBAYAR;
    }

    public function setStatusPesananToTerbayar()
    {
        $this->status_pesanan = self::STATUS_PESANAN_TERBAYAR;
    }

    public function getPesananDetails() {
        return $this->hasMany(DetailPesananModel::class, ['pesanan_id' => 'id']);
    }
}
