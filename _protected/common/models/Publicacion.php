<?php

namespace common\models;

use Yii;
use \common\models\base\Publicacion as BasePublicacion;

/**
 * This is the model class for table "publicacion".
 */
class Publicacion extends BasePublicacion
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
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
}
