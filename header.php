<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php wp_head(); ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css"/><script src="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.js" defer></script><script>window.addEventListener("load", function(){window.wpcc.init({"border":"thin","colors":{"popup":{"background":"#f6f6f6","text":"#000000","border":"#555555"},"button":{"background":"#555555","text":"#ffffff"}},"position":"bottom","padding":"none","margin":"none","content":{"href":"https://www.nikolsimone.com/privacy-policy/","message":"We use cookies to better understand your needs, improve performance and provide you with personalised content and advertisements. To allow us to provide a better and more tailored experience, please click the \"OK\" Button. View our ","link":" Privacy Policy.","button":"OK"}})});</script>
</head>

<body <?php body_class('test'); ?>>


  <header>
  <nav class="navbar navbar-expand-md sticky-top">
    <div class="container-fluid">

      

          <a class="navbar-brand" href="<?php bloginfo('url'); ?>">
            <img src="<?php bloginfo('template_directory'); ?>/img/logo.png" class="img-fluid logo">
          </a>

        
          <a href="http://localhost/Forex/registration/"  class="navbar-toggler collapsed border-0" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <!-- these spans become the three lines -->
            <span> </span>
            <span> </span>
            <span> </span>
          </a>
           

<?php wp_nav_menu(

  array(

  'theme_location' => 'top-menu',
  'depth'             => 2,
  'container'         => 'div',
  'container_class'   => 'collapse navbar-collapse',
  'container_id'      => 'navbarResponsive',
  'menu_class'        => 'navbar-nav ml-auto',
  'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
  'walker'            => new WP_Bootstrap_Navwalker(),
    )
     ); ?>
         
      

        
      </div>
    </nav>
  </header>