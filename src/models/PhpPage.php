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

use hiqdev\yii2\modules\pages\interfaces\PageInterface;
use Yii;

class PhpPage extends AbstractPage implements PageInterface
{
    /**
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        $path = $this->storage->getLocalPath($this->path);

        return Yii::$app->getView()->renderFile($path, $params);
    }
}
