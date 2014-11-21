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

               <b>Open Hours:</b>
                   <?= wpautop($location_meta['open_hours']) ?>

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
                    <i class="fa fa-calendar"></i> Book Appointment
                </a></p>
            <? } else if(!empty($location_meta['email'])){?>
            <p> <a href="mailto:<?=antispambot(wp_strip_all_tags($location_meta['email']))?>">
                    <i class="fa fa-envelope"></i> Book Appointment
                </a></p>
            <? } ?>

            <form method="post" id="mjm_clinic_booking_form">
                <input type="hidden" id="mjm-clinic" name="mjm-clinic" value="mjm-clinic">

                <label for="mjm_clinic_booking_form_field_name">Your Name:</label>
                <input id="mjm_clinic_booking_form_field_name" type="text" name="mjm_clinic_booking_form_field_" tabindex="1"/>

                <label for="mjm_clinic_booking_form_field_email">E-mail</label>
                <input id="mjm_clinic_booking_form_field_email" type="text" name="mjm_clinic_booking_form_field_email" tabindex="2"/>

                <textarea id="mjm_clinic_booking_form_field_message" tabindex="4" rows="10" cols="60" name="mjm_clinic_booking_form_field_message"></textarea>
                <input type="submit" value="Send" tabindex="5" />
            </form>



                <?
                             if ( have_posts() ) { ?>
                            <hr/>
                                 <h2>Available Services</h2>

                                 <?while ( have_posts() ) : the_post();?>
                                    <h5>
                                        <i class="fa fa-plus-square"></i>
                                            <a href="<?= get_permalink( $post->ID)?>>">
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