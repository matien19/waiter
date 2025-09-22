<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tagihan".
 *
 * @property int $id
 * @property int $pesanan_id
 * @property int $total
 * @property int $bayar
 * @property int $kembalian
 * @property string $waktu_pembayaran
 * @property string $status
 */
class TagihanModel extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_PENDING = 'Pending';
    const STATUS_TERBAYAR = 'Terbayar';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tagihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pesanan_id', 'total', 'bayar', 'kembalian', 'waktu_pembayaran', 'status'], 'required'],
            [['pesanan_id', 'total', 'bayar', 'kembalian'], 'integer'],
            [['waktu_pembayaran'], 'safe'],
            [['status'], 'string'],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pesanan_id' => 'Pesanan ID',
            'total' => 'Total',
            'bayar' => 'Bayar',
            'kembalian' => 'Kembalian',
            'waktu_pembayaran' => 'Waktu Pembayaran',
            'status' => 'Status',
        ];
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_TERBAYAR => 'Terbayar',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function setStatusToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isStatusTerbayar()
    {
        return $this->status === self::STATUS_TERBAYAR;
    }

    public function setStatusToTerbayar()
    {
        $this->status = self::STATUS_TERBAYAR;
    }
}
