<?php
/**
 * Yii2 Pages Module
 *
 * @link      https://github.com/hiqdev/yii2-module-pages
 * @package   yii2-module-pages
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

return [
    'modules' => [
        'pages' => [
            'class' => \hiqdev\yii2\modules\pages\Module::class,
        ],
    ],
    'components' => [
        'view' => [
            'renderers' => [
                'twig' => [
                    'class' => \yii\twig\ViewRenderer::class,
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => \yii\helpers\Html::class,
                    ],
                ],
            ],
        ],
        'urlManager' => [
            'rules' => [
                'pages' => 'pages/render/list',
                'pages/list' => 'pages/render/list',
                'pages/list/<id:.*>' => 'pages/render/list',
                'pages/<page:.*>' => 'pages/render/index',

                'articles' => 'articles/render/list',
                'articles/list' => 'articles/render/list',
                'articles/list/<name:.*>' => 'articles/render/list',
                'articles/<page:.*>' => 'articles/render/index',
            ],
        ],
        'i18n' => [
            'translations' => [
                'hiqdev:pages' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hiqdev/yii2/modules/pages/messages',
                ],
            ],
        ],
    ],
];
