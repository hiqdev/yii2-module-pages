<?php

namespace hiqdev\yii2\modules\pages\components;

use Yii;
use yii\base\Component;

class AdditionalPages extends Component
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @return object
     */
    public static function instantiate(): object
    {
        return Yii::$container->get(static::class);
    }

    /**
     * @return AdditionalPage[]
     */
    public function getPages(): array
    {
        $pages = Yii::$app->params['module.pages.additional.rules'];

        if (empty($pages)) {
            return [];
        }

        $list = [];
        foreach ($pages as $label => $params) {
            $list[] = new AdditionalPage($label, array_merge($params, $this->params));
        }

        return $list;
    }
}
