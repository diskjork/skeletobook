<?php

namespace frontend\models\base;

use Yii;

/**
 * This is the base model class for table "{{%exterior}}".
 *
 * @property integer $idexterior
 * @property integer $pequipaje
 * @property integer $fxenon
 * @property integer $luneta
 * @property integer $lfaros
 * @property integer $aleacion
 * @property integer $tdescapota
 * @property integer $paragolpes
 * @property integer $polarizados
 *
 * @property \frontend\models\Aviso[] $avisos
 */
class Exterior extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%exterior}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idexterior'], 'required'],
            [['idexterior', 'pequipaje', 'fxenon', 'luneta', 'lfaros', 'aleacion', 'tdescapota', 'paragolpes', 'polarizados','pcarter','etecho','aviso_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idexterior' => Yii::t('app', 'Idexterior'),
            'pequipaje' => Yii::t('app', 'Barra porta equipaje'),
            'fxenon' => Yii::t('app', 'Faros de xenón'),
            'luneta' => Yii::t('app', 'Limpia/lava luneta'),
            'lfaros' => Yii::t('app', 'Limpia/lava faros'),
            'aleacion' => Yii::t('app', 'Llantas de aleación'),
            'tdescapota' => Yii::t('app', 'Techo descapotable'),
            'paragolpes' => Yii::t('app', 'Paragolpes color carrocería'),
            'polarizados' => Yii::t('app', 'Polarizados'),
            'pcarter' => Yii::t('app', 'Protector de carter'),
            'etecho' => Yii::t('app', 'Escotilla de techo'),
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
