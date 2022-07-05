<?php

namespace backend\models;

use backend\services\SupplierService;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Supplier;

/**
 * SupplierSearch represents the model behind the search form of `backend\models\Supplier`.
 *
 * @property string $id_range_tag
 */
class SupplierSearch extends Supplier
{
    // id筛选范围表示符号
    public $id_range_tag = '=';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id_range_tag', 'default', 'value'=>'='],
            ['id_range_tag', 'in', 'range'=>array_keys((new SupplierService())->getIdRangeTags())],
            [['id'], 'integer'],
            [['name', 'code', 't_status'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Supplier::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $res = $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([$this->id_range_tag, 'id', $this->id]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 't_status', $this->t_status]);

        return $dataProvider;
    }
}
