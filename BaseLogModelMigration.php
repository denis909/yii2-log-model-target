<?php

namespace denis909\yii;

use Webmozart\Assert\Assert;
use yii\helpers\ArrayHelper;

abstract class BaseLogModelMigration extends Migration
{

    public $tableName;

    abstract public function getTableColumns() : array;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Assert::notEmpty($this->tableName, get_called_class() . '::tableName is empty.');

        $columns = ArrayHelper::merge([
            'id' => $this->bigPrimaryKey(),
            'level' => $this->integer(),
            'category' => $this->string(),
            'log_time' => $this->double(),
            'prefix' => $this->text(),
            'message' => $this->text(65535)->defaultValue(null)
        ], $this->getTableColumns());

        $this->createTable($this->tableName, $columns);
    
        $this->afterUp();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->beforeDown();

        Assert::notEmpty($this->tableName, get_called_class() . '::tableName is empty.');

        $this->dropTable($this->tableName);
    }

    public function afterUp()
    {
    }

    public function beforeDown()
    {
    }

}