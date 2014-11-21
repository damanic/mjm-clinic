<?php
/*
Template Name: MJM Clinic Service Categories
*/

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$term_meta = get_option( "taxonomy_$term->term_id" );
$child_terms = mjm_clinic_get_sub_service_categories($term->term_id);

get_header();

?>


<!-- START CONTENT -->
<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <header class="page-header">
            <p><?=$term_meta['excerpt']?></p>
        </header>


        <div class="page-content">

                <?
                             if ( have_posts() ) { ?>


                                 <?
                                 // Start the Loop.
                                 while ( have_posts() ) : the_post();

                                     get_template_part( 'content', get_post_format() );

                                 endwhile;?>


                            <?} else { ?>

                                 <?php
                                 if ($child_terms) {
                                     ?>
                                     <p>Sub-Categories</p>
                                     <ul>
                                         <? foreach ($child_terms as $child_term) { ?>
                                             <li><a href="#"><?= $child_term->name ?></a></li>
                                         <? } ?>
                                     </ul>
                                 <?
                                 }
                             }?>
            </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();