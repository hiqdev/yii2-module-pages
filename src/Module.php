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

use hiqdev\yii2\modules\pages\models\AbstractPage;
use hiqdev\yii2\modules\pages\models\PagesList;
use hiqdev\yii2\modules\pages\interfaces\StorageInterface;
use Yii;

class Module extends \yii\base\Module
{
    /** @var array|StorageInterface */
    protected $_storage;

    public static function getInstance(): Module
    {
        return Yii::$app->getModule('pages');
    }

    /**
     * This to use standard app pathes for views and layouts.
     * @return string
     */
    public function getViewPath()
    {
        return Yii::$app->getViewPath();
    }

    /**
     * @param string $pageName
     * @return AbstractPage|null
     * @throws \yii\base\InvalidConfigException
     */
    public function find(string $pageName): ?AbstractPage
    {
        $page = $this->getStorage()->getPage($pageName);

        return $page;
    }

    /**
     * @param string|null $id
     * @return PagesList|null
     * @throws \yii\base\InvalidConfigException
     */
    public function findList(string $id = null): ?PagesList
    {
        $list = $this->getStorage()->getList($id);

        return $list;
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getStorage(): StorageInterface
    {
        if (!is_object($this->_storage)) {
            $this->_storage = Yii::createObject($this->_storage);
        }

        return $this->_storage;
    }
}
