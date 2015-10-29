<?php
/**
 * Created by PhpStorm.
 * User: nekro
 * Date: 06/10/2015
 * Time: 06:17 PM
 *
 * Verifica el estado de avisos. Envia notificacion de aquellos que están por vencer 5 días antes.
 */

namespace console\controllers;

use common\models\User;
use yii\base\Exception;
use yii\console\Controller;
use Yii;
use common\models\Aviso;

class VerificaAvisosController extends Controller{



    public function actionInit()
    {

        $hoy = date("Y-m-d");

        $avisos = Aviso::find()
            ->asArray()
            ->joinWith('publicacion')
            ->where(['aviso.estado' => Aviso::STATUS_PUBLICADO])
            ->andWhere(['=','from_unixtime(aviso.created_at,'."'%Y-%m-%d'".') + interval (publicacion.duracion -'.\Yii::$app->params['diasAviso'].') day',$hoy])
            ->all();

        if($avisos != null){
            for ($i=0;$i<count($avisos);$i++){
                $userActual=User::findOne($avisos[$i]['user_id']);
                if ($userActual->email!=NULL) {
                    try {
                        \Yii::$app->mailer->compose()
                            ->setFrom([\Yii::$app->params['supportEmail'] => 'Mundo MOTOR'])
                            ->setTo($userActual->email)
                            ->setSubject('Aviso de vencimiento')
                            ->setHtmlBody('Estimado <strong>' . $userActual->username . '</strong>.<br>
                                        Le informamos que el aviso <strong>' . $avisos[$i]['titulo'] . '</strong> esta por vencer. Puede renovarlo ingresando al sitio web.<br><br>
                                        Atte.<br>Mundo MOTOR')
                            ->send();
                    }
                    catch(Exception $e){
                        throw $e;
                    }
                }
            }
        }

        //Verificar avisos vencidos y desactivarlos pasados 5 dias desde el vencimiento
    }
}