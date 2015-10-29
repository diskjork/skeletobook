<?php

namespace frontend\controllers;

use common\models\Aviso;
use Yii;
use common\models\Solicituddepago;
use common\models\SolicituddepagoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Publicacion;
use yii\helpers\Html;


/**
 * SolicituddepagoController implements the CRUD actions for Solicituddepago model.
 */
class SolicituddepagoController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update','delete','pagar','imprimir'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Solicituddepago models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SolicituddepagoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Solicituddepago model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Solicituddepago model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Solicituddepago();
        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->idsolicitudepago]);
        } else {
            return $this->render('create', [
                'model' => $model,


            ]);
        }
    }

    public function actionPagar($aviso_id)
    {
        $model = new Solicituddepago();

        $modelAviso = Aviso::findOne(['id'=>$aviso_id]);
        $modelPublicacion = Publicacion::findOne(['idpublicacion'=>$modelAviso->publicacion_id]);

        $model->aviso_id=$aviso_id;
        $model->publicacion_id = $modelAviso->publicacion_id;
        $model->precio = $modelPublicacion->precio;
        if ($model->loadAll(Yii::$app->request->post()) && $model->control==1) {
            $model->venc = 5; //5 dias para pagar el cupón porque sino vence.
            $model->codigo = $model->aviso_id . Yii::$app->user->id . date('dmY');
            $model->concepto = 'Publicidad de aviso - mundomotor.com.ar';
            $model->moneda = 'ARS';
            $model->user_id = Yii::$app->user->id;
            //$model->publicacion_id = $modelAviso->publicacion_id;

            //Se define la fecha de vencimiento
            $fecha = new \DateTime('NOW');
            $fecha->add(new \DateInterval('P5D'));
            $model->expira=$fecha->format('Ymd');
            //Se define id de CD
            $idcc='565512';
            try{
                //Se obtienen los datos del cupon
                $xmlCupon = file_get_contents('https://www.cuentadigital.com/api.php?id='.$idcc.'&precio='.$model->precio.'&venc='.$model->venc.'&codigo='.$model->codigo.'&concepto='.urlencode($model->concepto).'&xml=1');
                $cuponXML = simplexml_load_string($xmlCupon);
                $model->codigodepago = $cuponXML->INVOICE->PAYMENTCODE1."";
                $model->estado=Solicituddepago::ESTADO_IMP;

                if ($xmlCupon != FALSE && $cuponXML != FALSE) {
                    if ($model->saveAll()) {
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success',
                            'duration' => 6000,
                            'icon' => 'glyphicon glyphicon-ok-sign',
                            'message' => Yii::t('app',Html::encode('Se ha cargado correctamente.')),
                            'title' => Yii::t('app', Html::encode('Bien hecho!')),
                            'positonY' => 'top',
                            'positonX' => 'center'
                        ]);
                        return $this->redirect(['admin']);
                     } else {
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                }
            }
            catch(\Exception $e){
                throw $e;
            }

        } else {
            Yii::$app->getSession()->setFlash('danger', [
                'type' => 'danger',
                'duration' => 6000,
                'icon' => 'glyphicon glyphicon-remove-sign',
                'message' => Yii::t('app',Html::encode('Falta marcar la opcion Control.')),
                'title' => Yii::t('app', Html::encode('ERROR')),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
            return $this->render('create', [
                'model' => $model,


            ]);
        }
    }
    /**
     * Updates an existing Solicituddepago model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll() && $model->control==1) {
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 6000,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'message' => Yii::t('app',Html::encode('Se ha cargado correctamente.')),
                'title' => Yii::t('app', Html::encode('Bien hecho!')),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
            return $this->redirect(['view', 'id' => $model->idsolicitudepago]);
        } else {
            Yii::$app->getSession()->setFlash('danger', [
                'type' => 'danger',
                'duration' => 6000,
                'icon' => 'glyphicon glyphicon-remove-sign',
                'message' => Yii::t('app',Html::encode('Falta marcar la opcion Control.')),
                'title' => Yii::t('app', Html::encode('ERROR')),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Solicituddepago model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithChildren();

        return $this->redirect(['index']);
    }
    
    /**
     * Finds the Solicituddepago model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicituddepago the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Solicituddepago::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    public function actionImprimir($id){
        $model = $this->findModel($id);

        return $this->renderPartial('imprimirsp', [
            'model' => $model,
        ]);
    }
}
