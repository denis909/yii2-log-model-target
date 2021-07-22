<?php

namespace denis909\yii;

use Yii;
use Exception;
use Throwable;

class LogModelTarget extends \yii\log\Target
{

    public $modelClass;

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
                $context = $text;

                foreach($context as $key => $value)
                {
                    if (!$model->hasAttribute($key))
                    {
                        continue;
                    }

                    $model->$key = $value;
                
                    unset($context[$key]);
                }

                if ($model->hasAttribute('context') || $model->hasProperty('context'))
                {
                    $model->context = $context;
                }
            }
            else
            {
                $model->message = $text;
            }

            $model->saveOrFail();
        }
    }

}