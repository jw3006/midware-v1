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

    public function _scm_xml($code, $acc_code, $data)
    {
        $xml_data = '<DebtorOutstandingDetail>' .
            '<Header>' .
            '<MessageType>DEBTOROUTSTANDING</MessageType>' .
            '<MessageVersion>1</MessageVersion>' .
            '<SentDatetime>2020-11-12</SentDatetime>' .
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

        $bearer_key = $this->_get_tokens();

        $bearer = $bearer_key;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://ibluatcommonapi.scmprofit.net/api/v1/Outstanding/UpdateOutstandingDetails",
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
            //return $resp_data;
            return $resp_json;
        } else {
            return false;
        }
    }

    public function _get_tokens()
    {
        $CI = &get_instance();
        $CI->db->select('access_token');
        $rc = $CI->db->get_where('tb_token')->row_array();
        return $rc['access_token'];
    }
}
