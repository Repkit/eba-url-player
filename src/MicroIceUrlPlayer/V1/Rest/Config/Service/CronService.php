<?php

namespace MicroIceUrlPlayer\V1\Rest\Config\Service;

use TBoxCronManager\Job;

class CronService
{
	private $_cron;
	private $_settings;

	const COMMAND 	= ' curl ';
	const METHOD 	= ' -X ';
	const DATA  	= ' -d ';

	public function __construct($CronManager, $Settings = array())
	{
		$this->_cron 	 = $CronManager;
		$this->_settings = $Settings;
	}

	public function addJob($ConfigEntry)
	{
		$job = new Job();
		$job->onMinute($ConfigEntry->getMinutes())->onHour($ConfigEntry->getHours())->onDayOfMonth($ConfigEntry->getDays())
			->onDayOfWeek($ConfigEntry->getDoW())->onMonth($ConfigEntry->getMonths());
		$command = self::COMMAND . self::METHOD . $ConfigEntry->getMethod() ;
		
		$data = $ConfigEntry->getData();
		if( !empty($data) )
		{
			$data = json_decode($data, true);
			if( empty($data) ){
				throw new \InvalidArgumentException('Invalid data format');
			}
			$data = http_build_query($data);
			$command .=  self::DATA .  '"' . $data . '" '; 
			unset($data);
		}

		$command .= ' ' . $ConfigEntry->getAction();

		if( !empty($this->_settings['log_path']) )
		{
			$filePath = $this->_settings['log_path'] . DIRECTORY_SEPARATOR .  md5( $ConfigEntry->getAction() ) . '.log 2>&1 ';
			$command .= ' >> ' . $filePath ;
			unset($filePath);
		}

		$job->command($command);
		$job->comment($ConfigEntry->getComment());

		$hash = $this->_cron->add($job);
		$this->_cron->persist();

		return $hash;
	}

	public function getJob($JobHash)
	{
		return $this->_cron->get($JobHash);
	}

	public function removeJob($JobHash)
	{
		$result = $this->_cron->remove($JobHash);
		if( $result ){
			$this->_cron->persist();
		}

		return true;
	}

	public function removeAll()
	{
		$this->_cron->clear();
		$this->_cron->persist();
	}

	public function getAll()
	{
		return $this->_cron->jobs();
	}
}