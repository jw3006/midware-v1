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
                $office = $this->get_office_code($items[$k]['Ekorg'], $items[$k]['Bukrs']);

                $cust['Code'] = $items[$k]['Lifnr'];
                $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                $cust['FirstName'] = $items[$k]['NameFirst'] ? $items[$k]['NameFirst'] : '-';
                $cust['Number'] = $items[$k]['Telf1'] ? $items[$k]['Telf1'] : '-';
                $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                $cust['OfficeCode'] = $office['code'] ? $office['code'] : 'SYIT';
                $cust['OfficeName'] = $office['name'] ? $office['name'] : 'IRON BIRD TRANSPORT JAKARTA';
                $cust['CreditTerm'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                $cust['BillingCurrency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                $cust['FirstName'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] : '-';
                $cust['LastName'] = $items[$k]['CpNameLast'] ? $items[$k]['CpNameLast'] : '-';
                $xml_dt = $this->_scm_xml($cust);
            }
        } else {
            foreach ($items as $k => $v) {
                $office = $this->get_office_code($items[$k]['Ekorg'], $items[$k]['Bukrs']);

                if ($items[$k]['Lifnr'] == $code) {
                    $cust['Code'] = $items[$k]['Lifnr'];
                    $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                    $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                    $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                    $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                    $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                    $cust['FirstName'] = $items[$k]['NameFirst'] ? $items[$k]['NameFirst'] : '-';
                    $cust['Number'] = $items[$k]['Telf1'] ? $items[$k]['Telf1'] : '-';
                    $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                    $cust['OfficeCode'] = $office['code'] ? $office['code'] : 'SYIT';
                    $cust['OfficeName'] = $office['name'] ? $office['name'] : 'IRON BIRD TRANSPORT JAKARTA';
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
        $MessageDateTime = date('YmdHis');
        $xml_data = '<Message>' .
            '<Header>' .
            '<MessageType>PARTY</MessageType>' .
            '<MessageVersion>1</MessageVersion>' .
            '<MessageIdentifier>4230f614-63f8-4e9b-9a25-a7939ae4fdf4</MessageIdentifier>' .
            '<MessageDateTime>' . $MessageDateTime . '</MessageDateTime>' .
            '</Header>' .
            '<Parties>' .
            '<Party>' .
            '<Action>Add</Action>' .
            '<PartyName>' .
            '<Code>' . $data['Code'] . '</Code>' .
            '<Name>' . $data['Name'] . '</Name>' .
            '</PartyName>' .
            '<SpecialInstructions></SpecialInstructions>' .
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
            '<Code>' . $data['OfficeCode'] . '</Code>' .
            '<Name>' . $data['OfficeName'] . '</Name>' .
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

    public function _get_tokens()
    {
        $CI = &get_instance();
        $CI->db->select('access_token');
        $rc = $CI->db->get_where('tb_token')->row_array();
        return $rc['access_token'];
    }

    public function get_office_code($sap, $entity)
    {
        $CI = &get_instance();
        $CI->db->select('code, name');
        return $CI->db->get_where('tb_map_office', ['sap_code' => $sap, 'entity' => $entity])->row_array();
    }
}
