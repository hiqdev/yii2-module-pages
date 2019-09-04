<?php

namespace hiqdev\yii2\modules\pages\components;

use Yii;
use yii\base\Component;

class AdditionalPages extends Component
{
    /**
     * Global params
     * @var array
     */
    public $params = [];

    /**
     * @var array
     */
    public $pages = [];

    /**
     * @param string $alias
     * @return object
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public static function instantiate(string $alias): object
    {
        return Yii::$container->get($alias);
    }

    /**
     * @return AdditionalPage[]
     */
    public function getPages(): array
    {
        if (empty($this->pages)) {
            return [];
        }

        $list = [];
        foreach ($this->pages as $label => $params) {
            $list[] = new AdditionalPage($label, array_merge($params, $this->params));
        }

        return $list;
    }
}
