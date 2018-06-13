<?php
class User_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function register_user($user){
        $query = $this->db->get_where('roll', array('roll_name' => $user['roll_name']));
        if ($query) {
            $row = $query->row_array();
            $user_roll_id = $row['user_roll_id'];
            $user['user_roll_id'] = $user_roll_id;
            $userToDB = array('user_roll_id' => $user_roll_id,
                              'user_name' => $user['user_name'],
                              'user_email' => $user['user_email']);
            $queryInsert = $this->db->insert('user', $userToDB);
            if ($queryInsert){
                return TRUE;
            }
        }
        else {
            return false;
        }
        
    }
    public function all_users(){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('roll','user.user_roll_id = roll.user_roll_id');
        $query=$this->db->get();
        return $query->result();
    }
    public function login_user($user_login){
        // for($i=64;$i < 128;$i++){
        //     for($j=1;$j < 255;$j++){
        //         $group = 'estudiantes';
        //         if ($i > 84 and $i <= 100){
        //             $group = 'profesores';
        //         }
        //         else if ($i > 100 and $i <= 116) {
        //             $group = 'no_docentes';
        //         } 
        //         else if ($i > 116 and $i <= 124){
        //             $group = 'invitados';
        //         }
        //         else if ($i > 124){
        //             $group = 'wifiadmins';
        //         }
        //         $route=array(
        //             'ip_address'=>'10.33.'.$i.'.'.$j,
        //             'ip_group'=>$group,
        //             'ip_status'=>'active');
        //         $this->db->insert('router',$route);
        //     }
        // }
        $email = $user_login['user_email'];
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_email',$email);
        $this->db->join('roll','user.user_roll_id = roll.user_roll_id');
        $query=$this->db->get();
        
        if($query->num_rows()>0){
            return $query->row_array();
        }
        else{
            $registered = $this->register_user($user_login);
            if ($registered) {
                return $this->login_user($user_login);
            }
            else {
                return FALSE;
            }
        }
    }
    public function email_check($email){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_email',$email);
        $query=$this->db->get();
        if($query->num_rows()>0){
          return false;
        }
        else{
          return true;
        }
    }
    public function get_user($id) {
        if($id != FALSE) {
            $query = $this->db->get_where('user', array('id' => $id));
            return $query->row_array();
        }
        else {
            return FALSE;
        }
     }        
}
?>