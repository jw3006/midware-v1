<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FI_Postca
{
    public function _array_sap($data)
    {
        $Period     = substr($data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['FinalizationDate'], 4, 2);
        $items = $data['AdvanceRequest']['AdvanceRequestDetails']['AdvancePostingDetails']['AdvancePosting'];

        $no_acc = 0;
        foreach ($items as $k => $v) {
            $no_acc++;

            $office_code = $this->_office_code($data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['BaseOffice']['Code']);
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
                'Bldat'         => nice_date($data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['Date'], 'Y-m-d'),
                'Blart'         => $doc_type,
                'Budat'         => nice_date($data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['FinalizationDate'], 'Y-m-d'),
                'Monat'         => $Period,
                'Waers'         => $items[$k]['AccountCurrency'],
                'Xblnr'         => $data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['AdvanceNo'],
                'Bktxt'         => $data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['AdvanceNo'],
                'Bukrs'         => $office_code,
                'Hkont'         => $items[$k]['AccountPostingCode'],
                'Wrbtr'         => $amount,
                'Valut'         => nice_date($data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['FinalizationDate'], 'Y-m-d'),
                'Prctr'         => '',
                'Kostl'         => '',
                'Zuonr'         => $data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['AdvanceNo'],
                'Sgtxt'         => $data['AdvanceRequest']['AdvanceRequestDetails']['BasicDetails']['AdvanceNo'],
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
