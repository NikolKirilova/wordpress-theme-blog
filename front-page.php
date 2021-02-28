<?php
/*
Template Name: FrontPage
*/
 get_header();?>


	

<div class="content">
    <div class="side-icons">
    <ul class="side-icons-ul">
    <li class="side-icons-li"><a><i class="fab fa-facebook-f"></a></i></li>
    <li class="side-icons-li"><a><i class="fab fa-twitter"></i></a></li>
    <li class="side-icons-li"><a><i class="fab fa-linkedin-in"></i></a></li>

    
    </ul>
    </div>
    
    <div class="main-content">


    <?php if(have_posts()) : while(have_posts()) :the_post();?>

    <?php the_content();?>
    <?php endwhile; else: endif;?>



</div>
</div>
<?php get_footer();?>