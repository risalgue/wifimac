<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $user_id = $this->session->userdata('user_id');
    if(!$user_id){
        redirect('user/login_view');   
    }
?>
 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WIFIMAC</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" media="screen" title="no title">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/font/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
  </head>
  <body>

  <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2a52be;">
        <a class="navbar-brand text-white">WIFIMAC</a>
        <span class="navbar-text">
            <?php echo $this->session->userdata('user_name');?>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('user/user_profile');?>">Principal<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo base_url('device/add_device');?>">Agregar Dispositivo</a>
            </li>
            <?php if ($this->session->userdata('roll_name')=='wifiadmins'){
              ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('device/all_devices');?>">Buscar Dispositivo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('device/stadistics');?>">Estadisticas</a>
                </li>
            <?php 
                }
              ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('device');?>">Mis Dispositivos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('user/user_logout');?>">Cerrar Sessión</a>
            </li>
          </ul>
          
        </div>
    </nav>
    <!-- Adding Device in Form" -->
    
    <?php
        $success_msg= $this->session->flashdata('success_msg');
        $error_msg= $this->session->flashdata('error_msg');
        if($success_msg){
    ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo $success_msg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
  </button>
    </div>
    <?php
        }
        if($error_msg){
    ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php echo $error_msg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
  </button>
    </div>
    <?php
        }
    ?>
    <div class="panel-heading mt-3">         
        <h5 class="text-center">Agregue los valores del nuevo dispositivo</h5>
    </div>
    <div class="row justify-content-center mr-auto ml-auto">
        <div class="col-md-4 col-md-offset-4 mt-2">
            <div class="panel-body">
                <form role="form" method="post" action="<?php echo base_url('device/insert_device'); ?>">
                    <fieldset>
                        <div class="form-group"  >
                            <input class="form-control" placeholder="MAC del dispositivo" name="device_mac" type="text" autofocus>
                        </div>
                        <div class="form-group">
                        <select class="custom-select" name="device_type">
                            <option selected>Seleccione el tipo de dispositivo</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Table">Table</option>
                            <option value="Movil">Movil</option>
                        </select>
                        </div>
                        <input class="btn btn-lg btn-success btn-block" type="submit" value="Agregar Dispositivo" name="insert" >
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
  </body>
</html>