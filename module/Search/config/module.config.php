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
        'aliases' => [
            'categories' => 'application-categories',
        ],
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
                    'list' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/list[/]',
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
