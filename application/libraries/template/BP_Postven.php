<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BP_Postven
{
    public function _get_result($data, $code = '')
    {
        $items = $data['message']['YfiVendor']['item'];
        //print_r($items);
        if ($code == '') {
            foreach ($items as $k => $v) {
                $cust['Code'] = $items[$k]['Lifnr'];
                $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                $cust['FirstName'] = $items[$k]['NameFirst'] ? $items[$k]['NameFirst'] : '-';
                $cust['Number'] = $items[$k]['Telfx'] ? $items[$k]['Telfx'] : '-';
                $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                $cust['OfficeCode'] = $items[$k]['Ekorg'] ? $items[$k]['Ekorg'] : 'CKIB';  //CKIB is default for testing
                $cust['OfficeName'] = $items[$k]['EkorgName1'] ? $items[$k]['EkorgName1'] : 'Iron Bird Jakarta'; //Iron Bird Jakarta is default for testing
                $cust['CreditTerm'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                $cust['BillingCurrency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                $cust['FirstName'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] : '-';
                $cust['LastName'] = $items[$k]['CpNameLast'] ? $items[$k]['CpNameLast'] : '-';
                $xml_dt = $this->_scm_xml($cust);
            }
        } else {
            foreach ($items as $k => $v) {
                if ($items[$k]['Lifnr'] == $code) {
                    $cust['Code'] = $items[$k]['Lifnr'];
                    $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                    $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                    $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                    $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                    $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                    $cust['FirstName'] = $items[$k]['NameFirst'] ? $items[$k]['NameFirst'] : '-';
                    $cust['Number'] = $items[$k]['Telfx'] ? $items[$k]['Telfx'] : '-';
                    $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                    $cust['OfficeCode'] = $items[$k]['Ekorg'] ? $items[$k]['Ekorg'] : 'CKIB';  //CKIB is default for testing
                    $cust['OfficeName'] = $items[$k]['EkorgName'] ? $items[$k]['EkorgName'] : 'Iron Bird Jakarta'; //Iron Bird Jakarta is default for testing
                    $cust['CreditTerm'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                    $cust['BillingCurrency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                    $cust['FirstName'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] : '-';
                    $cust['LastName'] = $items[$k]['CpNameLast'] ? $items[$k]['CpNameLast'] : '-';
                    $xml_dt = $this->_scm_xml($cust);
                }
            }
        }
        return $xml_dt;
    }

    public function _scm_xml($data)
    {
        $xml_data = '<Message>' .
            '<Header>' .
            '<MessageType>PARTY</MessageType>' .
            '<MessageVersion>1</MessageVersion>' .
            '<MessageIdentifier>4230f614-63f8-4e9b-9a25-a7939ae4fdf4</MessageIdentifier>' .
            '<MessageDateTime>20200317080025</MessageDateTime>' .
            '</Header>' .
            '<Parties>' .
            '<Party>' .
            '<Action>Add</Action>' .
            '<PartyName>' .
            '<Code>' . $data['Code'] . '</Code>' .
            '<Name>' . $data['Name'] . '</Name>' .
            '</PartyName>' .
            '<SpecialInstructions>No</SpecialInstructions>' .
            '<Addresses>' .
            '<Address>' .
            '<AddressType>HO</AddressType>' .
            '<AddressLine1>' . $data['AddressLine'] . '</AddressLine1>' .
            '<AddressLine2></AddressLine2>' .
            '<City>' . $data['City'] . '</City>' .
            '<StateProvince></StateProvince>' .
            '<ZipCode>' . $data['ZipCode'] . '</ZipCode>' .
            '<Country>' .
            '<Code>' . $data['CountryCode'] . '</Code>' .
            '</Country>' .
            '<StateProvince></StateProvince>' .
            '<Contacts>' .
            '<Contact>' .
            '<FirstName>' . $data['FirstName'] . '</FirstName>' .
            '<LastName>' . $data['LastName'] . '</LastName>' .
            '<ContactNos>' .
            '<ContactNo>' .
            '<Type>Main</Type>' .
            '<Number>' . $data['Number'] . '</Number>' .
            '</ContactNo>' .
            '</ContactNos>' .
            '<Email>' . $data['Email'] . '</Email>' .
            '</Contact>' .
            '</Contacts>' .
            '</Address>' .
            '</Addresses>' .
            '<PartyTypes>' .
            '<PartyType>' .
            '<Code>Vendor</Code>' .
            '<Name>Vendor</Name>' .
            '</PartyType>' .
            '</PartyTypes>' .
            '<Offices>' .
            '<Office>' .
            '<Code>CKIB</Code>' .
            '<Name>Iron Bird Jakarta</Name>' .
            '<BillingCurrency>' . $data['BillingCurrency'] . '</BillingCurrency>' .
            '<CreditTerm>' . $data['CreditTerm'] . '</CreditTerm>' .
            '</Office>' .
            '</Offices>' .
            '<HoldStatus>No</HoldStatus>' .
            '</Party>' .
            '</Parties>' .
            '</Message>';

        $bearer_key = $this->_get_tokens();
        $bearer = "Authorization: bearer " . $bearer_key;
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
                $bearer,
                "Content-Type: application/xml"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if ($response) {
            $resp_string = simplexml_load_string($response);
            $resp_json = json_encode($resp_string, true);
            $resp_data = json_decode($resp_json, true);
            if ($resp_data !== false) {
                return $resp_data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function _get_array($data, $code = '')
    {
        $items = $data['message']['YfiCustomer']['item'];
        if ($code == '') {
            foreach ($items as $k => $v) {
                $cust['code'] = $items[$k]['Kunnr'];
                $cust['name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                $cust['address'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                $cust['city'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                $cust['zip_code'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                $cust['country_code'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                $cust['phone'] = $items[$k]['Telfx'] ? $items[$k]['Telfx'] : '-';
                $cust['email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                $cust['npwp'] = $items[$k]['Stcd1'] ? $items[$k]['Stcd1'] : '-';
                $cust['office_code'] = $items[$k]['Vkbur'] ? $items[$k]['Vkbur'] : 'CKIB';  //CKIB is default for testing
                $cust['credit_term'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                $cust['currency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                $cust['contact_person'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] . ' ' . $items[$k]['CpNameLast'] : '-';
                $cust['created'] = date('Y-m-d H:i:s');
                $cust['created_by'] = 'bp_postcus';
                $cust_array = $cust;
            }
        } else {
            foreach ($items as $k => $v) {
                if ($items[$k]['Kunnr'] == $code) {
                    $cust['code'] = $items[$k]['Kunnr'];
                    $cust['name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                    $cust['address'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                    $cust['city'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                    $cust['zip_code'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                    $cust['country_code'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                    $cust['phone'] = $items[$k]['Telfx'] ? $items[$k]['Telfx'] : '-';
                    $cust['email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                    $cust['npwp'] = $items[$k]['Stcd1'] ? $items[$k]['Stcd1'] : '-';
                    $cust['office_code'] = $items[$k]['Vkbur'] ? $items[$k]['Vkbur'] : 'CKIB';  //CKIB is default for testing
                    $cust['credit_term'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                    $cust['currency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                    $cust['contact_person'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] . ' ' . $items[$k]['CpNameLast'] : '-';
                    $cust['created'] = date('Y-m-d H:i:s');
                    $cust['created_by'] = 'bp_postcus';
                    $cust_array = $cust;
                }
            }
        }
        return $cust_array;
    }

    public function _get_tokens()
    {
        $CI = &get_instance();
        $CI->db->select('access_token');
        $rc = $CI->db->get_where('tb_token')->row_array();
        return $rc['access_token'];
    }
}
