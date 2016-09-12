<?php

namespace hiqdev\yii2\modules\pages;

use Yii;

/**
 * Get module trait.
 * Provides get/set module methods.
 *
 * @property Module $module The module to be used, can be found by default.
 */
trait GetModuleTrait
{
    protected $_module = 'pages';

    /**
     * Setter for module.
     * @var string|Module module name or the module object.
     */
    public function setModule($module)
    {
        $this->_module = $module;
    }

    /**
     * Getter for module.
     * @return Module
     */
    public function getModule()
    {
        if (!is_object($this->_module)) {
            $this->_module = Yii::$app->getModule($this->_module);
        }

        return $this->_module;
    }
}
