<?php

/*
Plugin Name: DAM experimento
Plugin URI: http://www.danielcastelao.org/
Description: Experimentación de varias técnicas para hacer un plugin
Version: 1.0
*/

/**
 * Reemplaza plabra
 * @param $text el contenido del post
 * @return array|string|string[] el contenido del post modificado
 */
function renym_wordpress_typo_fix( $text ) {
    return str_replace( 'WordPress', 'WordPressDAM', $text );
}

/**
 * Añadimos la función renym_wordpress_typo_fix al filtro 'the_content'
 * Se ejecutará cada vez que se cargue un post
 */
add_filter( 'the_content', 'renym_wordpress_typo_fix' );
