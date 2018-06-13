
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
              <li class="nav-item active">
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
    
    <!-- Content Table Result Stadistics" -->
    <div class="row justify-content-center mr-auto ml-auto">
      <div class="col-md-12 col-md-offset-2 mt-3">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Tipo de Usuario#</th>
                <th scope="col">Telefono</th>
                <th scope="col">Tablet</th>
                <th scope="col">Laptop</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Cant. Usuarios</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $all_data = $this->session->userdata('all_data');
                $all_users = $this->session->userdata('all_users');
                $cantTelefEst = 0;
                $cantTabletEst = 0;
                $cantLaptopEst = 0;
                $cantTelefProf = 0;
                $cantTabletProf = 0;
                $cantLaptopProf = 0;
                $cantTelefNo_doc = 0;
                $cantTabletNo_doc = 0;
                $cantLaptopNo_doc = 0;
                $cantTelefOtros = 0;
                $cantTabletOtros = 0;
                $cantLaptopOtros = 0;
                $totalEst = 0;
                $totalProf = 0;
                $totalNo_doc = 0;
                $totalOtros = 0;
                foreach ($all_data as $row){
                  if($row->roll_name == 'estudiantes' and $row->device_type == 'Movil') {
                    $cantTelefEst++;
                  }
                  else if ($row->roll_name == 'estudiantes' and $row->device_type == 'Table') {
                    $cantTabletEst++;
                  }
                  else if ($row->roll_name == 'estudiantes' and $row->device_type == 'Laptop') {
                    $cantLaptopEst++;
                  }
                  else if($row->roll_name == 'profesores' and $row->device_type == 'Movil') {
                    $cantTelefProf++;
                  }
                  else if ($row->roll_name == 'profesores' and $row->device_type == 'Table') {
                    $cantTabletProf++;
                  }
                  else if ($row->roll_name == 'profesores' and $row->device_type == 'Laptop') {
                    $cantLaptopProf++;
                  }
                  else if($row->roll_name == 'no_docente' and $row->device_type == 'Movil') {
                    $cantTelefNo_doc++;
                  }
                  else if ($row->roll_name == 'no_docente' and $row->device_type == 'Table') {
                    $cantTabletNo_doc++;
                  }
                  else if ($row->roll_name == 'no_docente' and $row->device_type == 'Laptop') {
                    $cantLaptopNo_doc++;
                  }
                  else if($row->device_type == 'Movil'){
                    $cantTelefOtros++;
                  }
                  else if($row->device_type == 'Table'){
                    $cantTabletOtros++;
                  }
                  else {
                    $cantLaptopOtros++;
                  }
                }
                foreach ($all_users as $row){
                  if ($row->roll_name == 'estudiantes') {
                    $totalEst++;
                  }
                  else if($row->roll_name == 'profesores'){
                    $totalProf++;
                  }
                  else if($row->roll_name == 'no_docente') {
                    $totalNo_doc;
                  }
                  else {
                    $totalOtros++;
                  }
                }
              ?>
              <tr>
                <th scope="row">
                  Estudiantes
                </th>
                <td>
                  <?php echo $cantTelefEst; ?>
                </td>
                <td>
                  <?php echo $cantTabletEst; ?>
                </td>
                <td>
                  <?php echo $cantLaptopEst; ?>
                </td>
                <td>
                  <?php echo $cantTelefEst + $cantTabletEst + $cantLaptopEst; ?>
                </td>
                <td>
                  <?php echo $totalEst; ?>
                </td>
              </tr>
              <tr>
                <th scope="row">
                  Docentes
                </th>
                <td>
                  <?php echo $cantTelefProf; ?>
                </td>
                <td>
                  <?php echo $cantTabletProf; ?>
                </td>
                <td>
                  <?php echo $cantLaptopProf; ?>
                </td>
                <td>
                  <?php echo $cantTelefProf + $cantTabletProf + $cantLaptopProf; ?>
                </td>
                <td>
                  <?php echo $totalProf; ?>
                </td>
              </tr>
              <tr>
                <th scope="row">
                  No Docentes
                </th>
                <td>
                  <?php echo $cantTelefNo_doc; ?>
                </td>
                <td>
                  <?php echo $cantTabletNo_doc; ?>
                </td>
                <td>
                  <?php echo $cantLaptopNo_doc; ?>
                </td>
                <td>
                  <?php echo $cantTelefNo_doc + $cantTabletNo_doc + $cantLaptopNo_doc; ?>
                </td>
                <td>
                  <?php echo $totalNo_doc; ?>
                </td>
              </tr>
              <tr>
                <th scope="row">
                  Otros
                </th>
                <td>
                  <?php echo $cantTelefOtros; ?>
                </td>
                <td>
                  <?php echo $cantTabletOtros; ?>
                </td>
                <td>
                  <?php echo $cantLaptopOtros; ?>
                </td>
                <td>
                  <?php echo $cantTelefOtros + $cantTabletOtros + $cantLaptopOtros; ?>
                </td>
                <td>
                  <?php echo $totalOtros; ?>
                </td>
              </tr>
              <tr>
                <th scope="row">
                  Total
                </th>
                <td>
                  <?php echo $cantTelefEst + $cantTelefProf + $cantTelefNo_doc + $cantTelefOtros; ?>
                </td>
                <td>
                  <?php echo $cantTabletEst + $cantTabletProf + $cantTabletNo_doc + $cantTabletOtros; ?>
                </td>
                <td>
                  <?php echo $cantLaptopEst + $cantLaptopProf + $cantLaptopNo_doc + $cantLaptopOtros; ?>
                </td>
                <td>
                  <?php echo count($all_data); ?>
                </td>
                <td>
                  <?php echo count($all_users); ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>