<?php

namespace hiqdev\yii2\modules\pages;

use Yii;

class Module extends \yii\base\Module
{
    protected $_storage;

    public $extensions = ['md', 'php', 'twig'];

    public function find($page)
    {
        if ($this->getStorage()->has($page)) {
            return $page;
        }

        foreach ($this->extensions as $extension) {
            $path = $page . '.' . $extension;
            if ($this->getStorage()->has($path)) {
                return $path;
            }
        }

        return null;
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
