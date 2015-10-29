<?php
namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * ArticleSearch represents the model behind the search form about `app\models\Aviso`.
 */
class AvisoSearch extends Aviso
{
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'user_id', 'estado', 'categoria', 'created_at', 'updated_at'], 'integer'],
            [['titulo', 'tipo','globalSearch','descripcion'], 'safe'],
        ];
    }

    /**
     * Returns a list of scenarios and the corresponding active attributes.
     *
     * @return array
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array   $params
     * @param integer $pageSize  The number of results to be displayed per page.
     * @param boolean $published Whether or not articles have to be published.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize = 3, $published = false)
    {
        $query = Aviso::find();

        // this means that editor is trying to see articles
        // we will allow him to see published ones and drafts made by him
        if ($published === true) 
        {
            $query->where(['estado' => Aviso::STATUS_PUBLICADO]);
            $query->andWhere(['eliminado' => 0]);
            $query->orWhere(['user_id' => Yii::$app->user->id]);
        }
        if ($published === false)
        {
            $query->Where(['user_id' => Yii::$app->user->id]);
            $query->andWhere(['eliminado' => 0]);
        }

        if (Yii::$app->user->can('admin'))
        {
            $query->where(true);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        /*$query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'estado' => $this->estado,
            'categoria' => $this->categoria,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);
        */
        $query->andFilterWhere(['like', 'titulo', $this->globalSearch])
            ->orFilterWhere(['like', 'descripcion', $this->globalSearch]);
        return $dataProvider;
    }

    public function searchIndex($params, $pageSize = 2, $published = true)
    {
        $query = Aviso::find();

        // this means that editor is trying to see articles
        // we will allow him to see published ones and drafts made by him
        if ($published === true)
        {
            $query->where(['estado' => Aviso::STATUS_PUBLICADO]);
            $query->andWhere(['eliminado' => 0]);
            $query->limit(Aviso::CANTAVISOSDEST)->all();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => false,

        ]);
        //echo '<br><br><br>'.$dataProvider->totalCount;
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'estado' => $this->estado,
            'categoria' => $this->categoria,
        ]);

        return $dataProvider;
    }
}
