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

        <header class="entry-header">
            <h1 class="entry-title"><?=$term->name?></h1>
            <p><?=$term_meta['excerpt']?></p>
        </header>


        <div class="page-content">
            <?
                if ($child_terms){
                $template = (locate_template('/mjm-clinic/boxlink-service-category.php') == '') ? plugin_dir_path(__FILE__) . 'boxlink-service-category.php' : get_stylesheet_directory(__FILE__) . '/mjm-clinic/boxlink-service-category.php';
                ?>
                    <?


                    foreach ($child_terms as $category){
                        $image = false;
                        $image_alt = null;
                        $category_meta = array('excerpt' => null);
                        if(isset($category->image_id) && !empty($category->image_id)) {
                            $images = wp_get_attachment_image_src( $category->image_id, 'mjm-clinic-service-thumb' );
                            if($images) {
                                $image = $images[0];
                                $image_alt = get_post_meta($category->image_id, '_wp_attachment_image_alt', true);
                            }
                        }
                        $category_meta = get_option( "taxonomy_$category->term_id" );
                        include($template);
                    }

                   ?>
              <?}?>

                <?
                 if ( have_posts() ) {
                     $template = (locate_template('/mjm-clinic/boxlink-service.php') == '') ? plugin_dir_path(__FILE__).'boxlink-service.php' : get_stylesheet_directory(__FILE__) . '/mjm-clinic/boxlink-service.php';

                     while ( have_posts() ) : the_post();
                         $img_id = get_post_thumbnail_id($post->ID);
                         $image = wp_get_attachment_image_src( $img_id, 'mjm-clinic-service-thumb' );
                            if($image) {
                                $image_url = $image[0];
                            }
                         include($template);
                     endwhile;
                 }
                ?>

            </div>

    </div><!-- #content -->
</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();