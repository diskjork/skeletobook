<?php

namespace console\controllers;

use common\models\base\Pago;
use common\models\User;
use yii\base\Exception;
use yii\helpers\Console;
use yii\console\Controller;
use Yii;
/**
 * Created by PhpStorm.
 * User: nekro
 * Date: 17/08/2015
 * Time: 08:47 PM
 */
class ObtenPagosController extends Controller
{

    public function actionInit()
    {
        //Se genera fecha de ayer para obtener todos los pagos
        $date = new \DateTime();
        $date->add(\DateInterval::createFromDateString('yesterday'));

        //PARA SISTEMA EN PRUEBA
        $html = file_get_contents('https://www.cuentadigital.com/exportacionsandbox.php?control=72ab4695b4d1bd4beb6f6026c92a94ce&fecha='.$date->format('Ymd'));
        //PARA SISTEMA EN PRODUCCION
        //$html = file_get_contents('https://www.cuentadigital.com/exportacion.php?control=72e084c5cd21f0d05d248c872bce2f4c&fecha='.$date->format('Ymd'));


        if ($html!==FALSE)
        {
            //Se genera array con el html resultante
            $resultadosQuery= explode(chr(10), $html);
            for ($i=0;$i<count($resultadosQuery)-1;$i++){
                $arrayPagos[$i]=explode("|",$resultadosQuery[$i]);
            }


            //$userActual = new User;
            $pagoRealizado = new Pago;


            for ($i=0;$i<count($resultadosQuery)-1;$i++){
                $modelPagos = new Pago;
                //conversion de formato de fecha
                $fN = str_split($arrayPagos[$i][0]);
                $fechaFinal=$fN[4].$fN[5].$fN[6].$fN[7].$fN[2].$fN[3].$fN[0].$fN[1];
                $modelPagos->fechapago=$fechaFinal;
                $modelPagos->horapago=$arrayPagos[$i][1];
                //Calculo del importe final
                //$costoServicio=(0.0399*$arrayPagos[$i][2]+1.25)*1.21;
                //$comision=0.0326*$arrayPagos[$i][2];
                //$importeFinal=$arrayPagos[$i][2]-$costoServicio-$comision;
                $costoComision=0.096*$arrayPagos[$i][2];
                $importeFinal=$arrayPagos[$i][2]-$costoComision;
                $modelPagos->importetotal=(float)$arrayPagos[$i][2];
                $modelPagos->importe=number_format($importeFinal,2,".",",");
                $modelPagos->codigocomprobante=$arrayPagos[$i][3];
                $modelPagos->mediodepago=$arrayPagos[$i][4];
                $modelPagos->codigointerno=$arrayPagos[$i][5];
                //Division de codigo de referencia para obtener dni, mes y año
                $dt = str_split($arrayPagos[$i][3]);
                $aviso=$dt[0].$dt[1];
                $usuario=$dt[2];
                $fecha=$dt[3].$dt[4].$dt[5].$dt[6].$dt[7].$dt[8].$dt[9].$dt[10];
                $mes=$dt[0].$dt[1];
                $anio=$dt[2].$dt[3].$dt[4].$dt[5];

                $userActual=User::findOne($usuario);
                $modelPagos->user_id=$usuario;
                $modelPagos->aviso_id=$aviso;

                //Para evitar pagos duplicados primero se controla si el pago existe en la bd
                //$pagoRealizado=Pago::find(array('select' =>'idpago','condition'=>"codigointerno='".$arrayPagos[$i][5]."'",'limit'=>1));
                $pagoRealizado=Pago::findOne(['codigointerno'=>$arrayPagos[$i][5]]);

                if (count($pagoRealizado)==0){
                    if ($modelPagos->save()){
                        //Se actualiza el estado del cupon de pago correspondiente
                       /* $command = Yii::$app->db->createCommand();
                        $command->update('solicituddepago', array(
                            'solicituddepago.estado' => new CDbExpression(1),
                        ), 'codigo=' . $modelPagos->codigocomprobante);*/

                        //Se envía mail de confirmación al socio que su pago ha sido registrado.
                        if ($userActual->email!=NULL){

                            \Yii::$app->mailer->compose()
                                ->setFrom([\Yii::$app->params['supportEmail'] => 'Mundo MOTOR'])
                                ->setTo($userActual->email)
                                ->setSubject('Aviso de pago')
                                ->setHtmlBody('Estimado <strong>' . $userActual->username . '</strong>.<br>
								Le informamos que el pago correspondiente al aviso <strong>' . $aviso . '</strong> ha sido acreditado correctamente.<br><br>
								Atte.<br>Mundo MOTOR')
                                ->send();
                        }
                        echo "OK obtencion de pagos";
                    }else{
                        echo "ERROR  obtencion de pagos";
                        print_r($modelPagos->getErrors());
                    }
                }else{
                    echo "Sin pagos por el momento";
                }
            }
        }else{
            echo "ERROR";
        }
    }
}