<?php
/*
Template Name: OnlyPage
Template Post Type: post, page, product
*/
 get_header();?>

    <div class="side-icons">
    <ul class="side-icons-ul">
    <li class="side-icons-li"><i class="fab fa-facebook-f"></i></li>
    <li class="side-icons-li"><i class="fab fa-twitter"></i></li>
    <li class="side-icons-li"><i class="fab fa-linkedin-in"></i></li>

    
    </ul>
    </div>


<div class="content-page">
    
  


        <div class="container-fluid">
		
           

          




           
               <?php if(has_post_thumbnail()):?>
                            
               <img src="<?php the_post_thumbnail_url('post_image');?>" alt="<?php the_title();?>" class="img-fluid">
                            
               <?php endif;?>
                
           
           <div id="post-title">
			     <?php the_title();?>
				</div>
         
            

             <?php if(have_posts()) : while(have_posts()) :the_post();?>

            <?php the_content();?>
             
            <?php endwhile; else: endif;?>

            

       </div>

  

    

</div>



<?php get_footer();?>