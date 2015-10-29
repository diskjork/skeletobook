<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "{{%modelo}}".
 *
 * @property integer $idmodelo
 * @property string $nombre
 * @property integer $marca_idmarca
 *
 * @property \common\models\Marca $marcaIdmarca
 * @property \common\models\Version[] $versions
 */
class Modelo extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%modelo}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marca_idmarca'], 'required'],
            [['marca_idmarca'], 'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idmodelo' => Yii::t('app', 'Idmodelo'),
            'nombre' => Yii::t('app', 'Nombre'),
            'marca_idmarca' => Yii::t('app', 'Marca Idmarca'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcaIdmarca()
    {
        return $this->hasOne(\common\models\Marca::className(), ['idmarca' => 'marca_idmarca']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(\common\models\Version::className(), ['modelo_idmodelo' => 'idmodelo']);
    }

    
    /**
     * @inheritdoc
     * @return \common\models\ModeloQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\ModeloQuery(get_called_class());
    }
}
