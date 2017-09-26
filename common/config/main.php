<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
          'showScriptName'  => false,
          'enablePrettyUrl' => true
        ],
    ],
];
