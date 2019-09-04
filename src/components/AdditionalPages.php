<?php

namespace hiqdev\yii2\modules\pages\components;

use Yii;
use yii\base\Component;

class AdditionalPages extends Component
{
    /**
     * @return AdditionalPage[]
     */
    public static function getPages(): array
    {
        $pages = Yii::$app->params['module.pages.additional.rules'];

        if (empty($pages)) {
            return [];
        }

        $list = [];
        foreach ($pages as $label => $params) {
            $list[] = new AdditionalPage($label, array_merge($params, [
                'registrarName' => Yii::$app->params['organization.name'],
                'registrarUrl' => Yii::$app->params['organization.url'],
            ]));
        }

        return $list;
    }
}
