<?php

namespace MicroIceUrlPlayer\V1\Rest\Config\Service;

use TBoxCronManager\Manager;
use TBoxCronManager\Executor;
use TBoxCronManager\Parser;

class CronServiceFactory
{
    public function __invoke($services)
    {
    	$executor = new Executor();
		$parser = new Parser();
		$backupFolder = null;
		$settings = array();
		$config = $services->get('config');
        if( !empty($config['url_player_settings']) )
        {
        	$settings = $config['url_player_settings'];
        	if( !empty($settings['backup_path']) ){
        		$backupFolder = $settings['backup_path'];
        	}
        } 
		$cronManager = new Manager($executor, $parser, $backupFolder);
    	$cronService =  new CronService($cronManager, $settings);
        
        return $cronService;
    }
}