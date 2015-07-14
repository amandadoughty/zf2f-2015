<?php
return [
    'controllers' => [
        'factories' => [
            'market-index-controller' => 'Market\Factory\IndexControllerFactory',
            'market-view-controller'  => 'Market\Factory\ViewControllerFactory',
            'market-post-controller'  => 'Market\Factory\PostControllerFactory',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'market-form-post'      => 'Market\Factory\PostFormFactory',
            'market-filter-post'    => 'Market\Factory\PostFilterFactory',
            'market-listings-table' => 'Market\Factory\ListingsTableFactory',
        ],
        'services' => [
            'market-expire-days' => [ 
                0  => 'Never', 
                1  => 'Tomorrow', 
                7  => 'Week', 
                30 => 'Month'
            ],
            'market-cities' => [
                'Paris,FR'     => 'Paris',
                'London,UK'    => 'London',
                'New York,USA' => 'New York',
                'Berlin,DE'    => 'Berlin'
            ],
            'market-captcha-options' => [
                'expiration' => 300,
                'font'		=> '/usr/share/fonts/truetype/freefont/FreeSansBold.ttf',
                'fontSize'	=> 24,
                'height'	=> 50,
                'width'		=> 200,
                'imgDir'	=> __DIR__ . '/../../../public/captcha',
                'imgUrl'	=> '/captcha',    	
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/',
                    'defaults' => [
                        'controller'    => 'market-index-controller',
                        'action'        => 'index',
                    ],
                ],
            ],
            'market' => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/market',
                    'defaults' => [
                        'controller'    => 'market-index-controller',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'view' => [
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route'    => '/view',
                            'defaults' => [
                                'controller'    => 'market-view-controller',
                                'action'        => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'index' => [
                                'type'    => 'Zend\Mvc\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/main[/:category]',
                                    'defaults' => [
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'category' => '[a-zA-Z]*',
                                    ],
                                ],
                            ],
                            'item' => [
                                'type'    => 'Zend\Mvc\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/item[/:itemId]',
                                    'defaults' => [
                                        'action'        => 'item',
                                    ],
                                    'constraints' => [
                                        'itemId' => '[0-9]*',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'post' => [
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route'    => '/post',
                            'defaults' => [
                                'controller'    => 'market-post-controller',
                                'action'        => 'index',
                            ],
                        ],
                    ],
                    /*
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                            ],
                        ],
                    ],
                    */
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php',
    ],
];
