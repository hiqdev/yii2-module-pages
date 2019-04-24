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
use hiqdev\yii2\modules\pages\storage\StorageInterface;
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
     */
    public function find(string $pageName): ?AbstractPage
    {
        $page = $this->getStorage()->getPage($pageName);

        return $page;
    }

    public function findList()
    {
        $list = $this->getStorage()->getList();

        return $list;
    }

    public function setStorage($value)
    {
        $this->_storage = $value;
    }

    public function getStorage()
    {
        if (!is_object($this->_storage)) {
            $this->_storage = Yii::createObject($this->_storage);
        }

        return $this->_storage;
    }
}
