<?php

namespace frontend\models\base;

use Yii;

/**
 * This is the base model class for table "{{%confort}}".
 *
 * @property integer $idconfort
 * @property integer $aireacondicionado
 * @property integer $aperturabaul
 * @property integer $aregulable
 * @property integer $atraserorebatible
 * @property integer $aelectricos
 * @property integer $atermico
 * @property integer $acuero
 * @property integer $abrazocentral
 * @property integer $ccentralizado
 * @property integer $ccentralizadodist
 * @property integer $climatizador
 * @property integer $computadora
 * @property integer $cveloccrucero
 * @property integer $eelectricos
 * @property integer $fregulainterior
 * @property integer $tsolar
 * @property integer $velectricodel
 * @property integer $velectricotra
 * @property integer $vregulable
 * @property integer $aviso_id
 *
 * @property \frontend\models\Aviso $aviso
 */
class Confort extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%confort}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aireacondicionado', 'aperturabaul', 'aregulable', 'atraserorebatible', 'aelectricos', 'atermico', 'acuero', 'abrazocentral', 'ccentralizado', 'ccentralizadodist', 'climatizador', 'computadora', 'cveloccrucero', 'eelectricos', 'fregulainterior', 'tsolar', 'velectricodel', 'velectricotra', 'vregulable','scabina','ducha', 'aviso_id'], 'integer'],
            [['aviso_id'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idconfort' => Yii::t('app', 'Idconfort'),
            'aireacondicionado' => Yii::t('app', 'Aire acondicionado'),
            'aperturabaul' => Yii::t('app', 'Apertura remota de baul'),
            'aregulable' => Yii::t('app', 'Asiento regulable en altura'),
            'atraserorebatible' => Yii::t('app', 'Asiento trasero rebatible'),
            'aelectricos' => Yii::t('app', 'Asientos eléctricos'),
            'atermico' => Yii::t('app', 'Asientos termicos'),
            'acuero' => Yii::t('app', 'Asientos de cuero'),
            'abrazocentral' => Yii::t('app', 'Apoyabrazos central delantero'),
            'ccentralizado' => Yii::t('app', 'Cierre centralizado'),
            'ccentralizadodist' => Yii::t('app', 'Cierre centralizado a distancia'),
            'climatizador' => Yii::t('app', 'Climatizador automatico'),
            'computadora' => Yii::t('app', 'Computadora de abordo'),
            'cveloccrucero' => Yii::t('app', 'Control de velocidad crucero'),
            'eelectricos' => Yii::t('app', 'Espejos exteriores electricos'),
            'fregulainterior' => Yii::t('app', 'Faros regulables desde el interior'),
            'tsolar' => Yii::t('app', 'Techo solar corredizo'),
            'velectricodel' => Yii::t('app', 'Vidrios eléctricos delanteros'),
            'velectricotra' => Yii::t('app', 'Vidrios eléctricos traseros'),
            'vregulable' => Yii::t('app', 'Volante regulable'),
            'scabina' => Yii::t('app', 'Suspensión cabina'),
            'ducha' => Yii::t('app', 'Baño con ducha'),
            'aviso_id' => Yii::t('app', 'Aviso ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAviso()
    {
        return $this->hasOne(\frontend\models\Aviso::className(), ['id' => 'aviso_id']);
    }
}
