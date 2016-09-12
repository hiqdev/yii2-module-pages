<?php

return [
    'modules' => [
        'pages' => [
            'class' => \hiqdev\yii2\modules\pages\Module::class,
        ],
    ],
    'components' => [
        'urlManager' => [
            'rules' => [
                'pages/<page:.*>' => 'pages/render/index',
            ],
        ],
    ],
];
