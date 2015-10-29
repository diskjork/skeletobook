<?php

namespace frontend\models\base;

use Yii;

/**
 * This is the base model class for table "{{%seguridad}}".
 *
 * @property integer $idseguridad
 * @property integer $aconductor
 * @property integer $aacompa
 * @property integer $alateral
 * @property integer $atrasero
 * @property integer $acortina
 * @property integer $alarma
 * @property integer $avelocidad
 * @property integer $apoyacabeza
 * @property integer $cierremov
 * @property integer $cinerciales
 * @property integer $ctraccion
 * @property integer $esp
 * @property integer $dtraccion
 * @property integer $fantiniebla
 * @property integer $fabs
 * @property integer $afrenado
 * @property integer $fdiscot
 * @property integer $imotor
 * @property integer $sestacionamiento
 * @property integer $slluvia
 * @property integer $tluzstop
 * @property integer $llavecod
 * @property integer $aluces
 * @property integer $isofix
 *
 * @property \frontend\models\Aviso[] $avisos
 */
class Seguridad extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seguridad}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aconductor', 'aacompa', 'alateral', 'atrasero', 'acortina', 'alarma', 'avelocidad', 'apoyacabeza', 'cierremov', 'cinerciales', 'ctraccion', 'esp', 'dtraccion', 'fantiniebla', 'fabs', 'afrenado', 'fdiscot', 'imotor', 'sestacionamiento', 'slluvia', 'tluzstop', 'llavecod', 'aluces', 'isofix','aviso_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idseguridad' => Yii::t('app', 'Idseguridad'),
            'aconductor' => Yii::t('app', 'Airbag conductor'),
            'aacompa' => Yii::t('app', 'Airbag acompañante'),
            'alateral' => Yii::t('app', 'Airbag laterales'),
            'atrasero' => Yii::t('app', 'Airbag trasero'),
            'acortina' => Yii::t('app', 'Airbag de cortina'),
            'alarma' => Yii::t('app', 'Alarma'),
            'avelocidad' => Yii::t('app', 'Alarma de limite de velocidad'),
            'apoyacabeza' => Yii::t('app', 'Apoya cabeza asientos traseros'),
            'cierremov' => Yii::t('app', 'Cierre automático en movimiento'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(\frontend\models\Aviso::className(), ['id' => 'aviso_id']);
    }
}
