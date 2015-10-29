<?php

namespace frontend\models\base;

use Yii;

/**
 * This is the base model class for table "{{%multimedia}}".
 *
 * @property integer $idmultimedia
 * @property integer $bluetooth
 * @property integer $cargadorcd
 * @property integer $csatelital
 * @property integer $eauxiliar
 * @property integer $eusb
 * @property integer $etmemoria
 * @property integer $gps
 * @property integer $mlibres
 * @property integer $radiocassette
 * @property integer $rcd
 * @property integer $rmp3
 *
 * @property \frontend\models\Aviso[] $avisos
 */
class Multimedia extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%multimedia}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bluetooth', 'cargadorcd', 'csatelital', 'eauxiliar', 'eusb', 'etmemoria', 'gps', 'mlibres', 'radiocassette', 'rcd', 'rmp3','stactil','aviso_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
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
            'stactil' => Yii::t('app', 'Sistema tactil'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(\frontend\models\Aviso::className(), ['id' => 'aviso_id']);
    }
}
