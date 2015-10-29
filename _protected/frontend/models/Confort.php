<?php

namespace frontend\models;

use Yii;
use \frontend\models\base\Confort as BaseConfort;

/**
 * This is the model class for table "confort".
 */
class Confort extends BaseConfort
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'idconfort' => Yii::t('app', 'Idconfort'),
            'aireacondicionado' => Yii::t('app', 'Aireacondicionado'),
            'aperturabaul' => Yii::t('app', 'Apertura remota de baul'),
            'aregulable' => Yii::t('app', 'Asiento conductor regulable en altura'),
            'atraserorebatible' => Yii::t('app', 'Asiento trasero rebatible'),
            'aelectricos' => Yii::t('app', 'Asientos eléctricos'),
            'atermico' => Yii::t('app', 'Asientos termicos'),
            'acuero' => Yii::t('app', 'Asientos de cuero'),
            'abrazocentral' => Yii::t('app', 'Apoyabrazos central delantero'),
            'ccentralizado' => Yii::t('app', 'Cierre centralizado'),
            'ccentralizadodist' => Yii::t('app', 'Cierre centralizado con mando a distancia'),
            'climatizador' => Yii::t('app', 'Climatizador automatico'),
            'computadora' => Yii::t('app', 'Computadora de abordo'),
            'cveloccrucero' => Yii::t('app', 'Control de velocidad crucero'),
            'eelectricos' => Yii::t('app', 'Espejos exteriores electricos'),
            'fregulainterior' => Yii::t('app', 'Faros regulables desde el interior'),
            'tsolar' => Yii::t('app', 'Techo solar corredizo'),
            'velectricodel' => Yii::t('app', 'Vidrios eléctricos delanteros'),
            'velectricotra' => Yii::t('app', 'Vidrios eléctricos traseros'),
            'vregulable' => Yii::t('app', 'Volante regulable'),
            'aviso_id' => Yii::t('app', 'Aviso ID'),
        ];
    }
}
