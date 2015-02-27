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

            <h1><?=$location->name?></h1>

            <p>
                <?= wpautop($location->description) ?>
            </p>



            <? if(!empty($location_meta['open_hours'])){?>

               <b> <?= __('Open Hours',',mjm-clinic')?>:</b>
                <div class="mjm_clinic_service_locations_widget_output_open-hours">
                   <?= wpautop($location_meta['open_hours']) ?>
                </div>

            <? } ?>



            <? if(!empty($location_meta['tel'])){?>
            <p> <a href="tel:<?=wp_strip_all_tags($location_meta['tel'])?>">
                    <i class="fa fa-phone"></i> <?=wp_strip_all_tags($location_meta['tel'])?>
                </a></p>
            <? } ?>
            <? if(!empty($location_meta['contact_link'])){
                $link = str_replace('{service_id}','', wp_strip_all_tags($location_meta['contact_link']));
                $link = str_replace('{service_name}','', $link);
                ?>
            <p><a href="<?=$link?>">
                    <i class="fa fa-calendar"></i> <?= __('Book Appointment',',mjm-clinic')?>
                </a></p>
            <? } else if(!empty($location_meta['email'])){?>
            <p> <a href="mailto:<?=antispambot(wp_strip_all_tags($location_meta['email']))?>">
                    <i class="fa fa-envelope"></i>  <?= __('Email Us',',mjm-clinic')?>
                </a></p>
            <? } ?>


            <hr/> <h4>Booking Form</h4>
            <?= do_shortcode('[mjm-clinic-booking-form location='.$location->term_id.' no_location_select=1]'); ?>


            <?
                             if ( have_posts() ) { ?>
                            <hr/>
                                 <h2> <?= __('Available Services',',mjm-clinic')?></h2>

                                 <?while ( have_posts() ) : the_post();?>
                                    <h5>
                                        <i class="fa fa-plus-square"></i>
                                            <a href="<?= get_permalink( $post->ID)?>">
                                                <?=$post->post_title?>
                                            </a>
                                    </h5>
                                     <p><?=$post->post_excerpt?></p>
                                 <?endwhile;?>


                            <?}?>
            </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();