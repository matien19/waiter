<?php

namespace app\models;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Yii;

/**
 * This is the model class for table "meja".
 *
 * @property int $id
 * @property string $no_meja
 */
class MejaModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_meja'], 'required'],
            [['no_meja'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_meja' => 'No Meja',
        ];
    }
    // public function afterSave($insert, $changedAttributes)
    // {
    //     parent::afterSave($insert, $changedAttributes);
    //     $this->generateQrFile();
    // }

    // /**
    //  * Generate dan simpan QR PNG ke web/qrcode/meja-<id>.png
    //  */
    // public function generateQrFile()
    // {
    //     try {
    //         $url = Yii::$app->urlManager->createAbsoluteUrl([
    //             'site/index',
    //             'id_meja' => $this->id,
    //         ]);

    //         // ✅ v4 style: pakai create() + withSize()
    //         $qrCode = QrCode::create($url)
    //             ->withSize(300)
    //             ->withMargin(10);

    //         $writer = new PngWriter();
    //         $result = $writer->write($qrCode);

    //         $dir = Yii::getAlias('@webroot') . '/qrcode';
    //         if (!is_dir($dir)) {
    //             mkdir($dir, 0777, true);
    //         }

    //         $file = $dir . '/meja-' . $this->id . '.png';
    //         $result->saveToFile($file);
    //     } catch (\Throwable $e) {
    //         Yii::error('Gagal generate QR untuk meja ' . $this->id . ': ' . $e->getMessage(), __METHOD__);
    //     }
    // }

}
