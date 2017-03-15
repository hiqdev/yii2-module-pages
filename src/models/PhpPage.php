<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages\models;

use hiqdev\yii2\modules\pages\Module;
use Yii;

class PhpPage extends AbstractPage
{
    public function render(array $params = [])
    {
        $path = Module::getInstance()->getLocalPath($this->path);

        return Yii::$app->getView()->renderFile($path, $params);
    }
}
