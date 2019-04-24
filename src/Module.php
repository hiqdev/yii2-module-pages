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
use Yii;

class Module extends \yii\base\Module
{
    protected $_storage;

    public $pageClasses = [
        ''      => \hiqdev\yii2\modules\pages\models\OtherPage::class,
        'md'    => \hiqdev\yii2\modules\pages\models\MarkdownPage::class,
        'php'   => \hiqdev\yii2\modules\pages\models\PhpPage::class,
        'twig'  => \hiqdev\yii2\modules\pages\models\TwigPage::class,
    ];

    public function findPageClass($extension)
    {
        if (empty($this->pageClasses[$extension])) {
            $extension = '';
        }

        return $this->pageClasses[$extension];
    }

    public static function getInstance()
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

    public function find($pageName): ?AbstractPage
    {
        $page = $this->getStorage()->getPage($pageName);

        return $page;
    }

    public function findList()
    {
        $list = $this->getStorage()->getList();

        return $list;
    }

    /**
     * Reads given path as array of already rtrimmed lines.
     */
    public function readArray($path)
    {
        /// XXX: performance
        return preg_split("/((\r?\n)|(\r\n?))/", $this->getStorage()->read($path));
    }

    public function getLocalPath($path)
    {
        /// XXX: works for Local Filesystem only
        /// TODO: implement copying for others
        return $this->getStorage()->path . '/' . $path;
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
