<?php get_header(); ?>
<div class="maincontent-sidebar">
    <div class="container">
        <div class="row-container">
            <div class="maincontent">
                
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h2 ><?php the_title(); ?></h2>

                    <?php the_content(); ?>
     
                    <?php wp_link_pages(); ?>
            <?php endwhile; endif; ?>


            </div>
        
            <div class="sidebar">
            
            <?php if ( is_active_sidebar( 'page-sidebar-widget-area' ) ) : ?>
                        <?php dynamic_sidebar( 'page-sidebar-widget-area' ); ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


 
<?php get_footer(); ?>