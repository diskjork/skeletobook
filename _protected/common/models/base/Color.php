<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "{{%color}}".
 *
 * @property integer $idcolor
 * @property string $nombre
 *
 * @property \common\models\Aviso[] $avisos
 */
class Color extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%color}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 45],
            [['nombre'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcolor' => Yii::t('app', 'Idcolor'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(\common\models\Aviso::className(), ['color_idcolor' => 'idcolor']);
    }
}
