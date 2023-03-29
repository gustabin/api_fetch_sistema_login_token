<?php
  include_once("../../tools/header.php");
  $page_title = "Tienda";
?>
<div class="">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <div class="text-left">
            <img src="https://picsum.photos/200/100?random=1" class="rounded" alt="Logo de la tienda">
          </div>
          <h2>Tu Mega Tienda</h2>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <i class="fa fa-home fa-lg"> </i>
              <a href="tienda.php"> Tienda</a>
            </li>
            <li class="breadcrumb-item active"><?php echo $page_title ?></li>
          </ol> 
          <div><i class="fa fa-user fa-lg"> </i> <span id="nombre"></span> | <i class="fa fa-envelope fa-lg"> </i> <span id="correo"> </span> | <span id="login_logout"></span></div>
          <?php ?>
        </div>
      </div>     
    </div>
  </section>

  <section class="content mb-2">
    <div class="container-fluid">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- carrusel de imágenes -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="https://picsum.photos/1600/400?random=1" alt="Imagen hero aleatoria">
            <div class="carousel-caption">
              <h1>Tu Mega Tienda Online</h1>
              <p>Todo en un solo clic</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <section class="content">
    <div class="container-fluid">
      <div class="card-deck">
        <div class="card">
          <img src="https://picsum.photos/180/150" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Nombre del producto</h5>
            <p class="card-text">Descripción del producto.</p>
            <p class="card-text">
              <small class="text-muted">
                $<?php echo number_format(rand(1000,9999)/100,2); ?>
              </small>
            </p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
        <div class="card">
          <img src="https://picsum.photos/180/151" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Nombre del producto</h5>
            <p class="card-text">Descripción del producto.</p>
            <p class="card-text">
              <small class="text-muted">
                $<?php echo number_format(rand(1000,9999)/100,2); ?>
              </small>
            </p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
        <div class="card">
          <img src="https://picsum.photos/180/152" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Nombre del producto</h5>
            <p class="card-text">Descripción del producto.</p>
            <p class="card-text">
              <small class="text-muted">
                $<?php echo number_format(rand(1000,9999)/100,2); ?>
              </small>
            </p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<?php include_once("../../tools/footer.php"); ?>

<script src=<?php echo '../../js/loginFunciones.js' ?>></script>

<script>
  VerificarToken();
</script>