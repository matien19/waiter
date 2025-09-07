<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $nama
 * @property int $id_kategori
 * @property int $harga
 * @property int $stok
 * @property string $gambar
 */
class MenuModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'id_kategori', 'harga', 'stok', 'gambar'], 'required'],
            [['id_kategori', 'harga', 'stok'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['gambar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'id_kategori' => 'Kategori',
            'harga' => 'Harga',
            'stok' => 'Stok',
            'gambar' => 'Gambar',
        ];
    }
    public function getKategori()
    {
        return $this->hasOne(KategoriModel::class, ['id' => 'id_kategori']);
    }

}
