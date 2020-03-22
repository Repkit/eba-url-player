<?php
namespace MicroIceUrlPlayer\V1\Rest\Config;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\Db\TableGateway\TableGatewayInterface;

class ConfigResource extends AbstractResourceListener
{

    private $_model;
    private $_cron;
    private $_settings;

    public function __construct(TableGatewayInterface $Model, $CronService, $Settings = array())
    {
        $this->_model = $Model;
        $this->_cron  = $CronService;
        $this->_settings = $Settings;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try
        {
            $configEntity = new ConfigEntity();
            $configEntity->exchangeRequest((array)$data);
            $configEntity->validate();
            $configEntity->setStatus(1);
            $configEntity->setAdded(date('Y-m-d H:i:s'));

            $hash = $this->_cron->addJob($configEntity);
            if( empty($hash) ){
                throw new \Exception('Job could not be added in crontab');
            }

            $configEntity->setHash($hash);
            $this->_model->insert($configEntity->getArrayCopy());
            $insertValue = $this->_model->getLastInsertValue();
            $configEntity->setId($insertValue);

            return $configEntity;
        }
        catch(\InvalidArgumentException $e)
        {
            return new ApiProblem(400, $e->getMessage());
        }
        catch(\Exception $e)
        {
            return new ApiProblem(417, $e->getMessage());
        }

    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try
        {
            $configEntity = $this->_model->getById($id);
            if( empty($configEntity) ){
                throw new \InvalidArgumentException('Invalid config id');
            }
            $job = $this->_cron->getJob($configEntity->getHash());
            if( !empty($job) )
            {
                $result = $this->_cron->removeJob($configEntity->getHash());
                if( !$result ){
                    throw new \Exception('Job could not be removed from crontab');
                }
            }
            $deleted = (boolean)$this->_model->delete(array('Id' => $id));

            return $deleted;
        }
        catch(\InvalidArgumentException $e)
        {
            return new ApiProblem(400, $e->getMessage());
        }
        catch(\Exception $e)
        {
            return new ApiProblem(417, $e->getMessage());
        }
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        try
        {
            $configEntity = $this->_model->getById($id);

            return $configEntity ? $configEntity : false;
        }catch (\Exception $ex){
            return new ApiProblem(400, $ex->getMessage());
        }

    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        try
        {
            $detailsLimit = 10;
            if(count($params))
            {
                $fetchall = false;
                if(!empty($params['limit']))
                {
                    $rqlimit = intval($params['limit']);
                    if($rqlimit > $detailsLimit){
                        $params['limit'] = $detailsLimit;
                    }
                    else{
                        $fetchall = true;
                    }
                    unset($rqlimit);
                }
                else
                {
                    $params['limit'] = $detailsLimit;
                }

                if($fetchall)
                {
                    $storage = array();
                    if(!empty($this->_settings['storage']))
                    {
                        if(!empty($this->_settings['storage']))
                        {
                            if(!empty($this->_settings['storage']['config_joins'])){
                                $storage = $this->_settings['storage'];
                            }
                        }
                    }

                    $where = null;
                    if(!empty($params['filter'])){
                        $where = $params['filter'];
                    }

                    $results = $this->_model->getAllExtended($storage, $where);
                }
                else
                {
                    return new ApiProblem(
                        413,
                        "Please specify a valid limit parameter!Maximum allowed limit is $detailsLimit",
                        "http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html",
                        "Request Entity Too Large"
                    );
                }
            }
            else
            {
                $results = $this->_model->fetchAll(array('columns' => array('Id','Name','Status','Timestamp')));
            }

            return new ConfigCollection(new \Zend\Paginator\Adapter\Iterator($results));
        }
        catch(\Exception $e)
        {
            return new ApiProblem(417, $e->getMessage());
        }
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        try
        {
            $data = (array)$data;
            if( empty($data) ){
                throw new \InvalidArgumentException('Invalid data');
            }

            $configEntity = $this->_model->getById($id);
            if( empty($configEntity) ){
                throw new \InvalidArgumentException('Invalid id');
            }

            if( $configEntity->getStatus() == 1 )
            {
                $result = $this->_cron->removeJob($configEntity->getHash());
                if( !$result ){
                    throw new \Exception('Could not remove old job from crontab');
                }
            }

            $configEntity->exchangeRequest($data);
            if( $configEntity->getStatus() == 1 )
            {
                $newHash = $this->_cron->addJob($configEntity);
                if( empty($newHash) ){
                    throw new \Exception('Could not add new job to crontab');
                }
                $configEntity->setHash($newHash);
            }

            $this->_model->update($configEntity->getArrayCopy(),array('Id' => $id));

            return $configEntity;
        }
        catch(\InvalidArgumentException $e)
        {
            return new ApiProblem(400, $e->getMessage());
        }
        catch(\Exception $e)
        {
            return new ApiProblem(417, $e->getMessage());
        }
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
