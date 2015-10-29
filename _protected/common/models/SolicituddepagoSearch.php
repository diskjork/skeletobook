<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SolicituddepagoSearch represents the model behind the search form about `common\models\Solicituddepago`.
 */
class SolicituddepagoSearch extends Solicituddepago
{
    /**
     * @inheritdoc
     */
    public $publicacion;

    public function rules()
    {
        return [
            [['idsolicitudepago', 'venc', 'created_at', 'updated_at', 'estado', 'aviso_id', 'user_id', 'publicacion_id'], 'integer'],
            [['precio'], 'number'],
            [['publicacion'], 'safe'],
            [['codigo', 'concepto', 'moneda', 'codigodepago', 'expira'], 'safe'],
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
        $query = Solicituddepago::find();

        $query->Where(['>=','expira',date("Y-m-d")]);

        $query->joinWith(['publicacion']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['publicacion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['publicacion.nombre' => SORT_ASC],
            'desc' => ['publicacion.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idsolicitudepago' => $this->idsolicitudepago,
            'precio' => $this->precio,
            'venc' => $this->venc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'expira' => $this->expira,
            'estado' => $this->estado,
            'aviso_id' => $this->aviso_id,
            'user_id' => $this->user_id,
            'publicacion_id' => $this->publicacion_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'concepto', $this->concepto])
            ->andFilterWhere(['like', 'moneda', $this->moneda])
            ->andFilterWhere(['like', 'codigodepago', $this->codigodepago])
            ->andFilterWhere(['like', 'publicacion.nombre', $this->publicacion]);

        $fecha = new \DateTime('NOW');
        $query->having(['>=', 'expira', $fecha->format('Ymd')])
            ->orHaving(['=', 'estado', 1]);

        return $dataProvider;
    }

    public function searchadm($params)
    {
        $query = Solicituddepago::find();

        $query->joinWith(['publicacion']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['publicacion'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['publicacion.nombre' => SORT_ASC],
            'desc' => ['publicacion.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idsolicitudepago' => $this->idsolicitudepago,
            'precio' => $this->precio,
            'venc' => $this->venc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'expira' => $this->expira,
            'estado' => $this->estado,
            'aviso_id' => $this->aviso_id,
            'user_id' => $this->user_id,
            'publicacion_id' => $this->publicacion_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'concepto', $this->concepto])
            ->andFilterWhere(['like', 'moneda', $this->moneda])
            ->andFilterWhere(['like', 'codigodepago', $this->codigodepago])
            ->andFilterWhere(['like', 'publicacion.nombre', $this->publicacion]);

        return $dataProvider;
    }
}
