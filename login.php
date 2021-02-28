<?php
/*
Template Name: LoginPage
*/
 get_header();?>
 


<div class="content-page">
    
  


        <div class="login-page">

           

            <div>




           
               <?php if(has_post_thumbnail()):?>
                            
               <img src="<?php the_post_thumbnail_url('post_image');?>" alt="<?php the_title();?>" class="img-fluid mb-5">
                            
               <?php endif;?>
                
           
           
           
            

             <?php if(have_posts()) : while(have_posts()) :the_post();?>

            <?php the_content();?>
             
            <?php endwhile; else: endif;?>

            </div>

       </div>

  

    

</div>



<?php get_footer();?>