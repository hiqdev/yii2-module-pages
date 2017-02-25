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

use yii\base\InvalidConfigException;

class TwigPage extends AbstractPage
{
    public function render(array $params = [])
    {
        throw new InvalidConfigException('Not implemented twig handler.');
    }
}
