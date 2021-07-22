<?php

namespace denis909\yii;

use yii\helpers\JSON;

abstract class BaseLogModel extends ActiveRecord
{

    public function getContext()
    {
        return JSON::decode($this->context_json, true);
    }

    public function setContext(array $array)
    {
        $this->context_json = JSON::encode($array);
    }

}