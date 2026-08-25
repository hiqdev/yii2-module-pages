<?php

namespace hiqdev\yii2\modules\pages\components;

use hipanel\helpers\ArrayHelper;
use hiqdev\yii2\modules\pages\interfaces\PageInterface;
use Yii;
use yii\helpers\Inflector;

/**
 * Class AdditionalPage
 * @package hiqdev\yii2\modules\pages\components
 */
class AdditionalPage implements PageInterface
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $dictionary;

    /**
     * @var string
     */
    private $pathToPage;

    /**
     * @var array
     */
    private $params;

    /**
     * AdditionalPage constructor.
     * @param string $label
     * @param array $label
     * @param array $params
     */
    public function __construct(string $label, array $params = [])
    {
        $this->label = $label;
        $this->dictionary = ArrayHelper::remove($params, 'dictionary');
        $this->pathToPage = ArrayHelper::remove($params, 'path');
        $this->params = ArrayHelper::remove($params, 'params', []);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return Inflector::slug($this->label);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return Yii::t($this->dictionary, $this->label);
    }

    /**
     * @param array $params
     * @return string
     */
    public function render(array $params = []): string
    {
        // 'path' is commonly configured as a Yii alias (e.g. '@hipanel/site/pages/...'),
        // which is_file() doesn't understand - it would always return false and silently
        // render an empty tab. Resolve it first; getAlias() is a no-op for plain paths.
        $path = Yii::getAlias($this->pathToPage, false);
        if ($path !== false && is_file($path)) {
            return Yii::$app->view->renderFile($path, array_merge($this->params, $params));
        }

        return '';
    }
}
