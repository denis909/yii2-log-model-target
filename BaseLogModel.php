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

    public function getMessage() : string
    {
        return strtr($this->message, $this->context);
    }

    public function getCreated()
    {
        $time_segments = explode('.', $this->log_time);

        return date('Y-m-d H:i:s', $time_segments[0]);
    }

}