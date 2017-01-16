<?php

namespace hiqdev\yii2\modules\pages\models;

use yii\base\InvalidConfigException;

class TwigPage extends AbstractPage
{
    public function render(array $params = [])
    {
        throw new InvalidConfigException('Not implemented twig handler.');
    }
}
