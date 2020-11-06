<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FI_Postst
{
    public function _array_sap($data)
    {
        $Period     = substr($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 4, 2);

        $office_code = $this->_office_code($data['SettlementDetail']['Settlement']['BasicDetails']['BaseOffice']['Code']);
        if ($office_code == 'IBTO') {
            $doc_type = 'ZL';
        } else {
            $doc_type = 'ZT';
        }

        # =====Debit=======================

        $items = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['ChargeDetails'];
        $no_acc = 0;
        foreach ($items as $v) {
            if (!$v['JobNo']) {
                foreach ($v as $k => $d) {
                    $no_acc++;
                    if (substr($v[$k]['Charge']['AccountCode'], 0, 1) > 4) {
                        $cost_center = $v[$k]['Charge']['AccountCode'];
                        $cc['CompanyCode'] = $office_code; //sample
                        $cc['OfficeCode'] = $data['SettlementDetail']['Settlement']['BasicDetails']['BaseOffice']['Code']; //sample
                        $cc['ServiceCode'] = $v[$k]['ServiceType']; //sample
                        $cc['VehicleCode'] = 'BOX';
                        $cost_center = $this->_cost_center($cc);
                    } else {
                        $cost_center = '';
                    }

                    if ($data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['OfficeBaseCurrency'] == 'IDR') {
                        $amount = number_format($v[$k]['Amount'], 2, ".", "") / 100;
                    } else {
                        $amount = number_format($v[$k]['Amount'], 2, ".", "");
                    }

                    $inputdetail[] = array(
                        'LgcBelnr'      => '1',
                        'LgcBuzei'      => $no_acc,
                        'Bldat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                        'Blart'         => $doc_type,
                        'Budat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                        'Monat'         => $Period,
                        'Waers'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['OfficeBaseCurrency'],
                        'Xblnr'         => $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'],
                        'Bktxt'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceNo'],
                        'Bukrs'         => $office_code,
                        'Hkont'         => $v[$k]['Charge']['AccountCode'],
                        'Wrbtr'         => $amount,
                        'Valut'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                        'Prctr'         => '',
                        'Kostl'         => $cost_center,
                        'Zuonr'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceNo'],
                        'Sgtxt'         => $v[$k]['JobNo'],
                        'Shkzg'         => 'S',
                        'Lifnr'         => '',
                        'Kunnr'         => '',
                        'RefLgcBelnr'   => '',
                        'FiBelnr'       => '',
                        'FiGjahr'       => '',
                        'Umskz'         => '',
                        'RefKey1'       => '40'
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
            } else {
                $no_acc++;
                if (substr($v['Charge']['AccountCode'], 0, 1) > 4) {
                    $cost_center = $v['Charge']['AccountCode'];
                    $cc['CompanyCode'] = $office_code; //sample
                    $cc['OfficeCode'] = $data['SettlementDetail']['Settlement']['BasicDetails']['BaseOffice']['Code']; //sample
                    $cc['ServiceCode'] = $v['ServiceType']; //sample
                    $cc['VehicleCode'] = 'BOX';
                    $cost_center = $this->_cost_center($cc);
                } else {
                    $cost_center = '';
                }

                if ($data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['OfficeBaseCurrency'] == 'IDR') {
                    $amount = number_format($v['Amount'], 2, ".", "") / 100;
                } else {
                    $amount = number_format($v['Amount'], 2, ".", "");
                }

                $inputdetail[] = array(
                    'LgcBelnr'      => '1',
                    'LgcBuzei'      => $no_acc,
                    'Bldat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                    'Blart'         => $doc_type,
                    'Budat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                    'Monat'         => $Period,
                    'Waers'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['OfficeBaseCurrency'],
                    'Xblnr'         => $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'],
                    'Bktxt'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceNo'],
                    'Bukrs'         => $office_code,
                    'Hkont'         => $v['Charge']['AccountCode'],
                    'Wrbtr'         => $amount,
                    'Valut'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                    'Prctr'         => '',
                    'Kostl'         => $cost_center,
                    'Zuonr'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceNo'],
                    'Sgtxt'         => $v['JobNo'],
                    'Shkzg'         => 'S',
                    'Lifnr'         => '',
                    'Kunnr'         => '',
                    'RefLgcBelnr'   => '',
                    'FiBelnr'       => '',
                    'FiGjahr'       => '',
                    'Umskz'         => '',
                    'RefKey1'       => '40'
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
        }
        #=============================

        # =====Credit=======================

        $amount_adv = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceAmount'];
        $amount_stt = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AmountSettled'];

        $GLs = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['AdvancePostingDetails']['AdvancePosting'];

        if ($amount_adv > $amount_stt) {
            foreach ($GLs as $g => $a) {
                $dtss = $GLs[$g]['AccountType'];
                if ($GLs[$g]['AccountType'] == 'Cr') {
                    $gl_hd = $GLs[$g]['AccountPostingCode'];
                }
            }
        } else {
            foreach ($GLs as $g => $a) {
                $dtss = $GLs[$g]['AccountType'];
                if ($GLs[$g]['AccountType'] == 'Dr') {
                    $gl_hd = $GLs[$g]['AccountPostingCode'];
                }
            }
        }

        if ($data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['OfficeBaseCurrency'] == 'IDR') {
            $amount_hd = number_format($amount_stt, 2, ".", "") / 100;
        } else {
            $amount_hd = number_format($amount_stt, 2, ".", "");
        }

        $inputdetail[] = array(
            'LgcBelnr'      => '1',
            'LgcBuzei'      => $no_acc + 1,
            'Bldat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
            'Blart'         => $doc_type,
            'Budat'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
            'Monat'         => $Period,
            'Waers'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['OfficeBaseCurrency'],
            'Xblnr'         => $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'],
            'Bktxt'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceNo'],
            'Bukrs'         => $office_code,
            'Hkont'         => $gl_hd,
            'Wrbtr'         => $amount_hd,
            'Valut'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
            'Prctr'         => '',
            'Kostl'         => '',
            'Zuonr'         => $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceNo'],
            'Sgtxt'         => $v['JobNo'],
            'Shkzg'         => 'H',
            'Lifnr'         => '',
            'Kunnr'         => '',
            'RefLgcBelnr'   => '',
            'FiBelnr'       => '',
            'FiGjahr'       => '',
            'Umskz'         => '',
            'RefKey1'       => '50'
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

        #=============================

        $item = array('item'  => $inputdetail);
        $itemT = array('item' => $inputT);

        $params = array(
            'Fitrxlgc'  => $item,
            'Return'    => $itemT,
            'Test'      => ''
        );

        return $params;
    }


    public function _array_sap1($data)
    {
        $Period     = substr($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 4, 2);
        $items = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['AdvancePostingDetails']['AdvancePosting'];

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
                'Bktxt'         => 'Additional or Refund',
                'Bukrs'         => $office_code,
                'Hkont'         => $items[$k]['AccountPostingCode'],
                'Wrbtr'         => $amount,
                'Valut'         => nice_date($data['SettlementDetail']['Settlement']['BasicDetails']['Date'], 'Y-m-d'),
                'Prctr'         => '',
                'Kostl'         => '',
                'Zuonr'         => $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'],
                'Sgtxt'         => $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'] . '- RF or AD',
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

        $params_add = array(
            'Fitrxlgc'  => $item,
            'Return'    => $itemT,
            'Test'      => ''
        );

        return $params_add;
    }

    public function _office_code($oc)
    {
        $CI = &get_instance();
        $CI->db->select('entity');
        $offc = $CI->db->get_where('tb_map_office', ['code' => $oc])->row_array();

        return $offc['entity'];
    }

    public function _cost_center($cc)
    {
        $CI = &get_instance();
        $CI->db->select('profit_cost');

        if ($cc['CompanyCode'] == 'IBTO') {
            $rc = $CI->db->get_where('tb_map_pc', ['office_code' => $cc['OfficeCode'], 'service_code' => $cc['ServiceCode'], 'type' => 'CC'])->row_array();
            return $rc['profit_cost'];
        } else {
            $rc = $CI->db->get_where('tb_map_pc', ['office_code' => $cc['OfficeCode'], 'material_code' => $cc['VehicleCode'], 'type' => 'CC'])->row_array();
            return $rc['profit_cost'];
        }
    }
}
