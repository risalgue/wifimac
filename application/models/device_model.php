<?php
class Device_model extends CI_Model {
    public function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    public function insert_device($device){
        $this->db->insert('device', $device);
        if ($this->db->affected_rows()){
            $this->update_wifi_conf();
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    public function update_wifi_conf(){
        $filename = "/Applications/XAMPP/htdocs/equipos/wifi3.conf";
        if (unlink($filename)){
            $all_devices = $this->get_alldevices();
            $content = 'subnet 10.33.64.0 netmask 255.255.192.0 {
                option routers 10.33.64.1;
                option domain-name-servers 10.32.2.8, 10.32.2.10;
                option subnet-mask 255.255.192.0;
                option broadcast-address 10.33.127.255;
                
                group {';
            file_put_contents($filename, $content, FILE_APPEND);
            $numDev = 1;
            $last_user = '';
            foreach ($all_devices as $row){
                if ($row->user_email == $last_user){
                    $numDev++;
                }
                else {
                    $numDev = 1;
                    $last_user = $row->user_email;
                }
                 $content = '
                 host dp'.$numDev.'-'.$this->session->userdata('user_email').' {
                        option host-name "dp'.$numDev.'-'.$row->user_email.'.cug.co.cu";
                        hardware ethernet '.$row->device_mac.';
                        fixed-address '.$row->device_ip.';
                }';
                file_put_contents($filename, $content, FILE_APPEND);
            }
            $content = '
        }';
            file_put_contents($filename, $content, FILE_APPEND);
        }
        //Insert text before last line----------
            // $fc = fopen($file, "r");
            // while (!feof($fc)) {
            //     $buffer = fgets($fc, 4096);
            //     $lines[] = $buffer;
            // }

            // fclose($fc);

            // //open same file and use "w" to clear file 
            // $f = fopen($file, "w") or die("couldn't open $file");

            // $lineCount = count($lines);
            // //loop through array writing the lines until the secondlast
            // for ($i = 0; $i < $lineCount- 1; $i++) {
            //     fwrite($f, $lines[$i]);
            // }
            // fwrite($f, 'host dp'.$numDev.'-'.$this->session->userdata('user_email').' {
            //     option host-name "dp'.$numDev.'-'.$this->session->userdata('user_email').'.cug.co.cu";
            //     hardware ethernet '.$device['device_mac'].';
            //     fixed-address '.$device['device_ip'].';
            //     }'.PHP_EOL);
            // //write the last line
            // fwrite($f, $lines[$lineCount-1]);
            // fclose($f);
    }

    public function delete_device($deviceId){
        $data = $this->db->delete('device', array('device_id' => $deviceId));
        if ($data) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    function is_valid_mac($mac){
        // 01:23:45:67:89:ab
        if (preg_match('/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/', $mac))
            return true;
        // 01-23-45-67-89-ab
        if (preg_match('/^([a-fA-F0-9]{2}\-){5}[a-fA-F0-9]{2}$/', $mac))
            return true;
        // 0123456789ab
        else if (preg_match('/^[a-fA-F0-9]{12}$/', $mac))
            return true;
        // 0123.4567.89ab
        else if (preg_match('/^([a-fA-F0-9]{4}\.){2}[a-fA-F0-9]{4}$/', $mac))
            return true;
        else
            return false;
    }

    function normalize_mac($mac){
        // remove any dots
        $mac =  str_replace(".", "", $mac);

        // replace dashes with colons
        $mac =  str_replace("-", ":", $mac);

        // counting colons
        $colon_count = substr_count ($mac , ":");

        // insert enough colons if none exist
        if ($colon_count == 0){
            $mac =  substr_replace($mac, ":", 2, 0);
            $mac =  substr_replace($mac, ":", 5, 0);
            $mac =  substr_replace($mac, ":", 8, 0);
            $mac =  substr_replace($mac, ":", 11, 0);
            $mac =  substr_replace($mac, ":", 14, 0);
        }

        // uppercase
        $mac = strtoupper($mac);

        // DE:AD:BE:EF:10:24
        return $mac;
    }

    function check($mac){
        //echo $mac." => ";
        if($this->is_valid_mac($mac))
            return $this->normalize_mac($mac);
        else
            return false;
            //echo "Invalid MAC";
        //echo "\n<br>";
    }

    public function device_check($mac){
        $this->db->select('*');
        $this->db->from('device');
        $this->db->where('device_mac',$mac);
        $query=$this->db->get();
        if($query->num_rows()>0){
          return false;
        }
        else{
          return true;
        }
    }
    public function get_devices($id) {
        if($id != FALSE) {
            $query = $this->db->get_where('device', array('user_id' => $id));
            return $query->result();
        }
        else {
            return FALSE;
        }
     }
     public function device_number($id) {
        if($id != FALSE) {
            $query = $this->db->get_where('device', array('user_id' => $id));
            return $query->num_rows();
        }
        else {
            return FALSE;
        }
     }
     public function get_alldevices(){
        $this->db->select('*');
        $this->db->from('device');
        $this->db->join('user','user.user_id = device.user_id');
        $this->db->order_by('user_email','ASC');
        $query = $this->db->get();
        return $query->result();
     }
     public function get_statidistics(){
        $this->db->select('*');
        $this->db->from('device');
        $this->db->join('user','user.user_id = device.user_id');
        $this->db->join('roll','roll.user_roll_id = user.user_roll_id');
        $this->db->order_by('user_email','ASC');
        $query = $this->db->get();
        return $query->result();
     }

     public function search_device_by_mac($filter){
        $filter = htmlspecialchars($filter);
        $this->db->select('*');
        $this->db->from('device');
        $this->db->like('device_mac', $filter);
        $this->db->join('user','user.user_id = device.user_id');
        $query = $this->db->get();
        return $query->result();
     }
     public function search_device_by_user($filter){
        $filter = htmlspecialchars($filter);
        $this->db->select('*');
        $this->db->from('user');
        $this->db->like('user_name', $filter);
        $this->db->join('device','user.user_id = device.user_id');
        $query = $this->db->get();
        return $query->result();
     }
     
     public function modify_device($device){
        $this->db->where('device_id', $device['device_id']);
        $data = $this->db->update('device',$device);
        if ($data){
            echo $data;
            return TRUE;
        }
        else {
            return FALSE;
        }
     }
     public function get_device_by_id($device_id){
        $this->db->select('*');
        $this->db->from('device');
        $this->db->where('device_id',$device_id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            return $query->row_array();
        }
        else{
            return false;
        }
     }
}
?>