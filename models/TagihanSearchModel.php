<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TagihanModel;

/**
 * TagihanSearchModel represents the model behind the search form of `app\models\TagihanModel`.
 */
class TagihanSearchModel extends TagihanModel
{
    /**
     * {@inheritdoc}
     */

    public $date_start;
    public $date_end;

    public function rules()
    {
        return [
            [['id', 'pesanan_id', 'total', 'bayar', 'kembalian'], 'integer'],
            [['waktu_pembayaran', 'status','date_start', 'date_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TagihanModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filter tanggal jika ada
        if (!empty($this->date_start) && !empty($this->date_end)) {
            $query->andFilterWhere(['between', 'waktu_pembayaran', $this->date_start . ' 00:00:00', $this->date_end . ' 23:59:59']);
        }

        // Filter status misalnya
        $query->andFilterWhere(['status' => $this->status]);

        return $dataProvider;
    }
}
