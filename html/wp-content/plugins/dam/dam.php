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
	// Objeto global del WordPress para trabajar con la BD
	global $wpdb;

	// recojemos el
	$charset_collate = $wpdb->get_charset_collate();

	// le añado el prefijo a la tabla
	$table_name = $wpdb->prefix . 'dam';

	// recogemos todos los datos de la tabla
	// los metemos en un array asociativo, en vez de indices nnumericos,
	// los indices son los nombres de las columnas de la tabla
	$resultado = $wpdb->get_results("SELECT * FROM " . $table_name, ARRAY_A);

	// recorremos el resultado
	foreach($resultado as $fila)
	{
		// mostramos el resultado en los logs
		error_log("Recorremos resultado: " . $fila['time']);
	}

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
        PRIMARY KEY (id)
    ) $charset_collate;";

    // libreria que necesito para usar la funcion dbDelta
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );


	// insertamos valores

	$name='Pepe';
	$text='Hola Mundo';

	$result = $wpdb->insert(
		$table_name,
		array(
			'time' => current_time( 'mysql' ),
			'name' => $name,
			'text' => $text,
		)
	);

	error_log("Plugin DAM insert: " . $result);
}

/**
 * Ejecuta 'myplugin_update_db_check', cuando el plugin se carga
 */
add_action( 'plugins_loaded', 'myplugin_update_db_check' );
