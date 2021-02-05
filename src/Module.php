<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\modules\pages;

use hiqdev\yii2\modules\pages\interfaces\PageInterface;
use hiqdev\yii2\modules\pages\models\AbstractPage;
use hiqdev\yii2\modules\pages\models\PagesList;
use hiqdev\yii2\modules\pages\interfaces\StorageInterface;
use Yii;
use yii\base\InvalidConfigException;

class Module extends \yii\base\Module
{
    /** @var array|StorageInterface */
    protected $_storage;

    /** @var int */
    private $pageSize = 5;

    public static function getInstance(): Module
    {
        return Yii::$app->getModule('pages');
    }

    /**
     * This to use standard app paths for views and layouts.
     * @return string
     */
    public function getViewPath()
    {
        return Yii::$app->getViewPath();
    }

    /**
     * @param string $pageName
     * @return AbstractPage|null
     * @throws InvalidConfigException
     */
    public function find(string $pageName): ?PageInterface
    {
        return $this->getStorage()->getPage($pageName);
    }

    /**
     * @param string|null $id
     * @return PagesList|null
     * @throws InvalidConfigException
     */
    public function findList(string $id = null): ?PagesList
    {
        return $this->getStorage()->getList($id);
    }

    /**
     * @param array $storageConfig
     */
    public function setStorage($storageConfig): void
    {
        $this->_storage = $storageConfig;
    }

    /**
     * @return StorageInterface
     * @throws InvalidConfigException
     */
    public function getStorage(): StorageInterface
    {
        if (!is_object($this->_storage)) {
            $this->_storage = Yii::createObject(array_merge($this->_storage, ['pages' => $this]));
        }

        return $this->_storage;
    }

    /**
     * @param int $pageSize
     */
    public function setPageSize(int $pageSize): void
    {
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
