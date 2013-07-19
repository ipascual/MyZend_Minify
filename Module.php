<?php
namespace Minify;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\View\Helper\Service;

class Module implements ConfigProviderInterface, ViewHelperProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'minify' => 'Minify\View\Helper\MinifyHelper'
            )
        );
    }
}
