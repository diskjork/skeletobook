<?php

namespace frontend\models;

use Yii;
use \frontend\models\base\Seguridad as BaseSeguridad;

/**
 * This is the model class for table "seguridad".
 */
class Seguridad extends BaseSeguridad
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'idseguridad' => Yii::t('app', 'Idseguridad'),
            'aconductor' => Yii::t('app', 'Airbag conductor'),
            'aacompa' => Yii::t('app', 'Airbag acompanante'),
            'alateral' => Yii::t('app', 'Airbag laterales'),
            'atrasero' => Yii::t('app', 'Airbag trasero'),
            'acortina' => Yii::t('app', 'Airbag de cortina'),
            'alarma' => Yii::t('app', 'Alarma'),
            'avelocidad' => Yii::t('app', 'Alarma de limite de velocidad'),
            'apoyacabeza' => Yii::t('app', 'Apoya cabeza asientos traseros'),
            'cierremov' => Yii::t('app', 'Cierre de puertas automático en movimiento'),
            'cinerciales' => Yii::t('app', 'Cinturones inerciales'),
            'ctraccion' => Yii::t('app', 'Control de tracción'),
            'esp' => Yii::t('app', 'Control de estabilidad (ESP)'),
            'dtraccion' => Yii::t('app', 'Doble tracción'),
            'fantiniebla' => Yii::t('app', 'Faros antiniebla'),
            'fabs' => Yii::t('app', 'Frenos ABS'),
            'afrenado' => Yii::t('app', 'Asistencia electronica de frenado'),
            'fdiscot' => Yii::t('app', 'Frenos a disco traseros'),
            'imotor' => Yii::t('app', 'Inmovilizador de motor'),
            'sestacionamiento' => Yii::t('app', 'Sensores de estacionamiento'),
            'slluvia' => Yii::t('app', 'Sensor de lluvia'),
            'tluzstop' => Yii::t('app', 'Tercer luz de stop'),
            'llavecod' => Yii::t('app', 'Llave codificada'),
            'aluces' => Yii::t('app', 'Alarma de luces'),
            'isofix' => Yii::t('app', 'Sistema isofix'),
        ];
    }
}
