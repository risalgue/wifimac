<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
class Device extends CI_Controller {
    public $deviceController = NULL;
    public function __construct(){
        parent::__construct();
  	    $this->load->helper('url');
        $this->load->model('device_model');
        $this->load->model('route_model');
        $this->load->model('user_model');
        $this->load->library('session');
    }
    public function index(){
        $this->my_device();
        $this->load->view("mydevices.php");
    }

    public function add_device(){
        $this->load->view("add_device.php");
    }
    public function all_devices(){
        if ($this->session->userdata('roll_name') == 'wifiadmins'){
            $this->all_device();
            $this->load->view("all_devices.php");
        }
    }

    public function stadistics(){
        if ($this->session->userdata('roll_name') == 'wifiadmins'){
            $data = $this->device_model->get_statidistics();
            $this->session->set_userdata('all_data',$data);
            $data2 = $this->user_model->all_users();
            $this->session->set_userdata('all_users',$data2);
            $this->load->view("stadistics.php");
        }
    }

    //Registering Device
    public function insert_device(){
        $now = new DateTime;
        $device=array(
            'device_type'=>$this->input->post('device_type'),
            'device_mac'=>$this->input->post('device_mac'),
            'device_created'=>$now->format( 'Y-m-d H-i-s'),
            'device_modified'=>$now->format( 'Y-m-d H-i-s'),
            'user_id'=>$this->session->userdata('user_id'));
        if ($device['device_type']=='Seleccione el tipo de dispositivo'){
            $this->session->set_flashdata('error_msg', 'Por favor, seleccione el tipo de dispositivo que va a insertar.');
            redirect('device/add_device');
        }
        //Chequing de MAC String
        $mac_check = $this->device_model->check($device['device_mac']);
        if ($mac_check) {
            $device['device_mac'] = $mac_check;
        }
        else {
            $this->session->set_flashdata('error_msg', 'MAC incorrecta, Por favor verifíquela.');
            redirect('device/add_device');
        }
        //Chequing number of user's devices in BD
        $numb_devices = $this->device_model->device_number($device['user_id']);
        if ($this->session->userdata('roll_name') == 'student' and  $numb_devices > 0){
            $this->session->set_flashdata('error_msg', 'Ups, como estudiante solo puede tener un dispositivo agregado.');
            redirect('device/add_device');
        }
        else if ($numb_devices > 1){
            $this->session->set_flashdata('error_msg', 'Ups, solo puede tener dos dispositivos agregados.');
            redirect('device/add_device');
        }

        //Chequing if MAC Device exist in BD
        $device_check=$this->device_model->device_check($device['device_mac']);
        if($device_check){
            //Check for available IP
            $available_ip = $this->route_model->GetAvailableIpForGroup($this->session->userdata('roll_name'));
            if ($available_ip){
                // echo $available_ip['ip_address'];
                $device['device_ip'] = $available_ip['ip_address'];
                if ($this->device_model->insert_device($device)){
                    $this->route_model->disable_ip($device['device_ip']);
                    $this->session->set_flashdata('success_msg', 'Dispositivo agregado correctamente');
                    redirect('device');
                }
                else {
                    $this->session->set_flashdata('error_msg', 'Existen problemas para agregar un dispositivo.');
                    redirect('device');
                }
            }
            else {
                $this->session->set_flashdata('error_msg', 'Ups, no existen direcciones Ip disponibles para este grupo, informe esto a los administradores de la red.');
                redirect('device/add_device');
            }
        }
        else{
            $this->session->set_flashdata('error_msg', 'Ups, esta MAC ya se encuentra registrada.');
            redirect('device/add_device');
        }
    }
    //Finding device by User Name
    public function find_device(){
        $filter= $this->input->post('filter');
        $datauser = $this->device_model->search_device_by_user($filter);
        $datamac = $this->device_model->search_device_by_mac($filter);
        $data = $datauser + $datamac;
        $this->session->set_userdata('all_dev',$data);
        if ($data){
            $this->load->view("all_devices.php");
        }
        else {
            $this->load->view("all_devices.php");
        }
    }

    //Finding device by MAC
    public function find_device_by_mac(){
        $filter= $this->input->post('filter');
        $data = $this->device_model->search_device_by_mac($filter);
        $this->session->set_userdata('all_dev',$data);
        if ($data){
            $this->load->view("all_devices.php");
        }
        else {
            $this->load->view("all_devices.php");
        }
    }
    //Extracting user's device
    public function my_device(){
        $data = $this->device_model->get_devices($this->session->userdata('user_id'));
        $this->session->set_userdata('devices',$data);
    }

    //Extracting alldevices
    public function all_device(){
        $data = $this->device_model->get_alldevices();
        $this->session->set_userdata('all_dev',$data);
    }

    //Deleting Device
    public function delete_device(){
        $deviceId=$this->input->get('device_id');
        //echo ("device_id: ".$deviceId);
        $data = $this->device_model->delete_device($deviceId);
        if ($data) {
            $this->session->set_flashdata('success_msg', 'Dispositivo eliminado correctamente');
            redirect('device/all_devices');
        }    
        else{
            $this->session->set_flashdata('error_msg', 'Ups, tenemos problemas para eliminar este dispositivo');
            redirect('device/all_devices');
        }
    }

    //Modifing Device
    public function modify_device(){
        $now = new DateTime;
        $device = array('device_id' => $this->input->get('id'), 
                                     'device_mac' => $this->input->post('device_mac'),
                                    'device_type' => $this->input->post('device_type'),
                                    'device_modified'=> $now->format( 'Y-m-d H-i-s'));
        // echo 'id:'.$device['device_id'].' mac: '.$device['device_mac'].' type: '.$device['device_type'];
        $last_device = $this->device_model->get_device_by_id($device['device_id']);
        if ($last_device){
            $now = time();
            $modified_date = strtotime($last_device['device_modified']);
            $diff = $now - $modified_date;
            $days = $diff / 60 /60 / 24;
            // echo intval($days).' days';
            if ($diff >= 2592000){
                $data = $this->device_model->modify_device($device);
                if ($data) {
                    $this->session->set_flashdata('success_msg', 'Dispositivo guardado correctamente');
                    redirect('device');
                }    
                else{
                    $this->session->set_flashdata('error_msg', 'Ups, tenemos problemas para guardar los cambios este dispositivo');
                    redirect('device');
                }
            }
            else {
                $days = $diff / 60 /60 / 24;
                $less_days = 30 - intval($days);
                $this->session->set_flashdata('error_msg', 'Ups, debe esperar '.$less_days.' dias para modificar este dispositivo');
                    redirect('device');
            }
        }
        else {
            $this->session->set_flashdata('error_msg', 'Ups, tenemos problemas para guardar los cambios este dispositivo');
                    redirect('device');
        }
    }
}
?>