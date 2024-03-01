<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrialPaket_model extends CI_Model {

	var $table = 'paket';
    var $column_order = array(null,'nama_paket','deskripsi_paket', null, null, null, null);
    var $column_search = array('nama_paket','deskripsi_paket');
    var $order = array('id' => 'asc');
 
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        $this->db->where('is_trial', '1');
 
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('is_trial', '1');
        return $this->db->count_all_results();
    }

}

/* End of file TrialPaket_model.php */
/* Location: ./application/models/TrialPaket_model.php */