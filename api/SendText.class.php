<?php

class OnCallAlertsSendText {

    private $_url_server;
    private $_publickey_server;
    private $_login_server;
    private $_pwd_server;
    private $_xml_encoded;
    private $_data_crypt;
    private $_transactionID;
    private $_time;
    private $_text;
    
    private $_result_send;

    public function __construct() {

        $this->_url_server = plugin_config_get('url_server_text');
        $this->_publickey_server = plugin_config_get('publickey_server_text');
        $this->_login_server = plugin_config_get('login_server_text');
        $this->_pwd_server = plugin_config_get('pwd_server_text');
        $this->_data_crypt = plugin_config_get('data_server_text');
        
        $time = new \DateTime();        
        $this->_time = $time->format('YmdHis');
        
        $this->_generateTransactionID();
    }

    private function _generateXml($text,$phone) {
       
       $xml_decoded = "XMLDATA=<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
                        <ResponseService Version=\"2.3\">
                            <Header>
                                <Partner>{$this->_login_server}</Partner>
                                <Password>{$this->_pwd_server}</Password>
                                <TransactionID>".base64_encode($this->_transactionID)."</TransactionID>
                            </Header>
                            <ResponseList>
                                <Response SequenceNumber=\"1\" Type=\"SMS\">
                                   <Time>{$this->_time}</Time>
                                    <Data>$text</Data>
                                    <Destination>$phone</Destination>
                                 </Response>
                            </ResponseList>
                        </ResponseService>";
        
        $this->_xml_encoded = $xml_decoded;
    }

    private function _generateTransactionID()
    {
        $rsa = new Crypt_RSA();
        $rsa->loadKey($this->_publickey_server); // public key

        //$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
        $this->_transactionID = $rsa->encrypt($this->_data_crypt);
        
    }
    
    public function sendText($text,$phone)
    {
        $this->_generateXml($text,$phone);
        $qdata = http_build_query(array($this->_xml_encoded));
        $opts = array('http' =>
            array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen($qdata)."\r\n".
                            "User-Agent:SMS_Send/0.1\r\n",
               'method'  => 'POST',
               'timeout' => 5,
               'content' => $qdata )
           );
        $context  = stream_context_create($opts);         
       
        try {
            $this->_result_send = file_get_contents($this->_url_server,false,$context);
            return true;            
        } catch (HttpException $ex) {
            $this->_result_send = $ex;
            return false;
        }
    }
    
    public function getResultSend()
    {
        return $this->_result_send;
    }
}
