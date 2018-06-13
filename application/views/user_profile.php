
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
    <link rel="stylesheet" href="<?php echo base_url();?>assets/font/font-awesome/css/font-awesome-animation.min.css">
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
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo base_url('user/user_profile');?>">Principal<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url('device/add_device');?>">Agregar Dispositivo</a>
            </li>
            <?php 
            //echo $this->session->userdata('roll_name'); 
            if ($this->session->userdata('roll_name') == 'wifiadmins'){
             // echo "roll_name admin";
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

    <div class="container mt-4">
      <div class="row">
        <div class="preface-block col-sm-4">
          <div class="region region-preface-first">
            <div id="block-block-2" class="block block-block">
              <div class="content">
                <i class="fa fa-gear fa-5x wow bounce animated fa-2x animated text-black align-content-center" style="visibility: visible; animation-duration: 2500ms; animation-iteration-count: infinite; animation-name: spin;color: #414141;" data-wow-iteration="infinite" data-wow-duration="2500ms "></i>
                <h2 class="h2-preface text-black">Los Usuarios</h2>
                <hr id="preface" style="background-color: #858585">
                <div class="service-desc">
                  <p class="text-black" style="margin-top: 15px;text">
                    <br>a) Estudiantes tienen la posibilidad de registrar 1 equipo móvil.</br>
                    <br> b) Trabajadores no docentes tienen la posibilidad de registrar 1 equipo móvil</br>
                    <br> c) Docentes tienen la posibilidad de registrar 2 equipos móvil. </br>
                    <br>Nota: por capacidad de la red inalámbrica..</br>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="preface-block col-sm-4">
          <div class="region region-preface-middle">
            <div id="block-block-3" class="block block-block">
              <div class="content">
                <div class="service-box">
                  <div class="service-icon">
                    <i class="fa fa-file-text fa-5x wow bounce animated fa-2x animated text-black" style="visibility: visible; animation-duration: 1500ms; animation-iteration-count: infinite; animation-name: bounce;color: #414141;" data-wow-iteration="infinite" data-wow-duration="1500ms "></i>
                  </div>
                  <h2 class="h2-preface text-black">Cantidad de Equipos</h2>
                  <hr id="preface" style="background-color: #000000">
                  <div class="service-desc">
                    <p class="text-black" style="margin-top: 15px;">
                      <br>La cantidad de equipos por tipología es: 1 Teléfono, 1 Tablet, 1 Laptop.</br>
                      <br>Nota: En el caso de docentes no pueden repetir el tipo de equipo.</br>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>