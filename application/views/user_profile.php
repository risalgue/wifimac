
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
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2a52be;">
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
                <i class="fa fa-gear fa-5x wow bounce animated fa-2x animated text-white align-content-center" style="visibility: visible; animation-duration: 2500ms; animation-iteration-count: infinite; animation-name: spin;" data-wow-iteration="infinite" data-wow-duration="2500ms "></i>
                <h2 class="h2-preface text-white">Servicios de Soporte</h2>
                <hr id="preface" style="background-color: #ffffff">
                <div class="service-desc">
                  <p class="text-white" style="margin-top: 15px;">Brindamos un completo soporte técnico para nuestra cartera de sistemas y productos desplegados.</p>
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
                    <i class="fa fa-file-text fa-5x wow bounce animated fa-2x animated text-white" style="visibility: visible; animation-duration: 1500ms; animation-iteration-count: infinite; animation-name: bounce;" data-wow-iteration="infinite" data-wow-duration="1500ms "></i>
                  </div>
                  <h2 class="h2-preface text-white">Servicios de Consultoría</h2>
                  <hr id="preface" style="background-color: #ffffff">
                  <div class="service-desc">
                    <p class="text-white" style="margin-top: 15px;">Brindamos una completa asesoría en materia de las líneas de negocio en que se enfoca la empresa.</p>
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