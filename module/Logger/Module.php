<?php
namespace Logger;

use Zend\Log\Writer\Stream;
use Zend\Log\Logger;

class Module
{
    // do nothing
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
        ];
    }
   
    // the output from this method is cached
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'logger-instance' => function ($sm) {
                    $logFile = $sm->get('logger-params')['dir'] . '/' . date('Ymd');
                    $writer = new Stream($logFile);
                    return new Logger($writer);
                }
            ],  
        ];
    }
}