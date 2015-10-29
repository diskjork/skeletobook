<?php

namespace frontend\models;

use Yii;
use \frontend\models\base\Exterior as BaseExterior;

/**
 * This is the model class for table "exterior".
 */
class Exterior extends BaseExterior
{
    /**
     * @inheritdoc
     */
    public function attributeHints()
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
        ];
    }
}
