<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "provincia".
 *
 * @property integer $idprovincia
 * @property string $nombre
 * @property integer $pais_idpais
 *
 * @property \common\models\Localidad[] $localidads
 * @property \common\models\Pais $paisIdpais
 */
class Provincia extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * 
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock 
     * 
     */
    public function optimisticLock() {
        return 'lock';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'pais_idpais'], 'required'],
            [['pais_idpais'], 'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idprovincia' => 'Idprovincia',
            'nombre' => 'Nombre',
            'pais_idpais' => 'Pais Idpais',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidads()
    {
        return $this->hasMany(\common\models\Localidad::className(), ['provincia_idprovincia' => 'idprovincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaisIdpais()
    {
        return $this->hasOne(\common\models\Pais::className(), ['idpais' => 'pais_idpais']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }

    
    /**
     * @inheritdoc
     * @return \app\models\ProvinciaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ProvinciaQuery(get_called_class());
    }
}
