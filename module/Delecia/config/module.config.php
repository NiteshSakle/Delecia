<?php

namespace Delecia;

use Zend\Router\Http\Segment;

return [
	'router' => [
        'routes' => [
            'login' => [
                'type'    => segment::class,
                 'options' =>[
                    'route'    => '/login[/:action][/:id]',
                    'constraints' => [
						'action' => 'register',
                        'id' => '[a-zA-Z0-9_-]*'
					],
                    'defaults' => [
                           'controller' => 'Delecia\Controller\LoginController',

					],
                ],
            ],       
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'group-rest' => __DIR__ . '/../view',
        ],	
	'strategies' => [
		'ViewJsonStrategy'
    ],
	],
];
