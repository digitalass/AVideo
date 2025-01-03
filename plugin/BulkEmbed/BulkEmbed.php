<?php

require_once $global['systemRootPath'] . 'plugin/Plugin.abstract.php';

class BulkEmbed extends PluginAbstract {

    const PERMISSION_BULK_EMBED = 0;
    
    public function getTags() {
        return array(
            PluginTags::$FREE,
        );
    }

    public function getDescription() {
        global $global;
        //$str = 'Set DEVELOPER_KEY to the "API key" value from the "Access" tab of the<br>Google Developers Console https://console.developers.google.com<br>Please ensure that you have enabled the YouTube Data API for your project.';
        //$str.= '<br>Add the Redirect URI '.$global['webSiteRootURL'].'plugin/BulkEmbed/youtubeSearch.json.php';
        $str = 'Create your API Key here https://console.developers.google.com/apis/credentials/key';
        $str .= "<br> Also make sure you enable the API YouTube Data API v3";
        return $str;
    }

    public function getName() {
        return "BulkEmbed";
    }

    public function getUUID() {
        return "bulkembed-8c31-4f15-a355-48715fac13f3";
    }

    public function getPluginVersion() {
        return "1.1";
    }

    public function getEmptyDataObject() {
        global $global;
        $obj = new stdClass();

        $obj->API_KEY = "AIzaSyCIqxE86BawU33Um2HEGtX4PcrUWeCh_6o";
        $obj->onlyAdminCanBulkEmbed = true;
        $obj->useOriginalYoutubeDate = true;
        return $obj;
    }    
    
    public function getPluginMenu() {
        global $global;
        $menu = '<button onclick="avideoModalIframe(webSiteRootURL +\'plugin/BulkEmbed/search.php\');" class="btn btn-primary btn-xs btn-block" target="_blank">Search</button>';
        return $menu;
    }
    
    public function getUploadMenuButton(){
        global $global;
        $obj = $this->getDataObject();
        
        if(BulkEmbed::canBulkEmbed()){
            return '<li><a  href="#" onclick="avideoModalIframeFull(webSiteRootURL+\'plugin/BulkEmbed/search.php\');return false;" class="faa-parent animated-hover"><span class="fas fa-link faa-burst"></span> '.__("Bulk Embed").'</a></li>';
        }else{
            return '';
        }
    }


    function getPermissionsOptions()
    {
        $permissions = array();

        $permissions[] = new PluginPermissionOption(self::PERMISSION_BULK_EMBED, __("Can Bulk Embed"), "Members of the designated user group will have access Bulk Embed videos", 'BulkEmbed');
        return $permissions;
    }

    static function canBulkEmbed()
    {

        if (User::isAdmin() || isCommandLineInterface()) {
            return true;
        }
        
        if(!User::isLogged()){
            return false;
        }

        $objo = AVideoPlugin::getObjectData("BulkEmbed");
        if($objo->onlyAdminCanBulkEmbed && !User::isAdmin()){
            return false;
        }

        return Permissions::hasPermission(self::PERMISSION_BULK_EMBED, 'BulkEmbed');
    }
}
