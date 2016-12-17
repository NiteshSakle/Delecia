<?php

namespace Delecia;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Delecia\Model\LoginTable;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

	public function getServiceConfig()
    {
        return [
            'factories' => [

				Model\LoginTable::class => function($container) {
					$tableGateway = $container->get(Model\LoginTableGateway::class);
					$table = new LoginTable($tableGateway);
					return $table;
				},
				Model\LoginTableGateway::class => function ($container) {
					$dbAdapter = $container->get(AdapterInterface::class);
					$resultSetPrototype = new ResultSet();
					return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
				},

			],
		];
	}

     public function getControllerConfig()
     {
        return [
          'factories' => [
				Controller\LoginController::class =>function($container)
				{
					$loginTable = $container->get(Model\LoginTable::class);
					return new Controller\LoginController($loginTable);
				},         
		   ],
        ];
    }
}
