<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'market-index-controller' => 'Market\Controller\IndexController',
            'market-view-controller'  => 'Market\Controller\ViewController',
        ),
        'factories' => array(
            'market-post-controller'  => 'Market\Factory\PostControllerFactory',
        ),
    ),
    'service_manager' => array(
        // TODO: define form under factories
        'factories' => array(
            'market-form-post'   => 'Market\Factory\PostFormFactory',
            'market-filter-post' => 'Market\Factory\PostFilterFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => 'market-index-controller',
                        'action'        => 'index',
                    ),
                ),
            ),
            'market' => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/market',
                    'defaults' => array(
                        'controller'    => 'market-index-controller',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'view' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            // Change this to something specific to your module
                            'route'    => '/view',
                            'defaults' => array(
                                'controller'    => 'market-view-controller',
                                'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'index' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route'    => '/main[/:category]',
                                    'defaults' => array(
                                        'action'        => 'index',
                                    ),
                                    'constraints' => array(
                                        'category' => '[a-zA-Z]*',
                                    ),
                                ),
                            ),
                            'item' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route'    => '/item[/:itemId]',
                                    'defaults' => array(
                                        'action'        => 'item',
                                    ),
                                    'constraints' => array(
                                        'itemId' => '[0-9]*',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'post' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            // Change this to something specific to your module
                            'route'    => '/post',
                            'defaults' => array(
                                'controller'    => 'market-post-controller',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    /*
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    */
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Market' => __DIR__ . '/../view',
        ),
    ),
);
