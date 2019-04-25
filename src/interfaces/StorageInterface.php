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

use hiqdev\yii2\modules\pages\models\PagesList;

interface StorageInterface
{
    /**
     * @param string $pageName
     * @return PageInterface|null
     */
    public function getPage(string $pageName): ?PageInterface;

    /**
     * @param string|null $listName
     * @return PagesList|null
     */
    public function getList(string $listName = null): ?PagesList;
}
