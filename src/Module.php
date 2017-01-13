<?php

namespace hiqdev\yii2\modules\pages;

use Yii;

class Module extends \yii\base\Module
{
    protected $_storage;

    public $handlers = [
        'md'    => \hiqdev\yii2\modules\pages\models\MarkdownPage::class,
        'php'   => \hiqdev\yii2\modules\pages\models\PhpPage::class,
        'twig'  => \hiqdev\yii2\modules\pages\models\TwigPage::class,
    ];

    /**
     * This to use standard app pathes for views and layouts.
     * @return string
     */
    public function getViewPath()
    {
        return Yii::$app->getViewPath();
    }

    public function find($page)
    {
        if ($this->getStorage()->has($page)) {
            return $page;
        }

        foreach (array_keys($this->handlers) as $extension) {
            $path = $page . '.' . $extension;
            if ($this->getStorage()->has($path)) {
                return $path;
            }
        }

        return null;
    }

    public function getMetadata($page)
    {
        return $this->getStorage()->getMetadata($page);
    }

    public function localPath($path)
    {
        /// XXX: works for Local Filesystem only
        /// TODO: for others copying to be implemented
        return $this->getStorage()->path . '/' . $path;
    }

    /**
     * Reads given path as array of already rtrimmed lines.
     */
    public function readArray($path)
    {
        /// XXX: performance
        return preg_split("/((\r?\n)|(\r\n?))/", $this->getStorage()->read($path));
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
