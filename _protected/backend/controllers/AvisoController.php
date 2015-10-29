<?php
namespace backend\controllers;

use common\models\Aviso;
use common\models\AvisoSearch;
use common\models\Publicacion;
use frontend\models\Confort;
use frontend\models\Seguridad;
use frontend\models\Multimedia;
use frontend\models\Exterior;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use Yii;
use yii\helpers\Json;
use yii\base\Model;

/**
 * ArticleController implements the CRUD actions for Aviso model.
 */
class AvisoController extends BackendController
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }
    /**
     * Lists all Aviso models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * How many articles we want to display per page.
         * @var integer
         */
        $pageSize = 2;

        /**
         * Articles have to be published.
         * @var boolean
         */
        $published = true;

        $searchModel = new AvisoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Aviso model.
     * 
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Aviso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Aviso();
        $modelConfort = new Confort();
        $modelSeguridad = new Seguridad();
        $modelMultimedia = new Multimedia();
        $modelExterior = new Exterior();

        $model->user_id = Yii::$app->user->id;
        if (
            $model->load(Yii::$app->request->post())
            && $modelConfort->load(Yii::$app->request->post())
            && $modelSeguridad->load(Yii::$app->request->post())
            && $modelMultimedia->load(Yii::$app->request->post())
            && $modelExterior->load(Yii::$app->request->post())
            && $model->validate()
            /*&& Model::validateMultiple
            ([
                $model,
                $modelConfort,
                $modelSeguridad,
                $modelMultimedia,
                $modelExterior

            ])*/
        ){
            //Definir aviso como pendiente
            $model->estado = Aviso::STATUS_PENDIENTE;

            $model->save(false); // skip validation as model is already validated

            $modelConfort->aviso_id=$model->id;
            $modelSeguridad->aviso_id=$model->id;
            $modelMultimedia->aviso_id=$model->id;
            $modelExterior->aviso_id=$model->id;

            $modelConfort->save(false);
            $modelSeguridad->save(false);
            $modelMultimedia->save(false);
            $modelExterior->save(false);

            //Si es posible basica, mostrar carga exitosa y sujeto a revision
            return $this->redirect(['admin']);

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelConfort' => $modelConfort,
                'modelSeguridad' => $modelSeguridad,
                'modelMultimedia' => $modelMultimedia,
                'modelExterior' => $modelExterior
            ]);
        }
    }

    /**
     * Updates an existing Aviso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @param  integer $id
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelConfort = Confort::findOne(['aviso_id'=>$id]);
        $modelSeguridad = Seguridad::findOne(['aviso_id'=>$id]);
        $modelMultimedia = Multimedia::findOne(['aviso_id'=>$id]);
        $modelExterior = Exterior::findOne(['aviso_id'=>$id]);

        if ($model->tipo == Aviso::AUTO){
            $model->scenario = Aviso::SCENARIO_AUTO;
        }elseif ($model->tipo == Aviso::CAMION){
            $model->scenario = Aviso::SCENARIO_CAMION;
        }elseif ($model->tipo == Aviso::CASARODANTE){
            $model->scenario = Aviso::SCENARIO_CRODANTE;
        }

        if (Yii::$app->user->can('updateArticle', ['model' => $model]))
        {
            if (
                $model->load(Yii::$app->request->post())
                && $modelConfort->load(Yii::$app->request->post())
                && $modelSeguridad->load(Yii::$app->request->post())
                && $modelMultimedia->load(Yii::$app->request->post())
                && $modelExterior->load(Yii::$app->request->post())
                //&& $model->validate()
            ){
            //if (Model::loadMultiple([$model,$modelConfort,$modelSeguridad,$modelMultimedia,$modelExterior],Yii::$app->request->post())){
                if ($model->validate()){
                    $model->save(false);
                    $modelConfort->save(false);
                    $modelSeguridad->save(false);
                    $modelMultimedia->save(false);
                    $modelExterior->save(false);

                    //Si es posible basica, mostrar carga exitosa y sujeto a revision
                    return $this->redirect(['admin']);

                }
            }
            else
            {
                return $this->render('update', [
                    'model' => $model,
                    'modelConfort' => $modelConfort,
                    'modelSeguridad' => $modelSeguridad,
                    'modelMultimedia' => $modelMultimedia,
                    'modelExterior' => $modelExterior
                ]);
            }
        }
        else
        {
            throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
        } 
    }

    /**
     * Deletes an existing Aviso model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @param  integer $id
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect('admin');
    }

    /**
     * Manage Articles.
     * 
     * @return mixed
     */
    public function actionAdmin()
    {
        /**
         * How many articles we want to display per page.
         * @var integer
         */
        $pageSize = 11;

        /**
         * Only admin+ roles can see everything.
         * Editors will be able to see only published articles and their own drafts @see: search(). 
         * @var boolean
         */
        $published = (Yii::$app->user->can('admin')) ? false : true ;

        $searchModel = new AvisoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Aviso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer  $id
     * @return Aviso The loaded model.
     * 
     * @throws NotFoundHttpException if the model cannot be found.
     */
    protected function findModel($id)
    {
        if (($model = Aviso::findOne($id)) !== null)
        {
            return $model;
        } 
        else 
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Aviso::getSubCatList($cat_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionProd() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $cat_id = empty($ids[0]) ? null : $ids[0];
            $subcat_id = empty($ids[1]) ? null : $ids[1];
            if ($cat_id != null) {
                $data = Aviso::getProdList($cat_id, $subcat_id);
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */

                echo Json::encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

}
