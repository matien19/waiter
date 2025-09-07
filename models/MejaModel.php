<?php

namespace app\models;

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

}
