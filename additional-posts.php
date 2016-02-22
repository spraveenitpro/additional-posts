<?php

/*
Plugin Name: Additional Posts
Plugin URI: http://simpletechlife.in
Description: Show Similar posts
Version: 1.0
Author: Praveen Selvasekaran
Author URI: http://simpletechlife.in
License: GPLv2
*/


add_filter( 'the_content', function($content) {
    $id = get_the_id();

    if (!is_singular('post')) {
        return $content;
    }

    $terms = get_the_terms($id, 'category');
    $cats = array();

    foreach ($terms as $term) {
        $cats[] = $term->term_taxonomy_id;
    }


    $loop = new WP_Query(
        array(
            'posts_per_page' => 3,
            'category__in' => $cats

        )
    );

    if ($loop->have_posts()) {
        $content .= '
        <h2>You Might also like...</h2>
        <ul class="related-category-posts">';

        while ($loop->have_posts()) {
            $loop->the_post();

            $content .= '

                <li>
                    <a href="' . get_permalink() . '">' . get_the_title() . '</a>
               </li>';
        }

        $content .= '</ul>';
        wp_reset_query();



    }


    return $content;

});

	?>