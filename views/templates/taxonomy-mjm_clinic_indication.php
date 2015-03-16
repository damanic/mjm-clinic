<?php
/*
Template Name: MJM Clinic Indication Tags
*/

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

get_header();

?>


<!-- START CONTENT -->
<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">


        <div class="page-content">
            <h1>Symptom: <?php echo $term->name?></h1>
            <p><?php echo wpautop($term->description)?></p>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
?>