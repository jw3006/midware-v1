<?php

class Receipt_Model extends CI_Model
{
    public function get_all($id = '')
    {
        if ($id == '') {

            $this->db->select('a.*, b.name as debtor_name');
            $this->db->from('tb_app_receipt a');
            $this->db->join('tb_debtor b', 'b.code = a.debtor_code');
            $this->db->order_by('a.doc_date', 'DESC');
            $this->db->limit(10);
            return $this->db->get()->result();
        } else {
            return $this->db->get_where('tb_app_receipt', ['id' => $id])->row();
        }
    }

    public function get_invoice($office_code, $debtor_code)
    {
        return $this->db->get_where('tb_invoice', ['office_code' => $office_code, 'debtor_code' => $debtor_code, 'receipt_code' => ''])->result();
    }

    public function get_bill_header($code)
    {
        return $this->db->get_where('tb_app_receipt', ['code' => $code])->row();
    }

    public function get_bill_detail($code)
    {
        return $this->db->get_where('tb_app_receipt_items', ['code' => $code])->result();
    }

    public function get_pattern($off_code)
    {
        $qry = "SELECT max(RIGHT(Code,7)) as noakhir FROM tb_app_receipt";
        $row = $this->db->query($qry)->num_rows();
        if ($row > 0) {
            $res = $this->db->query($qry);
            foreach ($res->result() as $k) {
                $tmp = ((int) $k->noakhir) + 1;
                $kode    = sprintf("%07s", $tmp);
            }
        } else {
            $kode    = '0000001';
        }
        return $off_code . '-' . date('y') . $kode;
    }

    public function get_print_header($code)
    {
        $this->db->select('a.code, a.doc_date, a.due_date, a.company_code, a.debtor_code, a.terms,  
						   b.name as debtor_name, b.address, b.city, b.zip_code, b.npwp, a.contact_person');
        $this->db->from('tb_app_receipt a');
        $this->db->where('a.code', $code);
        $this->db->join('tb_debtor b', 'b.code = a.debtor_code');
        return $this->db->get()->row();
    }

    public function get_print_detail($code)
    {
        $this->db->select('a.code, a.inv_no, a.remarks, b.job_number, b.inv_date, b.job_type, b.amount, b.tax_amount');
        $this->db->from('tb_app_receipt_items a');
        $this->db->where('a.code', $code);
        $this->db->join('tb_invoice b', 'b.code = a.inv_no');
        return $this->db->get()->result();
        //return $this->db->get_where('tb_app_receipt_items', ['code' => $code])->result();
    }

    public function get_office_code()
    {
        $this->db->select('b.code, b.name');
        $this->db->from('tb_invoice a');
        $this->db->join('tb_map_office b', 'b.code = a.office_code');
        $this->db->group_by("office_code");
        return $this->db->get()->result();
    }

    public function get_debtor_code()
    {
        $this->db->select('b.code, b.name, b.credit_term');
        $this->db->from('tb_invoice a');
        $this->db->join('tb_debtor b', 'b.code = a.debtor_code');
        $this->db->group_by("debtor_code");
        return $this->db->get()->result();
    }

    public function get_company_code($office_code)
    {
        $this->db->select('entity');
        return $this->db->get_where('tb_map_office', ['code' => $office_code])->row();
    }

    public function get_notif()
    {
        $result = array(
            'customer' => $this->db->where('interfaces', 'customer')->count_all_results('tb_interfaces'),
            'vendor' => $this->db->where('interfaces', 'vendor')->count_all_results('tb_interfaces'),
            'advance' => $this->db->where('interfaces', 'advance')->count_all_results('tb_interfaces'),
            'settlement' => $this->db->where('interfaces', 'settlement')->count_all_results('tb_interfaces'),
            'receivable' => $this->db->where('interfaces', 'receivable')->count_all_results('tb_interfaces'),
            'payable' => $this->db->where('interfaces', 'payable')->count_all_results('tb_interfaces')
        );
        return $result;
    }
}
