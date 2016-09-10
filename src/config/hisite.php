<?php

return [
    'components' => [
        'urlManager' => [
            'rules' => [
                'pages/<page:.*>' => 'pages/pages/render',
            ],
        ],
    ],
];
