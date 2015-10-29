<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PublicacionSearch represents the model behind the search form about `common\models\Publicacion`.
 */
class PublicacionSearch extends Publicacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpublicacion', 'duracion', 'exposicion', 'cantfotos'], 'integer'],
            [['nombre'], 'safe'],
            [['precio'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Publicacion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idpublicacion' => $this->idpublicacion,
            'precio' => $this->precio,
            'duracion' => $this->duracion,
            'exposicion' => $this->exposicion,
            'cantfotos' => $this->cantfotos,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
