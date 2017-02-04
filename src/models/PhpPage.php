<?php

namespace hiqdev\yii2\modules\pages\models;

use hiqdev\yii2\modules\pages\Module;
use Yii;
use yii\base\InvalidConfigException;

class PhpPage extends AbstractPage
{
    public function render(array $params = [])
    {
        $path = Module::getInstance()->getLocalPath($this->path);

        return Yii::$app->getView()->renderFile($path);
    }
}
