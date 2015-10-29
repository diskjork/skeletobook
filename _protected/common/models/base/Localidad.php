<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "localidad".
 *
 * @property integer $idlocalidad
 * @property string $nombre
 * @property string $codigopostal
 * @property integer $provincia_idprovincia
 *
 * @property \common\models\Provincia $provinciaIdprovincia
 * @property \common\models\User[] $users
 */
class Localidad extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'localidad';
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
            [['nombre', 'provincia_idprovincia'], 'required'],
            [['provincia_idprovincia'], 'integer'],
            [['nombre', 'codigopostal'], 'string', 'max' => 45],
            [['codigopostal'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlocalidad' => 'Idlocalidad',
            'nombre' => 'Nombre',
            'codigopostal' => 'Codigopostal',
            'provincia_idprovincia' => 'Provincia Idprovincia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinciaIdprovincia()
    {
        return $this->hasOne(\common\models\Provincia::className(), ['idprovincia' => 'provincia_idprovincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(\common\models\User::className(), ['localidad_idlocalidad' => 'idlocalidad']);
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
     * @return \app\models\LocalidadQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\LocalidadQuery(get_called_class());
    }
}
