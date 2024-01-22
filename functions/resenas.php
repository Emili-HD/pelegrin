<?php
/**
 * pelegrinroca funciones reseñas
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pelegrinroca
 */

 add_shortcode( 'f', 'resenas_destacadas' );

 function resenas_destacadas() {
    $args = array(
        'post_type'      => 'resena',
        'posts_per_page' => '1',
        'publish_status' => 'published',
     );

    $query = new WP_Query($args);

    if($query->have_posts()) :

        $result .= '<div class="google">';
        $result .= '<div><img src="/wp-content/uploads/2023/06/average-rating.svg"></div>';
        $result .= '</div>';
        $result .= '<div class="resenas">';

        while($query->have_posts()) :

            $query->the_post() ;

            $rating = get_field('valoracion');
            
            $result .= '<div class="resenas-item">';
            $result .= '<div class="resenas-name">' . get_the_title() . '</div>';
            for ($i = 0; $i < $rating; $i++) {
                $result .= "<i class='fa fa-star'></i>";
            }
            $result .= '<div class="resenas-desc">' . get_the_content() . '</div>'; 
            $result .= '</div>';
        
        endwhile;
        $result .= '</div>';

        wp_reset_postdata();

    endif;    

    return $result; 
 }


function nuevo_resenas($result){

    $result = '<div class="google">';
    $result .= '<div><img src="/wp-content/uploads/2023/06/average-rating.svg"></div>';
    $result .= '</div>';
    $result .= '<div class="resenas">';
    $result .=  do_shortcode( '[trustindex no-registration=google]' );
    $result .= '</div">';

    return $result; 
}

add_shortcode( 'resenas', 'nuevo_resenas' );
