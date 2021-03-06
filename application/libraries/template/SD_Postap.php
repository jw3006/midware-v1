<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SD_Postap
{
    public function _array_sap($data)
    {
        $Period     = substr($data['Invoices']['InvoiceInfo']['PostedOn'], 4, 2);
        $items_ap = $data['Invoices']['InvoiceInfo']['Charges']['ChargeInfo'];
        $ck_vat = count($data['Invoices']['InvoiceInfo']['AmountSummary']['TaxSummary']);

        $inv_type = $data['Invoices']['InvoiceInfo']['InvoiceType'];
        if ($inv_type !== 'CashExpense') {
            $Lifnr = $data['Invoices']['InvoiceInfo']['Vendor']['Code'];
            $RefKey1 = '31';
            $key_code = 'Any';
            $Zuonr = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'];
        } else {
            $Lifnr = '';
            $RefKey1 = '50';
            $key_code = $data['Invoices']['InvoiceInfo']['Vendor']['Code'];
            $Zuonr = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'];
        }

        //==========Detail Cost AP ==================================================
        $no_acc = 0;
        foreach ($items_ap as $k => $v) {
            $no_acc++;

            $office_code = $this->_office_code($data['Invoices']['InvoiceInfo']['Office']);
            if ($office_code == 'IBTO') {
                $doc_type = 'ZL';
            } else {
                $doc_type = 'ZT';
            }

            $cc['CompanyCode'] = $office_code; //sample
            $cc['OfficeCode'] = $data['Invoices']['InvoiceInfo']['Office']; //sample
            $cc['ServiceCode'] = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['ServiceClassCode']; //sample
            $cc['KeyCode'] = $key_code; //sample
            $cc['VehicleCode'] = $this->_vehicle_type('TRAILER FL10'); //sample
            $cost_center = $this->_cost_center($cc);

            if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
                $amount = number_format($items_ap[$k]['ChargeAmount'], 2, ".", "") / 100;
            } else {
                $amount = number_format($items_ap[$k]['ChargeAmount'], 2, ".", "");
            }

            $inputAP[] = array(
                'LgcBelnr'      => '1',
                'LgcBuzei'      => $no_acc,
                'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
                'Blart'         => $doc_type,
                'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
                'Monat'         => $Period,
                'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
                'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
                'Bukrs'         => $office_code,
                'Hkont'         => $items_ap[$k]['PostingCode'],
                'Wrbtr'         => $amount,
                'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
                'Prctr'         => '',
                'Kostl'         => $cost_center,
                'Zuonr'         => $Zuonr,
                'Sgtxt'         => substr($items_ap[$k]['ChargeDescription'], 0, 50),
                'Shkzg'         => 'S',
                'Lifnr'         => '',
                'Kunnr'         => '',
                'RefLgcBelnr'   => '',
                'FiBelnr'       => '',
                'FiGjahr'       => '',
                'Umskz'         => '',
                'RefKey1'       => '40'
            );

            $inputTAP[] = array(
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

        //======================================================================
        //==========Detail VAT =================================================
        foreach ($items_ap as $p => $v) {
            if ($items_ap[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'] > 0) {
                $no_acc++;

                if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
                    $amount_tax = number_format($items_ap[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "") / 100;
                } else {
                    $amount_tax = number_format($items_ap[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "");
                }

                $inputTax[] = array(
                    'LgcBelnr'      => '1',
                    'LgcBuzei'      => $no_acc,
                    'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
                    'Blart'         => $doc_type,
                    'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
                    'Monat'         => $Period,
                    'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
                    'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                    'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
                    'Bukrs'         => $office_code,
                    'Hkont'         => $items_ap[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxAccountMapped'],
                    'Wrbtr'         => $amount_tax,
                    'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
                    'Prctr'         => '',
                    'Kostl'         => '',
                    'Zuonr'         => $Zuonr,
                    'Sgtxt'         => '',
                    'Shkzg'         => 'S',
                    'Lifnr'         => '',
                    'Kunnr'         => '',
                    'RefLgcBelnr'   => '',
                    'FiBelnr'       => '',
                    'FiGjahr'       => '',
                    'Umskz'         => '',
                    'RefKey1'       => '40'
                );

                $inputTTax[] = array(
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

        //======================================================================
        //==========Detail AP ==================================================
        if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "") / 100;
        } else {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "");
        }

        $inputHd[] = array(
            'LgcBelnr'      => '1',
            'LgcBuzei'      => $no_acc + 1,
            'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
            'Blart'         => $doc_type,
            'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
            'Monat'         => $Period,
            'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
            'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
            'Bukrs'         => $office_code,
            'Hkont'         => $data['Invoices']['InvoiceInfo']['Vendor']['AccountCode'],
            'Wrbtr'         => $amount_head,
            'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
            'Prctr'         => '',
            'Kostl'         => '',
            'Zuonr'         => $Zuonr,
            'Sgtxt'         => '',
            'Shkzg'         => 'H',
            'Lifnr'         => $Lifnr,
            'Kunnr'         => '',
            'RefLgcBelnr'   => '',
            'FiBelnr'       => '',
            'FiGjahr'       => '',
            'Umskz'         => '',
            'RefKey1'       => $RefKey1
        );

        $inputTHd[] = array(
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
        //======================================================================
        if ($ck_vat > 0) {
            $inputdetail = array_merge($inputAP, $inputTax, $inputHd);
            $inputT = array_merge($inputTAP, $inputTTax, $inputTHd);
        } else {
            $inputdetail = array_merge($inputAP, $inputHd);
            $inputT = array_merge($inputTAP, $inputTHd);
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

    public function _array_sap1($data)
    {
        $Period     = substr($data['Invoices']['InvoiceInfo']['PostedOn'], 4, 2);
        $items_ap = $data['Invoices']['InvoiceInfo']['Charges']['ChargeInfo'];
        $ck_vat = count($data['Invoices']['InvoiceInfo']['AmountSummary']['TaxSummary']);

        $inv_type = $data['Invoices']['InvoiceInfo']['InvoiceType'];
        if ($inv_type !== 'CashExpense') {
            $Lifnr = $data['Invoices']['InvoiceInfo']['Vendor']['Code'];
            $RefKey1 = '31';
            $key_code = 'Any';
            $Zuonr = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'];
        } else {
            $Lifnr = '';
            $RefKey1 = '50';
            $key_code = $data['Invoices']['InvoiceInfo']['Vendor']['Code'];
            $Zuonr = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'];
        }

        $office_code = $this->_office_code($data['Invoices']['InvoiceInfo']['Office']);
        if ($office_code == 'IBTO') {
            $doc_type = 'ZL';
        } else {
            $doc_type = 'ZT';
        }

        $cc['CompanyCode'] = $office_code; //sample
        $cc['OfficeCode'] = $data['Invoices']['InvoiceInfo']['Office']; //sample
        $cc['ServiceCode'] = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['ServiceClassCode']; //sample
        $cc['KeyCode'] = $key_code; //sample
        $cc['VehicleCode'] = $this->_vehicle_type('TRAILER FL10');
        $cost_center = $this->_cost_center($cc);

        if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
            $amount = number_format($items_ap['ChargeAmount'], 2, ".", "") / 100;
        } else {
            $amount = number_format($items_ap['ChargeAmount'], 2, ".", "");
        }

        //==========Detail Cost AP ==================================================
        $inputAP[] = array(
            'LgcBelnr'      => '1',
            'LgcBuzei'      => '1',
            'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
            'Blart'         => $doc_type,
            'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
            'Monat'         => $Period,
            'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
            'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
            'Bukrs'         => $office_code,
            'Hkont'         => $items_ap['PostingCode'],
            'Wrbtr'         => $amount,
            'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
            'Prctr'         => '',
            'Kostl'         => $cost_center,
            'Zuonr'         => $Zuonr,
            'Sgtxt'         => substr($items_ap['ChargeDescription'], 0, 50),
            'Shkzg'         => 'S',
            'Lifnr'         => '',
            'Kunnr'         => '',
            'RefLgcBelnr'   => '',
            'FiBelnr'       => '',
            'FiGjahr'       => '',
            'Umskz'         => '',
            'RefKey1'       => '40'
        );

        $inputTAP[] = array(
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

        //======================================================================
        //==========Detail VAT =================================================
        if ($items_ap['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'] > 0) {

            if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
                $amount_tax = number_format($items_ap['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "") / 100;
            } else {
                $amount_tax = number_format($items_ap['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "");
            }

            $inputTax[] = array(
                'LgcBelnr'      => '1',
                'LgcBuzei'      => '2',
                'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
                'Blart'         => $doc_type,
                'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
                'Monat'         => $Period,
                'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
                'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
                'Bukrs'         => $office_code,
                'Hkont'         => $items_ap['ChargeTaxes']['ChargeTaxInfo']['TaxAccountMapped'],
                'Wrbtr'         => $amount_tax,
                'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
                'Prctr'         => '',
                'Kostl'         => '',
                'Zuonr'         => $Zuonr,
                'Sgtxt'         => '',
                'Shkzg'         => 'S',
                'Lifnr'         => '',
                'Kunnr'         => '',
                'RefLgcBelnr'   => '',
                'FiBelnr'       => '',
                'FiGjahr'       => '',
                'Umskz'         => '',
                'RefKey1'       => '40'
            );

            $inputTTax[] = array(
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

        //======================================================================
        //==========Detail AP ==================================================
        if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "") / 100;
        } else {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "");
        }

        $inputHd[] = array(
            'LgcBelnr'      => '1',
            'LgcBuzei'      => '3',
            'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
            'Blart'         => $doc_type,
            'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
            'Monat'         => $Period,
            'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
            'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
            'Bukrs'         => $office_code,
            'Hkont'         => $data['Invoices']['InvoiceInfo']['Vendor']['AccountCode'],
            'Wrbtr'         => $amount_head,
            'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['PostedOn'], 'Y-m-d'),
            'Prctr'         => '',
            'Kostl'         => $cost_center,
            'Zuonr'         => $Zuonr,
            'Sgtxt'         => '',
            'Shkzg'         => 'H',
            'Lifnr'         => $Lifnr,
            'Kunnr'         => '',
            'RefLgcBelnr'   => '',
            'FiBelnr'       => '',
            'FiGjahr'       => '',
            'Umskz'         => '',
            'RefKey1'       => $RefKey1
        );

        $inputTHd[] = array(
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
        //======================================================================
        if ($ck_vat > 0) {
            $inputdetail = array_merge($inputAP, $inputTax, $inputHd);
            $inputT = array_merge($inputTAP, $inputTTax, $inputTHd);
        } else {
            $inputdetail = array_merge($inputAP, $inputHd);
            $inputT = array_merge($inputTAP, $inputTHd);
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

    public function _vehicle_type($type)
    {
        $CI = &get_instance();
        $CI->db->select('category');
        $vtype = $CI->db->get_where('tb_map_vehicle', ['code' => $type])->row_array();

        return $vtype['category'];
    }

    public function _cost_center($cc)
    {
        $CI = &get_instance();
        $CI->db->select('cost_center');
        $rc = $CI->db->get_where('tb_map_pc', ['office_code' => $cc['OfficeCode'], 'service_code' => $cc['ServiceCode'], 'material_code' => $cc['KeyCode'], 'vehicle_type' => $cc['VehicleCode']])->row_array();
        return $rc['cost_center'];
    }
}
