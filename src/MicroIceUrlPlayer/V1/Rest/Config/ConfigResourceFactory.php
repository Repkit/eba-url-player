<?php
namespace MicroIceUrlPlayer\V1\Rest\Config;

use ZF\ApiProblem\ApiProblem;

class ConfigResourceFactory
{
    public function __invoke($services)
    {
		$dbModel = $services->get('DbModel');
    	$cronService = $services->get('CronService');
    	$settings = array();
        $gConfig  = $services->get('config');
        if( !empty($gConfig['url_player_settings']) ){
        	$settings = $gConfig['url_player_settings'];
        }

        return new ConfigResource($dbModel, $cronService, $settings);
    }
}
