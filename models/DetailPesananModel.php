<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detail_pesanan".
 *
 * @property int $id
 * @property int $pesanan_id
 * @property int $menu_id
 * @property int $jumlah
 * @property int $harga
 * @property int $subtotal
 */
class DetailPesananModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail_pesanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pesanan_id', 'menu_id', 'jumlah', 'harga', 'subtotal'], 'required'],
            [['pesanan_id', 'menu_id', 'jumlah', 'harga', 'subtotal'], 'integer'],
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
            'menu_id' => 'Menu ID',
            'jumlah' => 'Jumlah',
            'harga' => 'Harga',
            'subtotal' => 'Subtotal',
        ];
    }

}
