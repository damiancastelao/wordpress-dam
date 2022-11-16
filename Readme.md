# Wordpress

---

## Configuración docker-compose

---

## Configuración de plugin

A continuación se describe varos ejemplos para realizar un plugin 

En este [tutorial](https://www.wpexplorer.com/writing-simple-wordpress-plugin/) completo en ingles tienes otra referencia 

Esta es la [documentación completa](https://developer.wordpress.org/plugins/) de los desarrolladores de wordpress

### Cabecera

Lo primero es crear un fichero identificando nuestro plugin, con la cabecera correspondiente

Los [campos](https://developer.wordpress.org/plugins/plugin-basics/header-requirements/) estan descritos en esta documentación

Lo haremos dentro de la carpeta *dam*, dentro de la carpeta *plugins*

Puedes ver el [código](https://github.com/danielcastelao/wordpress-dam/blob/9147612c7b140ff1d0945a918521691ebde2ecb2/html/wp-content/plugins/dam/dam.php#L3-L8) en el fichero:

```
/*
Plugin Name: DAM experimento
Plugin URI: http://www.danielcastelao.org/
Description: Experimentación de varias técnicas para hacer un plugin
Version: 1.0
*/
```

---

### Filtros
Añadiremos una función para que actúe un filtro

Un filtro (`add_filter`) ocurre cada vez que wordpress realiza una función

Por ejemplo, si queremos modificar el contenido de un post cuando éste es mostrado, utilizaremos el filtro *'the_content'*

Aqui tienes la [lista de filtros](https://codex.wordpress.org/Plugin_API/Filter_Reference) que puedes usar en wordpress

Para añadir un filtro en nuestro plugin que cambie la palabra "WordPress" por "WordPressDAM", añadiríamos lo siguiente: 

```
function renym_wordpress_typo_fix( $text ) {
return str_replace( 'WordPress', 'WordPressDAM', $text );
}

add_filter( 'the_content', 'renym_wordpress_typo_fix' );
```

### Uso de la base de datos

Este es el [tutorial](https://codex.wordpress.org/Creating_Tables_with_Plugins) para usar la base de datos en los plugins

Utilizamos el objeto global `$wpdb` para acceder a la base de datos y la función `dbDelta($sql)` para ejecutar sqls


```
global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

// le añado el prefijo a la tabla
$table_name = $wpdb->prefix . 'dam';

// creamos la sentencia sql

$sql = "CREATE TABLE IF NOT EXISTS $table_name (
id mediumint(9) NOT NULL AUTO_INCREMENT,
time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
name tinytext NOT NULL,
text text NOT NULL,
url varchar(55) DEFAULT '' NOT NULL,
PRIMARY KEY (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
```

Podemos usar este código cuando cargamos el plugin.

### Acciones

Esto se hace mediante la acción:

```
function myplugin_update_db_check() {
  (...)
}

add_action( 'plugins_loaded', 'myplugin_update_db_check' );
```

Una [acción](https://developer.wordpress.org/plugins/hooks/actions/) es parecido a un filtro.

La diferencia es que no modifica los datos, si no, que ejecuta una función en algún momento de las acciones del wordpress
