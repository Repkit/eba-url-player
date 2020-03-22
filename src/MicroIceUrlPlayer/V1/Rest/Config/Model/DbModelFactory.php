<?php

namespace MicroIceUrlPlayer\V1\Rest\Config\Model;

class DbModelFactory
{
    public function __invoke($services)
    {
        if($services->has('DbManager')){
            $model = $services->get('DbManager')->get('MicroIceUrlPlayer\V1\Rest\Config\ConfigEntity');
        }
        else
        {
            $config = $services->get('config');
            if( !isset($config['url_player_settings']) ){
                throw new \Exception('Invalid url player config', 1);
            }
            $settings = $config['url_player_settings'];

            if( !empty($settings['db'])){
                $adapter = new \Zend\Db\Adapter\Adapter($settings['db']);
            }
            elseif( $services->has("Zend\Db\Adapter\Adapter") ){
                $adapter = $services->get("Zend\Db\Adapter\Adapter");
            }
            elseif( !empty($config['db']) ){
                $adapter = new \Zend\Db\Adapter\Adapter($config['db']);
            }
            else{
                throw new \Exception("Could not create adapter for url player", 1);
            }

            $model =  new DbModel($adapter);
        }
        
        return $model;
    }
}
