<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages\interfaces;

use hiqdev\yii2\modules\pages\models\AbstractPage;

interface StorageInterface
{
    public function getPage(string $pageName): ?AbstractPage;
}
