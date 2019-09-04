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
        $this->params = $params;
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
        return Yii::$app->view->renderFile($this->pathToPage, array_merge($this->params, $params));
    }
}
