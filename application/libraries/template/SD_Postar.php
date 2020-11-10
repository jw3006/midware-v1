<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SD_Postar
{
    public function _array_sap($data)
    {
        $Period     = substr($data['Invoices']['InvoiceInfo']['ApprovedOn'], 4, 2);
        $items_ar = $data['Invoices']['InvoiceInfo']['Charges']['ChargeInfo'];

        $office_code = $this->_office_code($data['Invoices']['InvoiceInfo']['Office']);
        if ($office_code == 'IBTO') {
            $doc_type = 'ZL';
        } else {
            $doc_type = 'ZT';
        }

        if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "") / 100;
        } else {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "");
        }

        //==========Detail AR ==================================================
        $inputHd[] = array(
            'LgcBelnr'      => '1',
            'LgcBuzei'      => '1',
            'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
            'Blart'         => $doc_type,
            'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
            'Monat'         => $Period,
            'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
            'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
            'Bukrs'         => $office_code,
            'Hkont'         => $data['Invoices']['InvoiceInfo']['Debtor']['AccountCode'],
            'Wrbtr'         => $amount_head,
            'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
            'Prctr'         => '',
            'Kostl'         => '',
            'Zuonr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Sgtxt'         => '',
            'Shkzg'         => 'S',
            'Lifnr'         => '',
            'Kunnr'         => $data['Invoices']['InvoiceInfo']['Debtor']['Code'],
            'RefLgcBelnr'   => '',
            'FiBelnr'       => '',
            'FiGjahr'       => '',
            'Umskz'         => '',
            'RefKey1'       => '01'
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
        //==========Detail Revenue =============================================
        $no_acc = 1;
        foreach ($items_ar as $k => $v) {
            $no_acc++;

            $cc['CompanyCode'] = $office_code; //sample
            $cc['OfficeCode']  = $data['Invoices']['InvoiceInfo']['Office']; //sample
            $cc['ServiceCode'] = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobType']; //sample
            $cc['VehicleCode'] = 'BOX'; //sample
            $profit_center = $this->_profit_center($cc);

            if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
                $amount = number_format($items_ar[$k]['ChargeAmount'], 2, ".", "") / 100;
            } else {
                $amount = number_format($items_ar[$k]['ChargeAmount'], 2, ".", "");
            }

            $inputAR[] = array(
                'LgcBelnr'      => '1',
                'LgcBuzei'      => $no_acc,
                'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
                'Blart'         => $doc_type,
                'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
                'Monat'         => $Period,
                'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
                'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
                'Bukrs'         => $office_code,
                'Hkont'         => $items_ar[$k]['PostingCode'],
                'Wrbtr'         => $amount,
                'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
                'Prctr'         => $profit_center,
                'Kostl'         => '',
                'Zuonr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                'Sgtxt'         => '',
                'Shkzg'         => 'H',
                'Lifnr'         => '',
                'Kunnr'         => '',
                'RefLgcBelnr'   => '',
                'FiBelnr'       => '',
                'FiGjahr'       => '',
                'Umskz'         => '',
                'RefKey1'       => '50'
            );

            $inputTAR[] = array(
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
        //==========Detail VAT==================================================
        foreach ($items_ar as $p => $v) {
            if ($items_ar[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'] > 0) {
                $no_acc++;

                if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
                    $amount_tax = number_format($items_ar[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "") / 100;
                } else {
                    $amount_tax = number_format($items_ar[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "");
                }

                $inputTax[] = array(
                    'LgcBelnr'      => '1',
                    'LgcBuzei'      => $no_acc,
                    'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
                    'Blart'         => $doc_type,
                    'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
                    'Monat'         => $Period,
                    'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
                    'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                    'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
                    'Bukrs'         => $office_code,
                    'Hkont'         => $items_ar[$p]['ChargeTaxes']['ChargeTaxInfo']['TaxAccountMapped'],
                    'Wrbtr'         => $amount_tax,
                    'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
                    'Prctr'         => '',
                    'Kostl'         => '',
                    'Zuonr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                    'Sgtxt'         => '',
                    'Shkzg'         => 'H',
                    'Lifnr'         => '',
                    'Kunnr'         => '',
                    'RefLgcBelnr'   => '',
                    'FiBelnr'       => '',
                    'FiGjahr'       => '',
                    'Umskz'         => '',
                    'RefKey1'       => '50'
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
        $inputdetail = array_merge($inputHd, $inputAR, $inputTax);
        $inputT = array_merge($inputTHd, $inputTAR, $inputTTax);

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
        $Period     = substr($data['Invoices']['InvoiceInfo']['ApprovedOn'], 4, 2);
        $items_ar = $data['Invoices']['InvoiceInfo']['Charges']['ChargeInfo'];

        $office_code = $this->_office_code($data['Invoices']['InvoiceInfo']['Office']);
        if ($office_code == 'IBTO') {
            $doc_type = 'ZL';
        } else {
            $doc_type = 'ZT';
        }

        if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "") / 100;
        } else {
            $amount_head = number_format($data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'], 2, ".", "");
        }

        //==========Detail AR ==================================================
        $inputHd[] = array(
            'LgcBelnr'      => '1',
            'LgcBuzei'      => '1',
            'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
            'Blart'         => $doc_type,
            'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
            'Monat'         => $Period,
            'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
            'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
            'Bukrs'         => $office_code,
            'Hkont'         => $data['Invoices']['InvoiceInfo']['Debtor']['AccountCode'],
            'Wrbtr'         => $amount_head,
            'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
            'Prctr'         => '',
            'Kostl'         => '',
            'Zuonr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Sgtxt'         => '',
            'Shkzg'         => 'S',
            'Lifnr'         => '',
            'Kunnr'         => $data['Invoices']['InvoiceInfo']['Debtor']['Code'],
            'RefLgcBelnr'   => '',
            'FiBelnr'       => '',
            'FiGjahr'       => '',
            'Umskz'         => '',
            'RefKey1'       => '01'
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
        //==========Detail Revenue =============================================


        $cc['CompanyCode'] = $office_code; //sample
        $cc['OfficeCode']  = $data['Invoices']['InvoiceInfo']['Office']; //sample
        $cc['ServiceCode'] = $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobType']; //sample
        $cc['VehicleCode'] = 'BOX'; //sample
        $profit_center = $this->_profit_center($cc);

        if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
            $amount = number_format($items_ar['ChargeAmount'], 2, ".", "") / 100;
        } else {
            $amount = number_format($items_ar['ChargeAmount'], 2, ".", "");
        }

        $inputAR[] = array(
            'LgcBelnr'      => '1',
            'LgcBuzei'      => '2',
            'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
            'Blart'         => $doc_type,
            'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
            'Monat'         => $Period,
            'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
            'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
            'Bukrs'         => $office_code,
            'Hkont'         => $items_ar['PostingCode'],
            'Wrbtr'         => $amount,
            'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
            'Prctr'         => $profit_center,
            'Kostl'         => '',
            'Zuonr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'Sgtxt'         => '',
            'Shkzg'         => 'H',
            'Lifnr'         => '',
            'Kunnr'         => '',
            'RefLgcBelnr'   => '',
            'FiBelnr'       => '',
            'FiGjahr'       => '',
            'Umskz'         => '',
            'RefKey1'       => '50'
        );

        $inputTAR[] = array(
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
        //==========Detail VAT==================================================

        if ($items_ar['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'] > 0) {

            if ($data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'] == 'IDR') {
                $amount_tax = number_format($items_ar['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "") / 100;
            } else {
                $amount_tax = number_format($items_ar['ChargeTaxes']['ChargeTaxInfo']['TaxBillingAmount'], 2, ".", "");
            }

            $inputTax[] = array(
                'LgcBelnr'      => '1',
                'LgcBuzei'      => '3',
                'Bldat'         => nice_date($data['Invoices']['InvoiceInfo']['InvoiceDate'], 'Y-m-d'),
                'Blart'         => $doc_type,
                'Budat'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
                'Monat'         => $Period,
                'Waers'         => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
                'Xblnr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                'Bktxt'         => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
                'Bukrs'         => $office_code,
                'Hkont'         => $items_ar['ChargeTaxes']['ChargeTaxInfo']['TaxAccountMapped'],
                'Wrbtr'         => $amount_tax,
                'Valut'         => nice_date($data['Invoices']['InvoiceInfo']['ApprovedOn'], 'Y-m-d'),
                'Prctr'         => '',
                'Kostl'         => '',
                'Zuonr'         => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
                'Sgtxt'         => '',
                'Shkzg'         => 'H',
                'Lifnr'         => '',
                'Kunnr'         => '',
                'RefLgcBelnr'   => '',
                'FiBelnr'       => '',
                'FiGjahr'       => '',
                'Umskz'         => '',
                'RefKey1'       => '50'
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

        $inputdetail = array_merge($inputHd, $inputAR, $inputTax);
        $inputT = array_merge($inputTHd, $inputTAR, $inputTTax);

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

    public function _profit_center($cc)
    {
        $CI = &get_instance();
        $CI->db->select('profit_cost');

        if ($cc['CompanyCode'] == 'IBTO') {
            $rc = $CI->db->get_where('tb_map_pc', ['office_code' => $cc['OfficeCode'], 'service_code' => $cc['ServiceCode'], 'type' => 'PC'])->row_array();
            return $rc['profit_cost'];
        } else {
            $rc = $CI->db->get_where('tb_map_pc', ['office_code' => $cc['OfficeCode'], 'material_code' => $cc['VehicleCode'], 'type' => 'PC'])->row_array();
            return $rc['profit_cost'];
        }
    }
}
