<?php
namespace JkYang\Obs\Internal\Common;

use JkYang\Obs\ObsClient;
use JkYang\Obs\Internal\Resource\V2Constants;

class V2Transform implements ITransform
{
    private static $instance;
    
    private function __construct()
    {
    }
    
    public static function getInstance()
    {
        if (!(self::$instance instanceof V2Transform)) {
            self::$instance = new V2Transform();
        }
        return self::$instance;
    }
     
    public function transform($sign, $para)
    {
        if ($sign === 'storageClass') {
            $para = $this->transStorageClass($para);
        } elseif ($sign === 'aclHeader') {
            $para = $this->transAclHeader($para);
        } elseif ($sign === 'aclUri') {
            $para = $this->transAclGroupUri($para);
        } elseif ($sign == 'event') {
            $para = $this->transNotificationEvent($para);
        }
        return $para;
    }
    
    private function transStorageClass($para)
    {
        $search = array(ObsClient::StorageClassStandard, ObsClient::StorageClassWarm, ObsClient::StorageClassCold);
        $repalce = array('STANDARD', 'STANDARD_IA', 'GLACIER');
        $para = str_replace($search, $repalce, $para);
        return $para;
    }
    
    private function transAclHeader($para)
    {
        if ($para === ObsClient::AclPublicReadDelivered || $para === ObsClient::AclPublicReadWriteDelivered) {
            $para = null;
        }
        return $para;
    }
    
    private function transAclGroupUri($para)
    {
        if ($para === ObsClient::GroupAllUsers) {
            $para = V2Constants::GROUP_ALL_USERS_PREFIX . $para;
        } elseif ($para === ObsClient::GroupAuthenticatedUsers) {
            $para = V2Constants::GROUP_AUTHENTICATED_USERS_PREFIX . $para;
        } elseif ($para === ObsClient::GroupLogDelivery) {
            $para = V2Constants::GROUP_LOG_DELIVERY_PREFIX . $para;
        } elseif ($para === ObsClient::AllUsers) {
            $para = V2Constants::GROUP_ALL_USERS_PREFIX . ObsClient::GroupAllUsers;
        }
        return $para;
    }
    
    private function transNotificationEvent($para)
    {
        $pos = strpos($para, 's3:');
        if ($pos === false || $pos !== 0) {
            $para = 's3:' . $para;
        }
        return $para;
    }
}
