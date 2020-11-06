<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/lib/nusoap.php');

class WSDL_Controller
{
    public function _sap_wsdl($wsdl, $function, $username, $password, $params)
    {
        #Define Authentication 
        $SOAP_AUTH = array(
            'login'    => $username,
            'password' => $password
        );

        #Create Client Object, download and parse WSDL
        $client = new nusoap_client($wsdl, true, '', '80', $SOAP_AUTH);
        $client->setCredentials($username, $password, 'basic');

        #Call Operation (Function). Catch and display any errors
        try {
            $result = $client->call($function, $params);
        } catch (SoapFault $exception) {
            print "***Caught Exception***\n";
            print_r($exception);
            print "***END Exception***\n";
            die();
        }

        # Check for errors
        $err = $client->getError();
        if ($err) {
            $response = array(
                'status' => 'E',
                'message' => $err
            );
            return $response;
        } else {
            $response = array(
                'status' => 'S',
                'message' => $result
            );
            return $response;
        }
    }
}
