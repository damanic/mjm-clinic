<?php
/*
Template Name: MJM Clinic Service Location
*/

$location = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$location_meta = get_option( "taxonomy_$location->term_id" );

get_header();
?>

<!-- START CONTENT -->
<section id="primary" class="content-area">

    <div id="content" class="site-content" role="main">

        <div class="page-content">

            <h1><?php echo $location->name?></h1>

            <p>
                <?php echo wpautop($location->description) ?>
            </p>



            <?php if(!empty($location_meta['open_hours'])){?>

               <b> <?php echo __('Open Hours',',mjm-clinic')?>:</b>
                <div class="mjm_clinic_service_locations_widget_output_open-hours">
                   <?php echo wpautop($location_meta['open_hours']) ?>
                </div>

            <?php } ?>



            <?php if(!empty($location_meta['tel'])){?>
            <p> <a href="tel:<?php echo wp_strip_all_tags($location_meta['tel'])?>">
                    <i class="fa fa-phone"></i> <?php echo wp_strip_all_tags($location_meta['tel'])?>
                </a></p>
            <?php } ?>
            <?php if(!empty($location_meta['contact_link'])){
                $link = str_replace('{service_id}','', wp_strip_all_tags($location_meta['contact_link']));
                $link = str_replace('{service_name}','', $link);
                ?>
            <p><a href="<?php echo $link?>">
                    <i class="fa fa-calendar"></i> <?php echo __('Book Appointment',',mjm-clinic')?>
                </a></p>
            <?php } else if(!empty($location_meta['email'])){?>
            <p> <a href="mailto:<?php echo antispambot(wp_strip_all_tags($location_meta['email']))?>">
                    <i class="fa fa-envelope"></i>  <?php echo __('Email Us',',mjm-clinic')?>
                </a></p>
            <?php } ?>


            <hr/> <h4>Booking Form</h4>
            <?php echo do_shortcode('[mjm-clinic-booking-form location='.$location->term_id.' no_location_select=1]'); ?>


            <?php
                             if ( have_posts() ) { ?>
                            <hr/>
                                 <h2> <?php echo __('Available Services',',mjm-clinic')?></h2>

                                 <?php while ( have_posts() ) : the_post();?>
                                    <h5>
                                        <i class="fa fa-plus-square"></i>
                                            <a href="<?php echo get_permalink( $post->ID)?>">
                                                <?php echo $post->post_title?>
                                            </a>
                                    </h5>
                                     <p><?php echo $post->post_excerpt?></p>
                                 <?php endwhile; ?>


                            <?php } ?>
            </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
?>