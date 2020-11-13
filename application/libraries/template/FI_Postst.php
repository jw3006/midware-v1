<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FI_Postst
{
    public function _array_sap($data)
    {
        $Period     = substr($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 4, 2);
        $items = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['AdvancePostingDetails']['AdvancePosting'];

        if ($data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['ChargeDetails']['ChargeDetail'][0]) {
            $Zuonr = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['ChargeDetails']['ChargeDetail'][0]['JobNo'];
        } else {
            $Zuonr = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['ChargeDetails']['ChargeDetail']['JobNo'];
        }

        $no_acc = 0;
        foreach ($items as $k => $v) {
            $no_acc++;

            $office_code = $this->_office_code($data['SettlementDetail']['Settlement']['BasicDetails']['BaseOffice']['Code']);
            if ($office_code == 'IBTO') {
                $doc_type = 'ZL';
            } else {
                $doc_type = 'ZT';
            }

            if ($items[$k]['AccountType'] == 'Dr') {
                $Shkzg = 'S';
                $ref_key = 40;
            } else {
                $Shkzg = 'H';
                $ref_key = 50;
            };

            if ($items[$k]['AccountCurrency'] == 'IDR') {
                $amount = number_format($items[$k]['AccountAmount'], 2, ".", "") / 100;
            } else {
                $amount = number_format($items[$k]['AccountAmount'], 2, ".", "");
            }

            $inputdetail[] = array(
                'LgcBelnr'      => '1',
                'LgcBuzei'      => $no_acc,
                'Bldat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                'Blart'         => $doc_type,
                'Budat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                'Monat'         => $Period,
                'Waers'         => $items[$k]['AccountCurrency'],
                'Xblnr'         => $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'],
                'Bktxt'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['Remark'],
                'Bukrs'         => $office_code,
                'Hkont'         => $items[$k]['AccountPostingCode'],
                'Wrbtr'         => $amount,
                'Valut'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                'Prctr'         => '',
                'Kostl'         => '',
                'Zuonr'         => $Zuonr,
                'Sgtxt'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['Remark'],
                'Shkzg'         => $Shkzg,
                'Lifnr'         => '',
                'Kunnr'         => '',
                'RefLgcBelnr'   => '',
                'FiBelnr'       => '',
                'FiGjahr'       => '',
                'Umskz'         => '',
                'RefKey1'       => $ref_key
            );

            $inputT[] = array(
                'Type'     => '',
                'Id'       => '',
                'Number'   => '',
                'Message'  => '',
                'LogNo'    => '',
                'LogMsgNo' => '',
                'MessageV1' => '',
                'MessageV2' => '',
                'MessageV3' => '',
                'MessageV4' => '',
                'Parameter' => '',
                'Row'      => '',
                'Field'    => '',
                'System'   => ''
            );
        }

        $item = array('item'  => $inputdetail);
        $itemT = array('item' => $inputT);

        $params = array(
            'Fitrxlgc'  => $item,
            'Return'    => $itemT,
            'Test'      => ''
        );

        return $params;
    }

    public function _office_code($oc)
    {
        $CI = &get_instance();
        $CI->db->select('entity');
        $offc = $CI->db->get_where('tb_map_office', ['code' => $oc])->row_array();

        return $offc['entity'];
    }
}
