<?php
return [
    'controllers' => [
    	'invokables' => [
            // test controller has no dependencies
    		'search-test-controller' => 'Search\Controller\TestController',
    	],
        'factories' => [
        	// search controller depends on the database
            'search-controller' => 'Search\Factory\SearchControllerFactory',
        ],
    ],
	'service_manager' => [
		'invokables' => [
			'search-form' => 'Search\Form\SearchForm',
			'search-form-filter' => 'Search\Form\SearchFormFilter',
		],
		'factories' => [
			'search-listings-table' => 'Search\Factory\ListingsTableFactory',
		],
	],
    'router' => [
        'routes' => [
            'search' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/search',
                    'defaults' => [
                        'controller'    => 'search-controller',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/[:action]',
                            'constraints' => [
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Search' => __DIR__ . '/../view',
        ],
    ],
];
