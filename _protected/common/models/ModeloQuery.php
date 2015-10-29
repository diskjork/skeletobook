<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Modelo]].
 *
 * @see Modelo
 */
class ModeloQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Modelo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Modelo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}