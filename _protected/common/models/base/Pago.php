<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "{{%pago}}".
 *
 * @property integer $idpago
 * @property double $importe
 * @property string $fechapago
 * @property string $horapago
 * @property string $codigocomprobante
 * @property string $mediodepago
 * @property string $codigointerno
 * @property integer $created_at
 * @property double $importetotal
 * @property integer $aviso_id
 * @property integer $user_id
 *
 * @property \common\models\Aviso $aviso
 * @property \common\models\User $user
 */
class Pago extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pago}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['importe', 'importetotal'], 'number'],
            [['fechapago', 'horapago'], 'safe'],
            [['aviso_id', 'user_id'], 'required'],
            [['created_at', 'aviso_id', 'user_id'], 'integer'],
            [['codigocomprobante', 'mediodepago'], 'string', 'max' => 45],
            [['codigointerno'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpago' => Yii::t('app', 'Idpago'),
            'importe' => Yii::t('app', 'Importe'),
            'fechapago' => Yii::t('app', 'Fechapago'),
            'horapago' => Yii::t('app', 'Horapago'),
            'codigocomprobante' => Yii::t('app', 'Codigocomprobante'),
            'mediodepago' => Yii::t('app', 'Mediodepago'),
            'codigointerno' => Yii::t('app', 'Codigointerno'),
            'importetotal' => Yii::t('app', 'Importetotal'),
            'aviso_id' => Yii::t('app', 'Aviso ID'),
            'user_id' => Yii::t('app', 'User ID'),
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
           /* [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
           /* [
                'class' => UUIDBehavior::className(),
                'column' => 'user_id',
            ],*/
        ];
    }

    
    /**
     * @inheritdoc
     * @return \common\models\PagoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\PagoQuery(get_called_class());
    }
}
