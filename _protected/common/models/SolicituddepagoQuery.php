<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Solicituddepago]].
 *
 * @see Solicituddepago
 */
class SolicituddepagoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Solicituddepago[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Solicituddepago|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}