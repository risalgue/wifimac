
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
 <!-- <div class="navbar-wrapper"> -->
 <!--  -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #535353;">
        <a class="navbar-brand text-white">WIFIMAC</a>
        <span class="navbar-text">
            <?php echo $this->session->userdata('user_name');?>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon " ></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
          <ul class="navbar-nav mr-auto my-2 my-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('user/user_profile');?>">Principal<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('device/add_device');?>">Agregar Dispositivo</a>
            </li>
            <?php if ($this->session->userdata('roll_name')=='wifiadmins'){
              ?>
              <li class="nav-item active">
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
     <!-- Alert Message -->
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
    <!-- Filter -->
    <div class="row justify-content-center mr-auto ml-auto">
        <div class="col-md-4 col-md-offset-4 mt-5">
            <div class="panel-body">
                <form role="form" method="post" action="<?php echo base_url('device/find_device'); ?>">
                    <fieldset>
                        <div class="form-group"  >
                        <!-- Input Filter -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nombre de usuario o MAC" name="filter">
                            </div>
                        </div>
                        <input class="btn btn-lg btn-success btn-block" type="submit" value="Buscar" name="search" >
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    
        
    
    
    <!-- Content Table Result Device" -->
    <div class="row justify-content-center mr-auto ml-auto">
      <div class="col-md-12 col-md-offset-2 mt-3">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Dispositivo</th>
                <th scope="col">MAC</th>
                <th scope="col">IP</th>
                <th scope="col">Usuario</th>
                <th scope="col">Insertado</th>
                <th scope="col">Modificado</th>
                <th scope="col">Eliminar</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $alldev = $this->session->userdata('all_dev');
                  $i = 0;
                  foreach ($alldev as $row){
                    ?>
                    <tr>
                      <th scope="row">
                        <?php echo $i+1; ?>
                      </th>
                      <td>
                        <?php echo $row->device_type; ?>
                      </td>
                      <td>
                        <?php echo $row->device_mac; ?>
                      </td>
                      <td>
                        <?php echo $row->device_ip; ?>
                      </td>
                      <td>
                        <?php echo $row->user_name; ?>
                      </td>
                      <td>
                        <?php echo strftime("%d de %b de %Y", strtotime(trim($row->device_created))); ?>
                      </td>
                      <td>
                        <?php echo strftime("%d de %b de %Y", strtotime(trim($row->device_modified))); ?>
                      </td>
                      <td>
                        <a href="<?php echo base_url('device/delete_device?device_id=').$row->device_id; ?>" class="btn btn-danger red-stripe" role="button" data-title="johnny" data-id="1">
                          <i class="fa fa-trash-o mr-1" aria-hidden="true"></i>
                            Eliminar
                        </a>
                      </td>
                    </tr>
                    <?php
                    $i++;
                  }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>