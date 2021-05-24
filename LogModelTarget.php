<?php

namespace denis909\yii;

use Yii;
use Exception;
use Throwable;
use denis909\yii\ModelException;

class LogModelTarget extends \yii\log\Target
{

    public $modelClass;

    public $db = 'db';

    public function export()
    {
        Assert::notEmpty($this->modelClass, get_called_class() . '::modelClass is empty.');

        foreach ($this->messages as $message)
        {
            list($text, $level, $category, $timestamp) = $message;
            
            if ($text instanceof Throwable || $text instanceof Exception)
            {
                $text = (string) $text;
            }

            $model = Yii::createObject([
                'class' => $this->modelClass,
                'level' => $level,
                'category' => $category,
                'log_time' => $timestamp,
                'prefix' => $this->getMessagePrefix($message)
            ]);

            if (is_array($text))
            {
                foreach($text as $key => $value)
                {
                    $model->$key = $value;
                }
            }
            else
            {
                $model->message = $text;
            }

            if (!$model->save())
            {
                throw new ModelException($model);
            }
        }
    }

}