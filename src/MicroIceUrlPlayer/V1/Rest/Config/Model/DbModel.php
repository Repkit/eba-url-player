<?php

namespace MicroIceUrlPlayer\V1\Rest\Config\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

class DbModel extends TableGateway
{
	protected $EntityClass 	= '\MicroIceUrlPlayer\V1\Rest\Config\ConfigEntity';
	protected $TableName 	= 'url_playlist';
	protected $PrimaryKey	= 'Id';

	/**
	 * PagesModel constructor.
	 * @param \Zend\Db\Adapter\AdapterInterface $Adapter
	 * @param array $Options
	 */
	public function __construct(\Zend\Db\Adapter\AdapterInterface $Adapter, array $Options = array())
    {
    	if (!empty($Options['tableName']))
		{
    		$this->TableName = $Options['tableName'];
    	}

    	if (!empty($Options['primaryKey']))
		{
    		$this->PrimaryKey = $Options['primaryKey'];
    	}

        $entityClass = $this->EntityClass;
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new $entityClass());

        parent::__construct($this->TableName, $Adapter, null, $resultSetPrototype);
    }

	/**
	 * @param $Id
	 * @return array|\ArrayObject|bool|null
	 */
    public function getById($Id)
    {
    	if(!isset($Id) || empty($Id))
		{
    		return false;
    	}

    	return $this->select(array('Id' => $Id))->current();
    }

	/**
	 * @param $Name
	 * @return array|\ArrayObject|bool|null
	 */
    public function getByName($Name)
    {
    	if(!isset($Name) || empty($Name))
		{
    		return false;
    	}

    	return $this->select(array('Name' => $Name))->current();
    }

	/**
	 * @param array $Where
	 * @return ResultSet
	 */
	public function fetchAll(array $where = array())
	{
		$select = new Select();
		$select->from($this->TableName);
		if( isset($where['where']) && !empty($where['where']) ){
			$select->where($where['where']);
		}
		if( isset($where['columns']) && !empty($where['columns']) ){
			$select->columns($where['columns']);
		}
		
		$sql = new Sql($this->Adapter);
		$statement = $sql->prepareStatementForSqlObject($select);
		$resultSet = new ResultSet();
		$resultSet->initialize($statement->execute());

		return $resultSet;
	}


	/**
	 * @param array $Storage
	 * @param null $Where
	 * @return ResultSet
	 */
	public function getAllExtended($Storage = array(), $Where = null)
	{
		$select = $this->preselect($Storage,$Where);

		if(!empty($Where))
		{
			$select = \TBoxDbFilter\DbFilter::withWhere($select, $Where, $this->TableName);
		}

		$sql = new Sql($this->Adapter);
		$statement = $sql->prepareStatementForSqlObject($select);
		$resultSet = new ResultSet();
		$resultSet->initialize($statement->execute());

		return $resultSet;
	}

	/**
	 * @param array $Storage
	 * @param null $Where
	 * @return Select
	 */
	private function preselect(array $Storage = array(),&$Where = null)
	{
		$select = new Select();
		$select->from($this->TableName);

		if ( !empty($Storage) )
		{
			$joins = $Storage['joins'];
			// add extra joins if they are defined
			foreach($joins as $type => $joincollection)
			{
				foreach($joincollection as $join)
				{
					if(!empty($join['table']) && !empty($join['on']) && !empty($join['columns']))
					{
						$select->join($join['table']
							, new Expression($join['on'])
							, $join['columns']
							, $type
						);
					}

				}
			}

			if (isset($Where) && !empty($Where)
				&& isset($Storage['where']) && !empty($Storage['where'])
				&& isset($Storage['where']['external_columns']) && !empty($Storage['where']['external_columns']) )
			{
				$externalColumns = $Storage['where']['external_columns'];
				$externalWhere = array();
				foreach ($Where as $key => $condition)
				{
					$propertyName = $condition['name'];
					if( isset($externalColumns[$propertyName]) )
					{
						$externalWhere[$key] = $condition;
						$externalWhere[$key]['name'] = $externalColumns[$propertyName];
						unset($Where[$key]);
					}
				}
				if (!empty($externalWhere))
				{
					$select = \TBoxDbFilter\DbFilter::withWhere($select, $externalWhere);
				}
			}
		}

		return $select;
	}

	/**
	 * @return string
	 */
    public function getEntityClass()
    {
    	return $this->EntityClass;
    }
}