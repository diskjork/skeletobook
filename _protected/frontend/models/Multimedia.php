<?php

namespace frontend\models;

use Yii;
use \frontend\models\base\Multimedia as BaseMultimedia;

/**
 * This is the model class for table "multimedia".
 */
class Multimedia extends BaseMultimedia
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'idmultimedia' => Yii::t('app', 'Idmultimedia'),
            'bluetooth' => Yii::t('app', 'Bluetooth'),
            'cargadorcd' => Yii::t('app', 'Cargador de CD'),
            'csatelital' => Yii::t('app', 'Comando satelital de stereo'),
            'eauxiliar' => Yii::t('app', 'Entrada auxiliar'),
            'eusb' => Yii::t('app', 'Entrada USB'),
            'etmemoria' => Yii::t('app', 'Tarjeta de memoria'),
            'gps' => Yii::t('app', 'Gps'),
            'mlibres' => Yii::t('app', 'Manos libres'),
            'radiocassette' => Yii::t('app', 'Radio AM/FM con pasacassette'),
            'rcd' => Yii::t('app', 'Radio CD'),
            'rmp3' => Yii::t('app', 'Radio MP3'),
        ];
    }
}
