<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SD_Postcr
{
    public function _array_sap($data)
    {
        $params = array(
            'Bukrs'    => '',
            'Date'    => '',
            'Kunnr'    => $data,
            'LineItems' => array(
                'item' => array(
                    'Belnr' => ''
                )
            )
        );

        return $params;
    }

    public function _array_map($scm, $sap)
    {
        $Header    = array(
            'MessageType' => $scm['Header']['MessageType'],
            'MessageVersion' => $scm['Header']['MessageVersion'],
            'Partners' => array(
                'PartnerInformation' => array(
                    'PartnerIdentifier' => $scm['Header']['Partners']['PartnerInformation']['PartnerIdentifier'],
                    'PartnerName' => $scm['Header']['Partners']['PartnerInformation']['PartnerName'],
                    'ContactInformation' => array(
                        'ContactName' => $scm['Header']['Partners']['PartnerInformation']['ContactInformation']['ContactName'],
                        'ContactNumber' => $scm['Header']['Partners']['PartnerInformation']['ContactInformation']['ContactNumber'],
                        'ContactEmail' => $scm['Header']['Partners']['PartnerInformation']['ContactInformation']['ContactEmail']
                    )
                )
            )
        );

        $params = array(
            'Header'    => $Header,
            'Debtors' => array('DebtorCreditInfo' => $sap)
        );

        $result = $this->arrayToXml($params);
        return $result;
    }

    public function arrayToXml($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;

        if ($_xml === null) {
            $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<DebtorOutstandingDetail/>');
        }

        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $this->arrayToXml($v, $k, $_xml->addChild($k));
            } else {
                $_xml->addChild($k, $v);
            }
        }

        return $_xml->asXML();
    }

    public function _scm_xml($code, $acc_code, $data)
    {
        $xml_data = '<DebtorOutstandingDetail>' .
            '<Header>' .
            '<MessageType>PARTY</MessageType>' .
            '<MessageVersion>1</MessageVersion>' .
            '<Partners>' .
            '<PartnerInformation>' .
            '<PartnerIdentifier>SCMProFit</PartnerIdentifier>' .
            '<PartnerName>SCMProFit</PartnerName>' .
            '<ContactInformation>' .
            '<ContactName>Administrator</ContactName>' .
            '<ContactNumber>1234569872</ContactNumber>' .
            '<ContactEmail>admin@aurionpro.com</ContactEmail>' .
            '</ContactInformation>' .
            '</PartnerInformation>' .
            '</Partners>' .
            '</Header>' .
            '<Debtors>' .
            '<DebtorCreditInfo>' .
            '<Office></Office>' .
            '<SCMProFitDebtorCode>' . $code . '</SCMProFitDebtorCode>' .
            '<AccountCode>' . $acc_code . '</AccountCode>' .
            '<AmountOutstanding>' . $data . '</AmountOutstanding>' .
            '<AmountOutstandingCurrency>IDR</AmountOutstandingCurrency>' .
            '<IsInvoiceDue></IsInvoiceDue>' .
            '<HoldStatus>No</HoldStatus>' .
            '</DebtorCreditInfo>' .
            '</Debtors>' .
            '</DebtorOutstandingDetail>';

        /* $bearer_key = $this->_get_tokens();

        $bearer = $bearer_key;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://ibluatcommonapi.scmprofit.net:80/api/v1/PartyMasterAPI/GeneratePartyMasters",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $xml_data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: bearer " . $bearer,
                "Content-Type: application/xml"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if ($response) {
            $resp_string = simplexml_load_string($response);
            $resp_json = json_encode($resp_string, true);
            $resp_data = json_decode($resp_json, true);
            return $resp_data;
        } else {
            return false;
        } */

        return $xml_data;
    }

    public function _get_tokens()
    {
        $CI = &get_instance();
        $CI->db->select('access_token');
        $rc = $CI->db->get_where('tb_token')->row_array();
        return $rc['access_token'];
    }
}
