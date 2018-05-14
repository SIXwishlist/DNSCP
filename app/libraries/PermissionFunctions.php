<?php
namespace RNTForest\DNSCP\libraries;

class PermissionFunctions{
    /**
    * checks if user is partner (or customer) for this item
    * 
    * @param mixed $item
    */
    public static function partners($item){
        if(!is_object($item)) return false;
        if($item->customers_id == \Phalcon\DI::getDefault()->getSession()->get('auth')['customers_id']) return true;
        foreach($item->customers->partners as $partner){
            if($partner->id == \Phalcon\DI::getDefault()->getSession()->get('auth')['customers_id']) return true;
        }
        return false;
    }

    /**
    * checks if user is customer for this item
    * 
    * @param mixed $item
    */
    public static function customers($item) {
        if(!is_object($item)) return false;
        if($item->customers_id == \Phalcon\DI::getDefault()->getSession()->get('auth')['customers_id']) return true;
        else return false;
    }

    /**
    * checks if user is owner for this item
    * 
    * @param mixed $item
    */
    public static function own($item) {
        if(!is_object($item)) return false;
        if($item->id == \Phalcon\DI::getDefault()->getSession()->get('auth')['id']) return true;
        else return false;
    }

}

?>
