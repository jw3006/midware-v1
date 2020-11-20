<?php

class Interface_Model extends CI_Model
{
    public function get_all($id = '')
    {
        if ($id == '') {
            $qry = "SELECT a.*, COUNT(id) as CountID  
                        FROM tb_interfaces a
						GROUP BY interfaces, code
                        ";
            return $this->db->query($qry)->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['id' => $id])->row();
        }
    }

    public function get_success()
    {
        return $this->db->get('tb_success')->result();
    }

    public function get_detail($mode, $code)
    {
        return $this->db->get_where('tb_interfaces', ['interfaces' => $mode, 'descriptions' => $code])->result();
    }

    public function get_profitcost($type)
    {
        if ($type == 'CC') {
            return $this->db->get_where('tb_map_pc')->result();
        } else {
            return $this->db->get_where('tb_map_pc', ['material_code' => 'Any'])->result();
        }
    }

    public function get_office_code()
    {
        $this->db->order_by('entity', 'DESC');
        return $this->db->get('tb_map_office')->result();
    }

    public function get_services()
    {
        return $this->db->get('tb_map_service')->result();
    }

    public function get_material()
    {
        return $this->db->get('tb_map_material')->result();
    }

    public function get_vehicle()
    {
        $this->db->group_by('category');
        return $this->db->get('tb_map_vehicle')->result();
    }

    public function get_pc($type)
    {
        if ($type == 'CC') {
            return $this->db->get('tb_map_profitcost')->result();
        } else {
            $this->db->group_by('profit_center');
            return $this->db->get('tb_map_profitcost')->result();
        }
    }

    public function get_customer($cus = '')
    {
        if ($cus == '') {
            $this->db->where('interfaces', 'customer');
            $this->db->order_by('proTime', 'DESC');
            return $this->db->get('tb_interfaces')->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['customer' => $cus])->num_rows();
        }
    }

    public function get_vendor($ven = '')
    {
        if ($ven == '') {
            $this->db->where('interfaces', 'vendor');
            $this->db->order_by('proTime', 'DESC');
            return $this->db->get('tb_interfaces')->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['vendor' => $ven])->num_rows();
        }
    }

    public function get_advance($adv = '')
    {
        if ($adv == '') {
            $this->db->where('interfaces', 'advance');
            $this->db->order_by('proTime', 'DESC');
            return $this->db->get('tb_interfaces')->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['advance' => $adv])->num_rows();
        }
    }

    public function get_settlement($stt = '')
    {
        if ($stt == '') {
            $this->db->where('interfaces', 'settlement');
            $this->db->order_by('proTime', 'DESC');
            return $this->db->get('tb_interfaces')->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['settlement' => $stt])->num_rows();
        }
    }

    public function get_ar($ar = '')
    {
        if ($ar == '') {
            $this->db->where('interfaces', 'receivable');
            $this->db->order_by('proTime', 'DESC');
            return $this->db->get('tb_interfaces')->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['receivable' => $ar])->num_rows();
        }
    }

    public function get_ap($ap = '')
    {
        if ($ap == '') {
            $this->db->where('interfaces', 'payable');
            $this->db->order_by('proTime', 'DESC');
            return $this->db->get('tb_interfaces')->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['payable' => $ap])->num_rows();
        }
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
