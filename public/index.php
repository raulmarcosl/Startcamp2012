<!DOCTYPE html>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <title>WayraBoard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Loading Bootstrap -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Loading Flat UI -->
  <link href="css/flat-ui.css" rel="stylesheet">

  <link href="css/styles.css" rel="stylesheet">

  <link href="https://github.com/jackmoore/colorbox/blob/master/example1/colorbox.css" rel="stylesheet">

  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>

  <script type="text/javascript" src = "js/jquery.flip.min.js"></script>
  <script type="text/javascript" src = "js/script.js"></script>
  <script type="text/javascript" src="https://github.com/jackmoore/colorbox/blob/master/jquery.colorbox-min.js"></script>

  <!--script src="https://raw.github.com/ducksboard/gridster.js/master/dist/jquery.gridster.min.js"></script-->

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <![endif]-->
  <script>
    $(function(){ //DOM Ready

        $("#abrirIframe").colorbox({iframe:true, innerWidth:425, innerHeight:344});

        //$.getJSON("http://localhost:8888/wayra/public/content.json", { },
        $.getJSON("http://pure-wave-4585.herokuapp.com/api/feed", { },

          function(data) {

            var x = 0;
            var str = "";

            //str = "<div class='row-fluid'>";

            $.each(data.result, function(i,item){
              //x = x + 1;

              //if(x == 4){
                //str = str + "<div class='span3'><center><img src='"+ item.photo +"'' /></center><p></p></div></div><div class='row-fluid'>";
              //  x = 0;
              //}else{
                //str = str + "<div class='span3'><center><img src='"+ item.photo +"'' /></center><p></p></div>";
              //}

              str = str + "<div class='sponsor' title='Click to flip'><div class='sponsorFlip'><img src='" + item.photoUrl +"'' alt='' width='140'/></div><div class='sponsorData'><div class='sponsorDescription'>" + item.title +"</div><div class='sponsorURL'><a href='http://www.com'>http://www.com</a></div></div></div>";

            });

            //$("#sponsorListHolder").append(str);
            //$("#sponsorListHolder").append(str);
        });

        $("#filtroTodos").on("click", function(){
            alert("Filtro TODOS");
        });
    });
  </script>
  </head>
  <body>
    <div class="container">
      <p></p>
      <div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <div class="nav-collapse collapse">
                  <ul class="nav">
                    <li><a href="#"><img src="images/mindexer-logo.png" alt="Mindexer" width="223" style="margin-left: -19px; margin-top: -5px;" /></a></li>
                  </ul>
                  <ul class="nav pull-right">
                    <li><a href="#"><span class="fui-menu-16"></span> Filtro</a>
                      <ul>
                        <li><a href="#" id="filtroTodos">Todos</a></li>
                        <li><a href="#" id="filtroTwitter">Twitter</a></li>
                        <li><a href="#" id="filtroDeportes">Deportes</a></li>
                      </ul> <!-- /Sub menu -->
                    </li>
                    <li><a href="#"><span class="fui-settings-16"></span> Personalizar</a></li>
                    <li><a href="#">Cerrar sesión</a></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
        </div>
        <div id="grid"></div>
        <div class="sponsorListHolder" id="sponsorListHolder">

        <?php

          $string = file_get_contents("http://pure-wave-4585.herokuapp.com/api/feed");

          $json_a=json_decode($string, true);

          foreach($json_a as $p) {

            echo "<div class='sponsor' title='Ver contenido'>"
              ."<div class='sponsorFlip'>"
                ."<img src='images/".$p[photo]."' alt='' width='140'/>"
              ."</div>"
              ."<div class='sponsorData'>"
                ."<div class='sponsorDescription'>".$p[title]."</div>"
                //."<center><button class='btn btn-small btn-primary iframe' type='button' id='leerNoticia' onClick='javascript:window.open('http://wikipedia.com');'>Leer</button></center>"
                //."<div class='sponsorURL'><a class='btn btn-small btn-block btn-success' href='".$p[permalink]."'>Leer</a></div>"
                //."<center><div class='sponsorURL'><a class='btn btn-small btn-primary iframe' href='".$p[permalink]."'>Leer</a></div></center>"
                ."<center><div class='sponsorURL'><a id='abrirIframe' href='".$p[permalink]."'>Leer</a></div></center>"
              ."</div>"
            ."</div>";

          }

        ?>
        </div>

        <div class="clear"></div>

        <p></p>

    </div>
  </body>
</html>
