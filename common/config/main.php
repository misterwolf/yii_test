<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
          'showScriptName'  => false,
          'enablePrettyUrl' => true,
          'enableStrictParsing' => false,
          'rules' => [
              // threads
              '<controller:(threads)>/create'   => '<controller>/create',
              '<controller:(threads)>/<id:\d+>/<action:(update|delete)>' => '<controller>/<action>',
              '<controller:(threads)>/<id:\d+>' => '<controller>/view',
              '<controller:(threads)>'         => '<controller>/index',

              // posts:
              '<controller:(threads)>/<thread_id:\d+>/posts' => 'posts/index',
              '<controller:(threads)>/<thread_id:\d+>/posts/create' => 'posts/create',

              '<controller:(threads)>/<thread_id:\d+>/posts/<post_id:\d+>' => 'posts/view',
              'posts/<post_id:\d+>' => 'posts/view',
              'posts/<action>' => 'threads/index',
          ]
        ],
    ],
];
