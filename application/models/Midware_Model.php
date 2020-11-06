<?php

class Midware_Model extends CI_Model
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

    public function get_cr($cr = '')
    {
        if ($cr == '') {
            $this->db->where('interfaces', 'cr');
            $this->db->order_by('proTime', 'DESC');
            return $this->db->get('tb_interfaces')->result();
        } else {
            return $this->db->get_where('tb_interfaces', ['cr' => $cr])->num_rows();
        }
    }

    public function notif_cus()
    {
        return $this->db->where('interfaces', 'customer')->count_all_results('tb_interfaces');
    }

    public function notif_ven()
    {
        return $this->db->where('interfaces', 'vendor')->count_all_results('tb_interfaces');
    }

    public function notif_adv()
    {
        return $this->db->where('interfaces', 'advance')->count_all_results('tb_interfaces');
    }

    public function notif_stt()
    {
        return $this->db->where('interfaces', 'settlement')->count_all_results('tb_interfaces');
    }

    public function notif_ar()
    {
        return $this->db->where('interfaces', 'receivable')->count_all_results('tb_interfaces');
    }

    public function notif_ap()
    {
        return $this->db->where('interfaces', 'payable')->count_all_results('tb_interfaces');
    }

    public function notif_cr()
    {
        return $this->db->where('interfaces', 'credit limit')->count_all_results('tb_interfaces');
    }

    public function insert_tb_interface($code, $messages, $frontend_text, $backend_text, $type, $mode)
    {
        $detail = array(
            'id'            => uniqid(),
            'code'          => $code,
            'proTime'       => date('Y-m-d H:i:s'),
            'interfaces'    => $type,
            'directions'    => $mode,
            'descriptions'  => $code,
            'messages'      => $messages,
            'frontend_text' => $frontend_text,
            'backend_text'  => $backend_text
        );
        $this->db->insert('tb_interfaces', $detail);
    }

    public function update_tb_interface($id, $messages)
    {
        $detail = array(
            'proTime'       => date('Y-m-d H:i:s'),
            'messages'      => $messages
        );
        $this->db->where('id', $id)
            ->update('tb_interfaces', $detail);
    }

    public function insert_tb_success($code, $JMessages, $type)
    {
        $detail = array(
            'id'              => uniqid(),
            'code'          => $code,
            'proTime'       => date('Y-m-d H:i:s'),
            'interfaces'    => $type,
            'messages'      => $JMessages
        );
        $this->db->insert('tb_success', $detail);
    }

    public function insert_tb_debtor($code, $data)
    {
        $row = $this->db->get_where('tb_debtor', ['code' => $code])->num_rows();
        if ($row > 0) {
            $this->db->where('code', $code)
                ->update('tb_debtor', $data);
        } else {
            $this->db->insert('tb_debtor', $data);
        }
    }

    public function get_json($id)
    {
        $qrSql = "SELECT a.id, a.code, a.frontend_text, a.backend_text
                        FROM tb_interfaces a
                        WHERE a.id='$id'
                        ";
        return $this->db->query($qrSql)->row_array();
    }

    public function delete($id)
    {
        return $this->db->delete('tb_interfaces', array('id' => $id));
    }

    public function get_cost_setting($type)
    {
        return $this->db->get_where('tb_map_config', ['type' => $type])->row_array();
    }
}
