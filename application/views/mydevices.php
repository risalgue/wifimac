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
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #535353;">
        <a class="navbar-brand text-white">WIFIMAC</a>
        <span class="navbar-text">
            <?php echo $this->session->userdata('user_name');?>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
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
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('device/all_devices');?>">Buscar Dispositivo</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('device/stadistics');?>">Estadisticas</a>
              </li>
            <?php 
                }
              ?>
            <li class="nav-item active">
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
    <!-- Content Table Result Device" -->
    <div class="row justify-content-center mr-auto ml-auto mt-4">
      <div class="col-md-12 col-md-offset-2 mt-2">
        <div class="table-responsive-md">
          <table class="table table-striped table-hover text-yellow">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Dispositivo</th>
                <th scope="col">MAC</th>
                <th scope="col">Insertado</th>
                <th scope="col">Modificado</th>
                <th scope="col">Editar</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $alldev = $this->session->userdata('devices');
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
                        <?php echo strftime("%d de %b de %Y", strtotime(trim($row->device_created))); ?>
                      </td>
                      <td>
                        <?php echo strftime("%d de %b de %Y", strtotime(trim($row->device_modified))); ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modifyModal<?php echo $row->device_id; ?>">
                          <i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Editar
                        </button>
                      </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="modifyModal<?php echo $row->device_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Dispositivo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <div class="panel-body">
                                    <form role="form" method="post" action="<?php echo base_url('device/modify_device?id='.$row->device_id); ?>">
                                        <fieldset>
                                            <div class="form-group"  >
                                                <input class="form-control" placeholder="MAC del dispositivo" name="device_mac" type="text" value = "<?php echo $row->device_mac; ?>" autofocus>
                                            </div>
                                            <div class="form-group">
                                            <select class="custom-select" name="device_type">
                                                <option value="Laptop" <?php if ($row->device_type == 'Laptop'){echo "selected";}?>>Laptop</option>
                                                <option value="Table" <?php if ($row->device_type == 'Table'){echo "selected";}?>>Table</option>
                                                <option value="Movil" <?php if ($row->device_type == 'Movil'){echo "selected";}?>>Movil</option>
                                            </select>
                                            </div>
                                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Guardar Cambios" name="modify">
                                        </fieldset>
                                    </form>
                                  </div>
                                </div>
                                <!-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
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