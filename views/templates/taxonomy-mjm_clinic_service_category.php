<?php
/*
Template Name: MJM Clinic Service Categories
*/

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$term_meta = get_option( "taxonomy_$term->term_id" );


get_header();

?>


<!-- START CONTENT -->
<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <header class="entry-header">
            <h1 class="entry-title"><?php echo $term->name?></h1>
            <p><?php echo $term_meta['excerpt']?></p>
        </header>


        <div class="page-content">
            <?php echo do_shortcode('[mjm-clinic-service-box-links]')?>

            </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
?>