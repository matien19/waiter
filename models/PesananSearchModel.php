<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PesananModel;

/**
 * PesananSearchModel represents the model behind the search form of `app\models\PesananModel`.
 */
class PesananSearchModel extends PesananModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'meja_id'], 'integer'],
            [['nama', 'waktu', 'status_pesanan'], 'safe'],
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
    public function search($params, $formName = null)
    {
        $query = PesananModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'meja_id' => $this->meja_id,
            'waktu' => $this->waktu,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'status_pesanan', $this->status_pesanan]);

        return $dataProvider;
    }
}
