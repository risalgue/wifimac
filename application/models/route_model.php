<?php
class Route_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    public function GetAvailableIpForGroup($group){
        $this->db->select('*');
        $this->db->from('router');
        $this->db->where('ip_group',$group);
        $this->db->where('ip_status','active');
        $this->db->order_by('ip_id', 'ASC');
        $this->db->limit(1);
        $query=$this->db->get();
        
        if($query->num_rows()>0){
            return $query->row_array();
        }
        else{
            return FALSE;
        }
    }

    public function disable_ip($ip){
        $router  = array('ip_status' => 'disable');
        $this->db->where('ip_address', $ip);
        $data = $this->db->update('router',$router);
    }
}
?>