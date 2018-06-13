<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dispositivos Wifi en la Red UG</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" media="screen" title="no title">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/mycss.css" media="screen" title="no title">
    <!--<link rel="stylesheet" href="<?php// base_url();?>assets/css/bootstrap-theme.min.css" media="screen" title="no title">-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/font/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
  </head>
  <body>
   <!-- Carrousel -->
   <!-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
       
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <!-- <img class="d-block w-100" src=".../800x400?auto=yes&bg=777&fg=555&text=First slide" alt="First slide"> -->
                <!-- <img class = "d-block w-100" src="<?php echo base_url();?>assets/img/slide1.png" alt="First slide">
            </div>
            <div class="carousel-item">
                <!-- <img class="d-block w-100" src=".../800x400?auto=yes&bg=666&fg=444&text=Second slide" alt="Second slide"> -->
                <!-- <img class = "d-block w-100" src="<?php echo base_url();?>assets/img/slide2.png" alt="Second slide"> -->
            <!-- </div> -->
            <!-- <div class="carousel-item"> -->
                <!-- <img class="d-block w-100" src=".../800x400?auto=yes&bg=555&fg=333&text=Third slide" alt="Third slide"> -->
                <!-- <img class = "d-block w-100" src="<?php echo base_url();?>assets/img/slide3.png" alt="Third slide"> -->
            <!-- </div> -->
        <!-- </div> -->
        <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"> -->
            <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
            <!-- <span class="sr-only">Previous</span> -->
        <!-- </a> -->
        <!-- <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"> -->
            <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
            <!-- <span class="sr-only">Next</span> -->
        <!-- </a> -->
    <!-- </div>  -->

    <!-- Login Form -->
    <div class="container-fluid" style="padding: 20px">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-3 bg-white rounded shadow-lg justify-content-center">
                <div class="login-panel panel panel-success">
                    <div class="panel-heading">
                        <span class="fa-stack fa-lg mb-2 mt-2" >
                            <i class="fa fa-circle fa-stack-2x" style="color:#eef1eb;"></i>
                            <i class="fa fa-lock fa-stack-1x fa-inverse"style="font-size:16px;color:#B31212;" ></i>
                            <a class="ml-5 text-muted" style="font-size:14px;">Login</a>
                        </span> 
                    </div>
                    <?php
                        $success_msg= $this->session->flashdata('success_msg');
                        $error_msg= $this->session->flashdata('error_msg');
        
                        if($success_msg){
                        ?>
                        <div class="alert alert-success">
                            <?php echo $success_msg; ?>
                        </div>
                    <?php
                        }
                        if($error_msg){
                    ?>
                    <div class="alert alert-danger">
                        <?php echo $error_msg; ?>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="panel-body">
                        <form role="form" method="post" action="<?php echo base_url('user/login_user'); ?>">
                            <fieldset>
                                <div class="form-group"  >
                                    <a class="ml-1 text-muted" style="font-size:13px;">Usuario</a>
                                    <input class="form-control mt-1" placeholder="usuarioug" name="user_email" type="username" autofocus style="background-color: #efeef8;font-size:12px;" >
                                </div>
                                <div class="form-group">
                                    <a class="ml-1 text-muted" style="font-size:13px;">Contraseña</a>
                                    <div class="input-group mt-1" style="background-color: #efeef8">
                                        <input class="form-control" id="password" name="user_password" type="password" value="" style="background-color: #efeef8;font-size:12px;border-right-width: 0">
                                        <div class="input-group-append">
                                            <a class="btn btn-primary" style="background-color: transparent;border-color: #ced4da;
                                            border-left-width: 0">
                                                <i toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password mt-1 mr-1" style="color: #000000;font-size:12px;"></i>
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end mr-1">
                                    <input class="btn1 mb-1 btn-1" type="submit" value="Entrar" name="login">
                                </div>
                                <div class="row justify-content-end">
                                    <input class="btn btn-block mb-md-0 text-muted" value="Registre aquí, la MAC de su equipo" style="background-color: #efeef8;font-size:13px;">
                                </div>
                            </fieldset>
                        </form>
                        <!-- <center><b>Not registered ?</b> <br></b><a href="<?php echo base_url('user/register_view'); ?>">Register here</a></center><!--for centered text -->
        
                    </div>
                </div>
            </div>
            <!-- <div class="col-xs-12 col-sm-9" style="overflow-x: scroll;overflow-y: hidden;white-space: nowrap">
                    <div class="container testimonial-group">
                            <div class="row text-center">
                                <div class="col-xs-4">1</div>
                                <div class="col-xs-4">2</div>
                                <div class="col-xs-4">3</div>
                                <div class="col-xs-4">4</div>
                                <div class="col-xs-4">5</div>
                                <div class="col-xs-4">6</div>
                                <div class="col-xs-4">7</div>
                                <div class="col-xs-4">8</div>
                                <div class="col-xs-4">9</div>
                            </div>
                    </div>
            </div> -->
        </div>
    </div>
    
    <footer>
        <div class="row justify-content-center mb-md-1" style="font-size:10px;position:fixed;bottom:0;width:100%;color: #000000;text-align: left;">
            WIFIMAC Diseñado y Desarrollado por el &nbsp
            <a href="https://www.dptosoftware.com"> Dpto de Software</a>
            &nbsp © 2018
        </div>
    </footer>
  </body>
  <script>
        $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
        });
  </script>
</html>