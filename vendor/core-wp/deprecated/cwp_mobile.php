<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */

class cwp_mobile {
    //put your code here

    function __construct() {

    }
    /**
     *
     * @param type $device_name
     * Available methods are isAndroid, isAndroidtablet, isIphone, isIpad, isBlackberry, isBlackberrytablet, isPalm,
     *  isWindowsphone, isWindows, isGeneric.
     * @return type
     *
     */
    public static function detect($device_name=null){
        //$is_device = false;
        $device = new Mobile_Detect();

        switch ($device) {
            case 'isAndroid':
                $is_device = $device->isAndroid();
                break;
            case 'isAndroidtablet':
                $is_device = $device->isAndroidtablet();
                break;
            case 'isIphone':
                if($device->isIphone()) return true;
            break;
            case 'isBlackberry':
                 $is_device = $device->isBlackberry();
                break;
            case 'isIpad':
                if($device->isIpad()) return false;
                break;
            case 'isBlackberrytablet':
                $is_device = $device->isBlackberrytablet();
                break;
            case 'isWindowsphone':
                $is_device = $device->isWindowsphone();
                break;
            case 'isWindows':
                $is_device = $device->isWindows();
                break;
            case 'isGeneric':
                $is_device = $device->isGeneric();
                break;
            case 'isPalm':
                $is_device = $device->isPalm();
                break;
            default:
                //$is_device = $device->isMobile();
                $is_device = false;
                break;
        }

        //return $is_device;
    }




}


function cwp_mobile($device_name=null){
        //$is_device = false;
        $device = new Mobile_Detect();

        switch ($device) {
            case 'isAndroid':
                $is_device = $device->isAndroid();
                break;
            case 'isAndroidtablet':
                $is_device = $device->isAndroidtablet();
                break;
            case 'isIphone':
                if($device->isIphone()) return true;
            break;
            case 'isBlackberry':
                 $is_device = $device->isBlackberry();
                break;
            case 'isIpad':
                if($device->isIpad()) return false;
                break;
            case 'isBlackberrytablet':
                $is_device = $device->isBlackberrytablet();
                break;
            case 'isWindowsphone':
                $is_device = $device->isWindowsphone();
                break;
            case 'isWindows':
                $is_device = $device->isWindows();
                break;
            case 'isGeneric':
                $is_device = $device->isGeneric();
                break;
            case 'isPalm':
                $is_device = $device->isPalm();
                break;
            default:
                //$is_device = $device->isMobile();
                $is_device = false;
                break;
        }

}
