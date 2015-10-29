<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "{{%publicacion}}".
 *
 * @property integer $idpublicacion
 * @property string $nombre
 * @property double $precio
 * @property integer $duracion
 * @property integer $exposicion
 * @property integer $cantfotos
 *
 * @property \common\models\Aviso[] $avisos
 */
class Publicacion extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%publicacion}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['precio'], 'number'],
            [['duracion', 'exposicion', 'cantfotos'], 'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpublicacion' => Yii::t('app', 'Define el tipo de publicacion: gratuita o paga.'),
            'nombre' => Yii::t('app', 'Nombre'),
            'precio' => Yii::t('app', 'Precio'),
            'duracion' => Yii::t('app', 'Duracion'),
            'exposicion' => Yii::t('app', 'Baja, media, alta y muy alta.'),
            'cantfotos' => Yii::t('app', 'Cantfotos'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvisos()
    {
        return $this->hasMany(\common\models\Aviso::className(), ['publicacion_id' => 'idpublicacion']);
    }
}
