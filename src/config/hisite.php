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
        'i18n' => [
            'translations' => [
                'hiqdev:pages' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hiqdev/com/messages',
                ],
            ],
        ],
    ],
];
