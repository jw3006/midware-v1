<?php

class Mapping_Model extends CI_Model
{
    public function get_profitcost($id)
    {
        $this->db->where('type', $id);
        return $this->db->get('tb_map_pc')->result();
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

    public function get_pc($id)
    {
        $this->db->where('type', $id);
        return $this->db->get('tb_map_profitcost')->result();
    }

    public function save($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id)
            ->update('tb_map_pc', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('tb_map_pc', array('id' => $id));
    }

    public function map_setting_update($id, $data)
    {
        $this->db->where('id', $id)
            ->update('tb_map_config', $data);
    }

    public function get_cm_posted()
    {
        return $this->db->get('tb_map_posted_cm')->result();
    }

    public function get_ledger()
    {
        return $this->db->get('tb_map_ledger')->result();
    }

    public function role_posted_update($id, $data)
    {
        $this->db->where('id', $id)
            ->update('tb_map_posted_cm', $data);
    }

    public function role_posted_delete($id)
    {
        return $this->db->delete('tb_map_posted_cm', array('id' => $id));
    }
}
