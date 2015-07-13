<?php
namespace Xyz;

class Module
{
    // do nothing
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
   
    // the output from this method is cached
    public function getConfig()
    {
        // normally, the output from this method is the return value 
        // from the config/module.config.php file
        return [
            'service_manager' => [
                'services' => [
                    'xyz-test-1' => 'TEST',
                ],
            ],
        ];
    }

    // the output from this method is NOT cached
    public function getServiceConfig()
    {
        return [
            // getServiceConfig == service_manager
            'services' => [
                'xyz-test-2' => 'TEST',
            ],
        ];
    }
}