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

/**
 * Añade un tabla a la BD
 * @return void
 */
function myplugin_update_db_check() {
    // Objeto global del WordPress para trabajar con la BD
    global $wpdb;

    // recojemos el
    $charset_collate = $wpdb->get_charset_collate();

    // le añado el prefijo a la tabla
    $table_name = $wpdb->prefix . 'dam';

    // creamos la sentencia sql
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // libreria que necesito para usar la funcion dbDelta
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/**
 * Ejecuta 'myplugin_update_db_check', cuando el plugin se carga
 */
add_action( 'plugins_loaded', 'myplugin_update_db_check' );
