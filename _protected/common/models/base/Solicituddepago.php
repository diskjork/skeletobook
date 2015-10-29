<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "{{%solicituddepago}}".
 *
 * @property integer $idsolicitudepago
 * @property double $precio
 * @property integer $venc
 * @property string $codigo
 * @property string $concepto
 * @property string $moneda
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $codigodepago
 * @property string $expira
 * @property integer $estado
 * @property integer $aviso_id
 * @property integer $user_id
 * @property integer $publicacion_idpublicacion
 *
 * @property \common\models\Aviso $aviso
 * @property \common\models\Publicacion $publicacionIdpublicacion
 * @property \common\models\User $user
 */
class Solicituddepago extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;
    public $control=0;

    const ESTADO_IMP=1;
    const ESTADO_PAG=2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%solicituddepago}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['precio'], 'number'],
            [['venc', 'created_at', 'updated_at', 'estado', 'aviso_id', 'user_id', 'publicacion_id','control'], 'integer'],
            [['aviso_id', 'user_id', 'publicacion_id'], 'required'],
            [['codigo', 'concepto', 'moneda', 'codigodepago'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsolicitudepago' => Yii::t('app', 'Idsolicitudepago'),
            'precio' => Yii::t('app', 'Precio'),
            'venc' => Yii::t('app', 'Venc'),
            'codigo' => Yii::t('app', 'Codigo'),
            'concepto' => Yii::t('app', 'Concepto'),
            'moneda' => Yii::t('app', 'Moneda'),
            'codigodepago' => Yii::t('app', 'Codigo de pago'),
            'expira' => Yii::t('app', 'Vence'),
            'estado' => Yii::t('app', 'Estado'),
            'aviso_id' => Yii::t('app', 'Aviso ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'publicacion_id' => Yii::t('app', 'Publicacion'),
            'created_at' => Yii::t('app','Creado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAviso()
    {
        return $this->hasOne(\common\models\Aviso::className(), ['id' => 'aviso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicacion()
    {
        return $this->hasOne(\common\models\Publicacion::className(), ['idpublicacion' => 'publicacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
            /*[
                'class' => UUIDBehavior::className(),
                'column' => 'user_id',
            ],*/
        ];
    }

    
    /**
     * @inheritdoc
     * @return \common\models\SolicituddepagoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\SolicituddepagoQuery(get_called_class());
    }


    public function getStatusName($estado = null)
    {
        $estado = (empty($estado)) ? $this->estado : $estado ;

        if ($estado === self::ESTADO_IMP)
        {
            return Yii::t('app', 'Impago');
        }
        else
        {
            return Yii::t('app', 'Pagado');
        }
    }

    public function getStatusList()
    {
        $statusArray = [
            self::ESTADO_IMP     => Yii::t('app', 'Pendiente'),
            self::ESTADO_PAG => Yii::t('app', 'Pagado'),
        ];

        return $statusArray;
    }
}
