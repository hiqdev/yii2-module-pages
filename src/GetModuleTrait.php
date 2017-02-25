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
     * @var string|Module module name or the module object
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
