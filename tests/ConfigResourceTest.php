<?php

/**
 * @Project: url-player
 * @Class:  ConfigResourceTest
 * @Author: alexandru.serban
 * @Email:	serbanalexandru94@gmail.com
 * @Date:   2016-09-12 16:02:18
 * @Last Modified by:   alexandru.serban
 * @Last Modified time: 2016-09-12 17:25:54
 */

namespace MicroIceRetryMailQueue;

use PHPUnit_Framework_TestCase as TestCase;
use ApplicationTest\Bootstrap;

class ConfigResourceTest extends TestCase
{

	private $ConfigResource;

    /**
     * Set up
     */
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->ConfigResource = $serviceManager->get('MicroIceUrlPlayer\\V1\\Rest\\Config\\ConfigResource');
    }

    public function jobProvider()
    {
        return [
    		'action' 	=> 'phpunit-test',
    		'method' 	=> 'phpunit-test',
    		'data'   	=> 'phpunit-test',
    		'minutes'   => '0',
    		'hours'   	=> '*',
    		'days'   	=> '*',
    		'dow'   	=> '*',
    		'months'   	=> '*',
    		'comment'   => 'phpunit-test',
        ];
    }



    public function test_create()
    {
    	$data  = $this->jobProvider();
    	$result = $this->ConfigResource->create($data);
    	$this->assertNotNull($result);
    	$this->assertArrayHasKey('Id',$result);
    	$id = $result['Id'];
    	$this->assertNotEmpty($id);
    	$this->assertArrayHasKey('Hash',$result);
    	$hash = $result['Hash'];
    	$this->assertNotEmpty($hash);
    	$this->assertArrayHasKey('Status',$result);
    	$status = $result['Status'];
    	$this->assertEquals($status,1);

    	return $id;
    }


    /**
     * @depends test_create
     */
    public function test_fetch($id)
    {

    	$result = $this->ConfigResource->fetch($id);
    	$this->assertNotNull($result);
    	$this->assertArrayHasKey('Id',$result);
    	$jobId = $result['Id'];
    	$this->assertNotEmpty($jobId);
    	$this->assertArrayHasKey('Hash',$result);
    	$hash = $result['Hash'];
    	$this->assertNotEmpty($hash);
    	$this->assertEquals($id,$jobId);

    	return $id;
    }



    /**
     * @depends test_fetch
     */
    public function test_patch($id)
    {
    	$data = [
    		'status' => 0
    	];

    	$result = $this->ConfigResource->patch($id,$data);
    	$this->assertNotEmpty($result);
    	$this->assertArrayHasKey('Status',$result);
    	$status = $result['Status'];
    	$this->assertEquals($status,0);
    	$this->assertArrayHasKey('Id',$result);
    	$jobId = $result['Id'];
    	$this->assertEquals($jobId,$id);

    	return $id;
    }


    /**
     * @depends test_patch
     */
    public function test_delete($id)
    {
    	$this->ConfigResource->delete($id);
    	$result = $this->ConfigResource->fetch($id);
    	$this->assertInstanceOf( "ZF\ApiProblem\ApiProblem",$result);
    }


    public function test_fetchAll()
    {
    	$results = $this->ConfigResource->fetchAll();
    	$this->assertNotNull($results);
    }

}