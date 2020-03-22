<?php
namespace MicroIceUrlPlayer\V1\Rest\Config;

class ConfigEntity implements \JsonSerializable
{

    protected $Id;
    protected $Name;
    protected $Hash;
    protected $Action;
    protected $Method;
    protected $Data;
    protected $Minutes = '*';
    protected $Hours = '*';
    protected $Days = '*';
    protected $Months = '*';
    protected $DoW = '*';
    protected $Comment;
    protected $Added;
    protected $Status;
    protected $Timestamp;



    public function jsonSerialize()
    {
        return json_encode($this->getArrayCopy());
    }

    public function getArrayCopy()
    {
        return array(
            'Id' => $this->Id,
            'Name' => $this->Name,
            'Hash' => $this->Hash,
            'Action' => $this->Action,
            'Method' => $this->Method,
            'Data' => $this->Data,
            'Minutes' => $this->Minutes,
            'Hours' => $this->Hours,
            'Days' => $this->Days,
            'Months' => $this->Months,
            'DoW' => $this->DoW,
            'Comment' => $this->Comment,
            'Added' => $this->Added,
            'Status' => $this->Status,
            'Timestamp' => $this->Timestamp
        );
    }

    public function exchangeArray($Array)
    {
        if( !empty($Array['Id']) ){
            $this->Id = $Array['Id'];
        }
        if( !empty($Array['Name']) ){
            $this->Name = $Array['Name'];
        }
        if( !empty($Array['Hash']) ){
            $this->Hash = $Array['Hash'];
        }
        if( !empty($Array['Action']) ){
            $this->Action = $Array['Action'];
        }
        if( !empty($Array['Method']) ){
            $this->Method = $Array['Method'];
        }
        if( !empty($Array['Data']) ){
            $this->Data = $Array['Data'];
        }
        if( isset($Array['Minutes']) ){
            $this->Minutes = $Array['Minutes'];
        }
        if( isset($Array['Hours']) ){
            $this->Hours = $Array['Hours'];
        }
        if( !empty($Array['Days']) ){
            $this->Days = $Array['Days'];
        }
        if( isset($Array['DoW']) ){
            $this->DoW = $Array['DoW'];
        }
        if( !empty($Array['Comment']) ){
            $this->Comment = $Array['Comment'];
        }
        if( !empty($Array['Months']) ){
            $this->Months = $Array['Months'];
        }
        if( !empty($Array['Added']) ){
            $this->Added = $Array['Added'];
        }
        if( isset($Array['Status']) ){
            $this->Status = $Array['Status'];
        }
        if( !empty($Array['Timestamp']) ){
            $this->Timestamp = $Array['Timestamp'];
        }

    }

    public function exchangeRequest($Array)
    {
        if( !empty($Array['action']) ){
            $this->Action = $Array['action'];
        }
        if( !empty($Array['name']) ){
            $this->Name = $Array['name'];
        }
        if( !empty($Array['method']) ){
            $this->Method = $Array['method'];
        }
        if( !empty($Array['data']) ){
            $this->Data = $Array['data'];
        }
        if( isset($Array['minutes']) ){
            $this->Minutes = $Array['minutes'];
        }
        if( isset($Array['hours']) ){
            $this->Hours = $Array['hours'];
        }
        if( !empty($Array['days']) ){
            $this->Days = $Array['days'];
        }
        if( isset($Array['dow']) ){
            $this->DoW = $Array['dow'];
        }
        if( !empty($Array['comment']) ){
            $this->Comment = $Array['comment'];
        }
        if( !empty($Array['months']) ){
            $this->Months = $Array['months'];
        }

    }

    public function validate()
    {
        if( !isset($this->Action) || empty($this->Action) ){
            throw new \Exception('Invalid action');
        }
        if( !isset($this->Method) || empty($this->Method) ){
            throw new \Exception('Invalid action');
        }
    }

    public function getId()
    {
        return $this->Id;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getHash()
    {
        return $this->Hash;
    }

    public function getAction()
    {
        return $this->Action;
    }

    public function getMethod()
    {
        return $this->Method;
    }

    public function getData()
    {
        return $this->Data;
    }

    public function getMinutes()
    {
        return $this->Minutes;
    }

    public function getHours()
    {
        return $this->Hours;
    }

    public function getDays()
    {
        return $this->Days;
    }

    public function getMonths()
    {
        return $this->Months;
    }

    public function getDoW()
    {
        return $this->DoW;
    }

    public function getComment()
    {
        return $this->Comment;
    }

    public function getAdded()
    {
        return $this->Added;
    }

    public function getStatus()
    {
        return $this->Status;
    }

    public function getTimestamp()
    {
        return $this->Timestamp;
    }

    public function setId($Id)
    {
        $this->Id = $Id;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
    }

    public function setHash($Hash)
    {
        $this->Hash = $Hash;
    }

    public function setAction($Action)
    {
        $this->Action = $Action;
    }

    public function setMethod($Method)
    {
        $this->Method = $Method;
    }

    public function setData($Data)
    {
        $this->Data = $Data;
    }

    public function setMinutes($Minutes)
    {
        $this->Minutes = $Minutes;
    }

    public function setHours($Hours)
    {
        $this->Hours = $Hours;
    }

    public function setDays($Days)
    {
        $this->Days = $Days;
    }

    public function setMonths($Months)
    {
        $this->Months = $Months;
    }

    public function setDoW($DoW)
    {
        $this->DoW = $DoW;
    }

    public function setComment($Comment)
    {
        $this->Comment = $Comment;
    }

    public function setAdded($Added)
    {
        $this->Added = $Added;
    }

    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    public function setTimestamp($Timestamp)
    {
        $this->Timestamp = $Timestamp;
    }

}
