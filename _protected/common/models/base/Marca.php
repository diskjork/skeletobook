<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "{{%marca}}".
 *
 * @property integer $idmarca
 * @property string $nombre
 *
 * @property \common\models\Modelo[] $modelos
 */
class Marca extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    //Tipo
    const AUTO = 1;
    const CAMION = 2;
    const CASARODANTE = 3;
    const MOTO = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%marca}}';
    }

    /**
     * 
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock 
     * 
     */
    /*public function optimisticLock() {
        return 'idmarca';
    }*/
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','tipovehiculo'], 'required'],
            [['tipovehiculo'],'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idmarca' => 'Idmarca',
            'nombre' => 'Nombre',
            'tipovehiculo' =>'Tipo de vehiculo'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelos()
    {
        return $this->hasMany(\common\models\Modelo::className(), ['marca_idmarca' => 'idmarca']);
    }


    /**
     * @inheritdoc
     * @return \common\models\MarcaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\MarcaQuery(get_called_class());
    }

    //TIPO DE VEHICULO
    public function getTipoVehiculo($tipovehiculo = null)
    {
        $tipovehiculo = (empty($tipovehiculo)) ? $this->tipovehiculo : $tipovehiculo ;

        if ($tipovehiculo === self::AUTO)
        {
            return Yii::t('app', 'Auto/Camioneta');
        }
        elseif ($tipovehiculo === self::CAMION)
        {
            return Yii::t('app', 'Camion');
        }
        elseif ($tipovehiculo === self::CASARODANTE)
        {
            return Yii::t('app', 'Casilla Rodante');
        }
        else
        {
            return Yii::t('app', 'Moto');
        }
    }
    public function getTipoVehiculoList()
    {
        $statusArray = [
            self::AUTO     => Yii::t('app', 'Auto/Camioneta'),
            self::CAMION     => Yii::t('app', 'Camion'),
            self::CASARODANTE     => Yii::t('app', 'Casilla Rodante'),
            self::MOTO     => Yii::t('app', 'Moto'),
        ];

        return $statusArray;
    }
}
