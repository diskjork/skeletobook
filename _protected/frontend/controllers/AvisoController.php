<?php
namespace frontend\controllers;

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
use yii\helpers\Html;
use common\models\User;
use frontend\models\ContactForm;

/**
 * ArticleController implements the CRUD actions for Aviso model.
 */
class AvisoController extends FrontendController
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
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelConfort' => Confort::findOne(['aviso_id'=>$id]),
            'modelSeguridad' => Seguridad::findOne(['aviso_id'=>$id]),
            'modelMultimedia' => Multimedia::findOne(['aviso_id'=>$id]),
            'modelExterior' => Exterior::findOne(['aviso_id'=>$id]),

        ]);
    }*/

    public function actionContacto(){
        $modelContacto = new ContactForm();
        $modelContacto->scenario = ContactForm::SCENARIO_CONTACTAR;

        if($modelContacto->load(Yii::$app->request->post()) && $modelContacto->validate()){
            $modelContacto->subject='Consulta desde TROCA MOTOR';
            if ($modelContacto->contact('lucas.perea@gmail.com'))//$model->user->email))
            {
                //Yii::$app->session->setFlash('success','Su consulta ha sido satisfactoriamente.');
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 6000,
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'message' => Yii::t('app',Html::encode('Consulta enviada correctamente.')),
                    'title' => Yii::t('app', Html::encode('Bien hecho!')),
                    'positonY' => 'top',
                    'positonX' => 'center'
                ]);
                return $this->redirect(['index']);
            }
            else
            {
                Yii::$app->getSession()->setFlash('error', [
                    'type' => 'error',
                    'duration' => 6000,
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'message' => Yii::t('app',Html::encode('Error en el envio.')),
                    'title' => Yii::t('app', Html::encode('ERROR!')),
                    'positonY' => 'top',
                    'positonX' => 'center'
                ]);
                return $this->redirect(['index']);
            }

           //return $this->refresh();
        }
        else
        {
            return $this->renderAjax('contacto', [
                'modelContacto' => $modelContacto,
            ]);
        }

    }

    public function actionView($id) {
        $model=$this->findModel($id);

        //Solo podrán visualizar si es el propietario o el aviso está activo
        if (Yii::$app->user->can('updateArticle', ['model' => $model]) || $model->estado==Aviso::STATUS_PUBLICADO) {
            $model->scenario = Aviso::SCENARIO_ADVVIEW;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('kv-detail-success', 'Su aviso se ha cargado correctamente.');
                // Multiple alerts can be set like below
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                if ($model->tipo == Aviso::AUTO) {
                    return $this->render('view', [
                        'model' => $this->findModel($id),
                        'modelConfort' => Confort::findOne(['aviso_id' => $id]),
                        'modelSeguridad' => Seguridad::findOne(['aviso_id' => $id]),
                        'modelMultimedia' => Multimedia::findOne(['aviso_id' => $id]),
                        'modelExterior' => Exterior::findOne(['aviso_id' => $id]),
                    ]);
                } elseif ($model->tipo == Aviso::CAMION) {
                    return $this->render('viewcamion', [
                        'model' => $this->findModel($id),
                        'modelConfort' => Confort::findOne(['aviso_id' => $id]),
                        'modelSeguridad' => Seguridad::findOne(['aviso_id' => $id]),
                        'modelMultimedia' => Multimedia::findOne(['aviso_id' => $id]),
                        'modelExterior' => Exterior::findOne(['aviso_id' => $id]),
                    ]);
                } elseif ($model->tipo == Aviso::CASARODANTE) {
                    return $this->render('viewcrodante', [
                        'model' => $this->findModel($id),
                        'modelConfort' => Confort::findOne(['aviso_id' => $id]),
                        'modelSeguridad' => Seguridad::findOne(['aviso_id' => $id]),
                        'modelMultimedia' => Multimedia::findOne(['aviso_id' => $id]),
                        'modelExterior' => Exterior::findOne(['aviso_id' => $id]),
                    ]);
                } elseif ($model->tipo == Aviso::MOTO) {
                    return $this->render('viewmoto', [
                        'model' => $this->findModel($id),
                    ]);
                }
            }
        }else{
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Inicio de carga de un aviso
     * Se interpreta primero el tipo (auto, camion, casilla o moto)
     */
    public function actionNuevo()
    {
        $model = new Aviso();
        $model->scenario = Aviso::SCENARIO_CARGA;
        if ($model->load(Yii::$app->request->post())  && $model->validate()){
            if ($model->tipo == Aviso::AUTO ||  $model->tipo == Aviso::CAMION || $model->tipo == Aviso::CASARODANTE)
                return $this->redirect(['create','tipo'=>$model->tipo]);
            elseif ($model->tipo == Aviso::MOTO){
                return $this->redirect(['createmoto','tipo'=>$model->tipo]);
            }else {
                return $this->redirect(['admin']);
            }
        }
        return $this->render('nuevo',['model'=>$model]);
    }

    /**
     * Creates a new Aviso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate($tipo=null)
    {
        //Se verifica primero que haya sido seleccionado el tipo
        if ($tipo == Aviso::AUTO ||  $tipo == Aviso::CAMION || $tipo == Aviso::CASARODANTE) {
            $model = new Aviso();
            $modelConfort = new Confort();
            $modelSeguridad = new Seguridad();
            $modelMultimedia = new Multimedia();
            $modelExterior = new Exterior();

            $model->tipo = $tipo;
            $model->user_id = Yii::$app->user->id;
            if ($tipo == Aviso::AUTO){
                $model->scenario = Aviso::SCENARIO_AUTO;
            }elseif ($tipo == Aviso::CAMION){
                $model->scenario = Aviso::SCENARIO_CAMION;
            }elseif ($tipo == Aviso::CASARODANTE){
                $model->scenario = Aviso::SCENARIO_CRODANTE;
            }elseif ($tipo == Aviso::MOTO){
                $model->scenario = Aviso::SCENARIO_MOTO;
            }

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
            ) {
                //Definir aviso como pendiente
                $model->estado = Aviso::STATUS_PENDIENTE;
                //Iniciar contador de visitas
                $model->visitas = 0;
                //$model

                $model->save(false); // skip validation as model is already validated

                $modelConfort->aviso_id = $model->id;
                $modelSeguridad->aviso_id = $model->id;
                $modelMultimedia->aviso_id = $model->id;
                $modelExterior->aviso_id = $model->id;

                $modelConfort->save(false);
                $modelSeguridad->save(false);
                $modelMultimedia->save(false);
                $modelExterior->save(false);

                //Si es posible basica, mostrar carga exitosa y sujeto a revision
                if ($model->publicacion_id == 1) {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 6000,
                        'icon' => 'glyphicon glyphicon-ok-sign',
                        'message' => Yii::t('app', Html::encode('Su aviso se ha cargado correctamente.')),
                        'title' => Yii::t('app', Html::encode('Bien hecho!')),
                        'positonY' => 'top',
                        'positonX' => 'center'
                    ]);
                    //Envio de notificacion por mail
                    $userActual = User::findOne(Yii::$app->user->id);
                    if ($userActual->email != NULL) {
                        \Yii::$app->mailer->compose()
                            ->setFrom([\Yii::$app->params['supportEmail'] => 'Troca Motor'])
                            ->setTo($userActual->email)
                            ->setSubject('Aviso TROCA MOTOR')
                            ->setHtmlBody('Estimado <strong>' . $userActual->username . '</strong>.<br>
                                    Le informamos que el aviso <strong>' . $model->titulo . '</strong> ha sido cargado correctamente.<br><br>
                                    Atte.<br>Mundo MOTOR')
                            ->send();
                    }

                    return $this->redirect(['admin']);//, 'id' => $model->id]);
                } else {
                    //$modelPublicacion = Publicacion::findOne(['idpublicacion'=>$model->publicacion_id]);
                    return $this->redirect(['solicituddepago/pagar', 'aviso_id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'modelConfort' => $modelConfort,
                    'modelSeguridad' => $modelSeguridad,
                    'modelMultimedia' => $modelMultimedia,
                    'modelExterior' => $modelExterior
                ]);
            }
        }else{
            Yii::$app->getSession()->setFlash('warning', [
                'type' => 'warning',
                'duration' => 6000,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'message' => Yii::t('app', Html::encode('No ha seleccionado el tipo de vehiculo.')),
                'title' => Yii::t('app', Html::encode('Revisar!')),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
            return $this->redirect(['nuevo']);
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
                    if($model->publicacion_id==1) {
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success',
                            'duration' => 6000,
                            'icon' => 'glyphicon glyphicon-ok-sign',
                            'message' => Yii::t('app',Html::encode('Su aviso se ha actualizado correctamente.')),
                            'title' => Yii::t('app', Html::encode('Bien hecho!')),
                            'positonY' => 'top',
                            'positonX' => 'center'
                        ]);
                        //Envio de notificacion por mail
                        $userActual=User::findOne(Yii::$app->user->id);
                        if ($userActual->email!=NULL){
                            \Yii::$app->mailer->compose()
                                ->setFrom([\Yii::$app->params['supportEmail'] => 'Troca Motor'])
                                ->setTo($userActual->email)
                                ->setSubject('Aviso TROCA MOTOR')
                                ->setHtmlBody('Estimado <strong>' . $userActual->username . '</strong>.<br>
								Le informamos que el aviso <strong>' . $model->titulo . '</strong> ha sido modificado correctamente.<br><br>
								Atte.<br>Mundo MOTOR')
                                ->send();
                        }
                        return $this->redirect(['admin']);//, 'id' => $model->id]);
                    }else{
                        $modelPublicacion = Publicacion::findOne(['idpublicacion'=>$model->publicacion_id]);
                        return $this->redirect(['solicituddepago/pagar','aviso_id'=>$id]);
                        //return Yii::$app->runAction('solicituddepago/pagar',['aviso_id'=>$id]);
                    }
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
            return $this->redirect(['site/index']);
            //throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
        } 
    }

    //Carga de aviso de motos
    public function actionCreatemoto($tipo=null)
    {
        //Se verifica primero que haya sido seleccionado el tipo
        if ($tipo == Aviso::MOTO) {
            $model = new Aviso();

            $model->tipo = $tipo;
            $model->user_id = Yii::$app->user->id;
            if ($tipo == Aviso::MOTO){
                $model->scenario = Aviso::SCENARIO_MOTO;
            }

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                //Definir aviso como pendiente
                $model->estado = Aviso::STATUS_PENDIENTE;
                //Iniciar contador de visitas
                $model->visitas = 0;
                //$model

                $model->save(false); // skip validation as model is already validated

               //Si es posible basica, mostrar carga exitosa y sujeto a revision
                if ($model->publicacion_id == 1) {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 6000,
                        'icon' => 'glyphicon glyphicon-ok-sign',
                        'message' => Yii::t('app', Html::encode('Su aviso se ha cargado correctamente.')),
                        'title' => Yii::t('app', Html::encode('Bien hecho!')),
                        'positonY' => 'top',
                        'positonX' => 'center'
                    ]);
                    //Envio de notificacion por mail
                    $userActual = User::findOne(Yii::$app->user->id);
                    if ($userActual->email != NULL) {
                        \Yii::$app->mailer->compose()
                            ->setFrom([\Yii::$app->params['supportEmail'] => 'Troca Motor'])
                            ->setTo($userActual->email)
                            ->setSubject('Aviso TROCA MOTOR')
                            ->setTextBody('Estimado <strong>' . $userActual->username . '</strong>.<br>
                                    Le informamos que el aviso <strong>' . $model->titulo . '</strong> ha sido cargado correctamente.<br><br>
                                    Atte.<br>Mundo MOTOR')
                            ->send();
                    }

                    return $this->redirect(['admin']);//, 'id' => $model->id]);
                } else {
                    //$modelPublicacion = Publicacion::findOne(['idpublicacion'=>$model->publicacion_id]);
                    return $this->redirect(['solicituddepago/pagar', 'aviso_id' => $model->id]);
                }
            } else {
                return $this->render('createmoto', [
                    'model' => $model,
                ]);
            }
        }else{
            Yii::$app->getSession()->setFlash('warning', [
                'type' => 'warning',
                'duration' => 6000,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'message' => Yii::t('app', Html::encode('No ha seleccionado el tipo de vehiculo.')),
                'title' => Yii::t('app', Html::encode('Revisar!')),
                'positonY' => 'top',
                'positonX' => 'center'
            ]);
            return $this->redirect(['nuevo']);
        }
    }

    public function actionUpdatemoto($id)
    {
        $model = $this->findModel($id);

        if ($model->tipo == Aviso::MOTO){
            $model->scenario = Aviso::SCENARIO_MOTO;
        }


        if (Yii::$app->user->can('updateArticle', ['model' => $model]))
        {
            if ($model->load(Yii::$app->request->post())&& $model->save()){
                    //Si es posible basica, mostrar carga exitosa y sujeto a revision
                    if($model->publicacion_id==1) {
                        Yii::$app->getSession()->setFlash('success', [
                            'type' => 'success',
                            'duration' => 6000,
                            'icon' => 'glyphicon glyphicon-ok-sign',
                            'message' => Yii::t('app',Html::encode('Su aviso se ha actualizado correctamente.')),
                            'title' => Yii::t('app', Html::encode('Bien hecho!')),
                            'positonY' => 'top',
                            'positonX' => 'center'
                        ]);
                        //Envio de notificacion por mail
                        $userActual=User::findOne(Yii::$app->user->id);
                        if ($userActual->email!=NULL){
                            \Yii::$app->mailer->compose()
                                ->setFrom([\Yii::$app->params['supportEmail'] => 'Troca Motor'])
                                ->setTo($userActual->email)
                                ->setSubject('Aviso TROCA MOTOR')
                                ->setHtmlBody('Estimado <strong>' . $userActual->username . '</strong>.<br>
								Le informamos que el aviso <strong>' . $model->titulo . '</strong> ha sido modificado correctamente.<br><br>
								Atte.<br>Mundo MOTOR')
                                ->send();
                        }
                        return $this->redirect(['admin']);//, 'id' => $model->id]);
                    }else{
                        $modelPublicacion = Publicacion::findOne(['idpublicacion'=>$model->publicacion_id]);
                        return $this->redirect(['solicituddepago/pagar','aviso_id'=>$id]);
                    }
            }
            else
            {
                return $this->render('updatemoto', [
                    'model' => $model,
                ]);
            }
        }
        else
        {
            return $this->redirect(['site/index']);
            //throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
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
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateArticle', ['model' => $model]))
        {
            $model->eliminado=1;
            if ($model->save(false)){
                Yii::$app->getSession()->setFlash('warning', [
                    'type' => 'warning',
                    'duration' => 6000,
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'message' => Yii::t('app',Html::encode('Su aviso se ha eliminado correctamente.')),
                    'title' => Yii::t('app', Html::encode('Aviso eliminado!')),
                    'positonY' => 'top',
                    'positonX' => 'center'
                ]);
            }
        }

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
        $published = (Yii::$app->user->can('editor')) ? false : true ;

        $searchModel = new AvisoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /*action para la vista busqueda de /frondtend/view/busqueda
    */
    public function actionBusqueda()
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
        $published = (Yii::$app->user->can('editor')) ? false : true ;

        $searchModel = new AvisoSearch();
     
        
        if(!isset($_POST['search']))
            {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);
        } else {
           
            $_GET['AvisoSearch']['globalSearch']=$_POST['search'];
            
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);
        }
        
        return $this->render('busqueda', [
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
