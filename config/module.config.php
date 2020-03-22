<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigResource' => 'MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigResourceFactory',
            'DbModel' => 'MicroIceUrlPlayer\\V1\\Rest\\Config\\Model\\DbModelFactory',
            'CronService' => 'MicroIceUrlPlayer\\V1\\Rest\\Config\\Service\\CronServiceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'micro-ice-url-player.rest.config' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/player-config[/:config_id]',
                    'defaults' => array(
                        'controller' => 'MicroIceUrlPlayer\\V1\\Rest\\Config\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'micro-ice-url-player.rest.config',
        ),
    ),
    'zf-rest' => array(
        'MicroIceUrlPlayer\\V1\\Rest\\Config\\Controller' => array(
            'listener' => 'MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigResource',
            'route_name' => 'micro-ice-url-player.rest.config',
            'route_identifier_name' => 'config_id',
            'collection_name' => 'config',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
                2 => 'DELETE',
            ),
            'collection_query_whitelist' => array('limit','filter'),
            'page_size' => 1000,
            'page_size_param' => 'limit',
            'entity_class' => 'MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigEntity',
            'collection_class' => 'MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigCollection',
            'service_name' => 'config',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'MicroIceUrlPlayer\\V1\\Rest\\Config\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'MicroIceUrlPlayer\\V1\\Rest\\Config\\Controller' => array(
                0 => 'application/vnd.micro-ice-url-player.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'MicroIceUrlPlayer\\V1\\Rest\\Config\\Controller' => array(
                0 => 'application/vnd.micro-ice-url-player.v1+json',
                1 => 'application/json',
                2 => 'application/x-www-form-urlencoded',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigEntity' => array(
                'entity_identifier_name' => 'Id',
                'route_name' => 'micro-ice-url-player.rest.config',
                'route_identifier_name' => 'config_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigCollection' => array(
                'entity_identifier_name' => 'Id',
                'route_name' => 'micro-ice-url-player.rest.config',
                'route_identifier_name' => 'config_id',
                'is_collection' => true,
            ),
        ),
    ),
);
