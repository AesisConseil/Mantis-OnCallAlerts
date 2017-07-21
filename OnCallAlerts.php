<?php

/* 
 * Plugin OnCallAlerts  pour Mantis BugTracker 
 *
 */

class OnCallAlertsPlugin extends MantisPlugin {

    function register() {
        $this->name         = 'On Call Alerts';
        $this->description  = lang_get('plugin_OnCallAlerts_description');
        $this->version      = "1.1";
        $this->requires     = array(
            "MantisCore" => "1.2.0",
            "jQuery"     => "1.6",
            "jQueryUI"   => "1.11.4",
        );
        $this->page         = 'config';
        $this->author       = "DEV : Thomas SIMON | Graphisme : Laure MARTINEZ | Translate : Rémi Nedelec";
        $this->contact      = "tsimon@aesis-conseil.com";
        $this->url          = "http://www.aesis-conseil.com";
    }

    function config() { 
        return array(
            'nb_day_log'            => 20,
            'msg_text'              => plugin_lang_get('default_text'),
            'msg_text_rappel'       => plugin_lang_get('default_text_rappel'),
            'msg_text_test'         => plugin_lang_get('default_text_test'),
            'url_mantis_text'       => 'https://support.aesis-conseil.com',
            'url_server_text'       => '',
            'login_server_text'     => '',
            'pwd_server_text'       => '',
            'publickey_server_text' => '',
            'data_server_text'      => '',
            'select_project'        => array('0'),
            'newBug'                => '',
            'select_newbug'         => array(),
            'updateBug'             => '',
            'select_updateBug'      => array(),
            'addNote'               => '',
            'select_addNote'        => array(), 
        );
    }

    function schema() {
        return array(
            array("CreateTableSQL", array(plugin_table("oncall"), "
				id              I           NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
				technician_id   I           NOTNULL UNSIGNED,
				start_date      DateTime    NOTNULL,
				end_date        DateTime    NOTNULL,
                                note            XL               
				",
                    array("mysql" => "DEFAULT CHARSET=utf8"))),
            array("CreateTableSQL", array(plugin_table("planing"), "
				id              I       NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
				technician_id   I	NOTNULL UNSIGNED,
                                monday          BOOLEAN ,
                                tuesday         BOOLEAN ,
                                wednesday       BOOLEAN ,
                                thursday        BOOLEAN ,
                                friday          BOOLEAN ,
                                saturday        BOOLEAN ,
                                sunday          BOOLEAN ,
				start_time      Time    NOTNULL,
				end_time        Time	NOTNULL,
                                note            XL               
				",
                    array("mysql" => "DEFAULT CHARSET=utf8"))),
            array("CreateTableSQL", array(plugin_table("technician"), "
				id      I       NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
				name    C(50)	NOTNULL,
                                phone   C(20)   NOTNULL  
				",
                    array("mysql" => "DEFAULT CHARSET=utf8"))),
        );
    }

    function api() {
		require_once("api/Oncall.class.php");
		require_once("api/Planing.class.php");
		require_once("api/Technician.class.php");
		require_once("api/SendText.class.php");
		require_once("api/RSA/Crypt/RSA.php");
		require_once("api/Logger.class.php");                
    }
        
    function hooks() {
        $hooks = array(
	    'EVENT_CORE_READY'      => 'api',
            'EVENT_MENU_MANAGE' => 'print_menu_OnCallAlertsManagement',
            'EVENT_REPORT_BUG'  => 'send_sms_reported',
            'EVENT_UPDATE_BUG'  => 'send_sms_updated',
            'EVENT_BUGNOTE_ADD' => 'send_sms_addNote'
        );
        return $hooks;
    }

    function print_menu_OnCallAlertsManagement() {

        $page = plugin_page('management');
        $lang = plugin_lang_get('management_link');

        return "<a href='$page'>$lang</a>";
    }

    function send_sms_reported($event, $data, $bugID) {

        if(plugin_config_get('newBug'))
        { 
            if(array_search($data->severity,plugin_config_get('select_newbug')) !== false &&
               ( array_search($data->project_id,plugin_config_get('select_project')) !== false || array_search('0',plugin_config_get('select_project')) !== false )
              )
            {                
                $projectName = project_get_name($data->project_id);
                $reporterData = user_get_row($data->reporter_id);
                $categoryName = category_full_name($data->category_id);

                $planing = new OnCallAlertsPlaning();
                $res = $planing->getInPlaning();
                if($res)
                {
                    foreach($res as $r)
                    {
                        $date = new \DateTime();                        
                        $this->_sendText($r->phone, $categoryName, $bugID, $projectName, $reporterData['username'],$date->format('d-m-Y H:i'));
                        Logger::trace("Text send to {$r->phone} for new report by {$reporterData['username']} for $projectName");
                    }
                } 
                
                $onCall = new OnCallAlertsOncall();
                $resOnCall = $onCall->getInOnCall();
               
                if($resOnCall)
                {
                    foreach($resOnCall as $r)
                    {
                        $date = new \DateTime();                        
                        $this->_sendText($r->phone, $categoryName, $bugID, $projectName, $reporterData['username'],$date->format('d-m-Y H:i'));
                        Logger::trace("Text send to {$r->phone} for new report by {$reporterData['username']} for $projectName");
                    }
                } 
            }
        }
    }

    function send_sms_updated($event, $data, $bugID) {
        if(plugin_config_get('updateBug'))
        { 
            if(array_search($data->severity,plugin_config_get('select_updateBug')) !== false &&
               ( array_search($data->project_id,plugin_config_get('select_project')) !== false || array_search('0',plugin_config_get('select_project')) !== false )
              )
            {                
                $projectName = project_get_name($data->project_id);
                $reporterData = user_get_row($data->reporter_id);
                $categoryName = category_full_name($data->category_id);

                $planing = new OnCallAlertsPlaning();
                $res = $planing->getInPlaning();
                if($res)
                {
                    foreach($res as $r)
                    {
                        $date = new \DateTime();                        
                        $this->_sendText($r->phone, $categoryName, $bugID, $projectName, $reporterData['username'],$date->format('d-m-Y H:i'));
                        Logger::trace("Text send to {$r->phone} for new report by {$reporterData['username']} for $projectName");
                    }
                } 
                
                $onCall = new OnCallAlertsOncall();
                $resOnCall = $onCall->getInOnCall();
               
                if($resOnCall)
                {
                    foreach($resOnCall as $r)
                    {
                        $date = new \DateTime();                        
                        $this->_sendText($r->phone, $categoryName, $bugID, $projectName, $reporterData['username'],$date->format('d-m-Y H:i'));
                        Logger::trace("Text send to {$r->phone} for new report by {$reporterData['username']} for $projectName");
                    }
                } 
            }
        }
    }

    function send_sms_addNote($event, $bugID, $bugNoteID) {
        
        $data = bug_get($bugID, true);
        if(plugin_config_get('addNote'))
        { 
            if(array_search($data->severity,plugin_config_get('select_addNote')) !== false &&
               ( array_search($data->project_id,plugin_config_get('select_project')) !== false || array_search('0',plugin_config_get('select_project')) !== false )
              )
            {                
                $projectName = project_get_name($data->project_id);
                $reporterData = user_get_row($data->reporter_id);
                $categoryName = category_full_name($data->category_id);

                $planing = new OnCallAlertsPlaning();
                $res = $planing->getInPlaning();
                if($res)
                {
                    foreach($res as $r)
                    {
                        $date = new \DateTime();                        
                        $this->_sendText($r->phone, $categoryName, $bugID, $projectName, $reporterData['username'],$date->format('d-m-Y H:i'));
                        Logger::trace("Text send to {$r->phone} for new report by {$reporterData['username']} for $projectName");
                    }
                } 
                
                $onCall = new OnCallAlertsOncall();
                $resOnCall = $onCall->getInOnCall();
               
                if($resOnCall)
                {
                    foreach($resOnCall as $r)
                    {
                        $date = new \DateTime();                        
                        $this->_sendText($r->phone, $categoryName, $bugID, $projectName, $reporterData['username'],$date->format('d-m-Y H:i'));
                        Logger::trace("Text send to {$r->phone} for new report by {$reporterData['username']} for $projectName");
                    }
                } 
            }
        }
    }

    private function _sendText($phone,$typeAlerte,$idBug,$projectName,$rapporteur, $date)
    {
        $text = new OnCallAlertsSendText();
        
        $aSearch = array('#CATEGORY','#IDBUG','#PROJECTNAME','#RAPPORTEUR','#DATE','#URL');
        
        $sUrl= plugin_config_get('url_mantis_text');
        
        if(substr($sUrl,-1,1) != '/') $sUrl = $sUrl.'/';
        
        $findme    = '/m/';
        
        if( stripos($sUrl, $findme) ) $rUrl = $sUrl.'issue_page.php?id='.$idBug;
        else $rUrl = $sUrl.'view.php?id='.$idBug;
        
        $aReplace = array($typeAlerte,$idBug,$projectName,$rapporteur, $date,$rUrl);
        
        $msgText = substr(str_replace($aSearch,$aReplace,plugin_config_get('msg_text')),0,159);
       
        if($text->sendText($msgText, $phone))
        {
            return true;
        }
        else return false;
    }
}