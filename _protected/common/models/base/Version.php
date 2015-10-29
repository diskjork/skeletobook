<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "{{%version}}".
 *
 * @property integer $idversion
 * @property string $nombre
 * @property integer $modelo_idmodelo
 *
 * @property \common\models\Aviso[] $avisos
 * @property \common\models\Modelo $modeloIdmodelo
 */
class Version extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%version}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'modelo_idmodelo'], 'required'],
            [['modelo_idmodelo'], 'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idversion' => 'Idversion',
            'nombre' => 'Nombre',
            'modelo_idmodelo' => 'Modelo Idmodelo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(\frontend\models\Aviso::className(), ['version_idversion' => 'idversion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeloIdmodelo()
    {
        return $this->hasOne(\common\models\Modelo::className(), ['idmodelo' => 'modelo_idmodelo']);
    }

    
    /**
     * @inheritdoc
     * @return \common\models\VersionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\VersionQuery(get_called_class());
    }
}
