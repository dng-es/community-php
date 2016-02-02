---
Title:  Community-php  
Author: David Noguera Gutierrez
Date:   February 2, 2016
heroimage: "https://github.com/dng-es/community-php/blob/master/documentacion/cuore.png"
tags:
- Community
- php
---
# Community-php
v. 0.4.6
> Comunidad de usuarios php5 y mysql, creada por componentes/módulos. Incluye soporte para idiomas, herramienta console para generación de módulos y otras tareas.

* [Requisitos y dependencias](#requisitos-y-dependencias)
* [Instalación](#instalacion)
* [Entorno desarrollo](#entorno-desarrollo)
* [Estructura de archivos y directorios](#estructura-de-archivos-y-directorios)
* [Herramienta console](#herramienta-console)
* [Idiomas](#idiomas)
* [Debug mode](#debug-mode)
* [Referencia funciones](#referencia-funciones)
* [Modules](#modules)
* [Seguridad](#seguridad)
* [Forms](#forms)


## Requisitos y dependencias
- PHP 5.3 o superior.
- FFMPEG para la conversión de videos. Librerias libx264 y libfaac necesarias.


## Instalación
Copiar a servidores de producción el contenido de la carpeta httpdocs, el resto de directorios y ficheros solo son necesarios para desarrollo.
- Establecer configuración principal en el fichero: app/core/config.php (<b>IMPORTANTE</b>: desactivar debug mode en servidores de producción o establecer salida a fichero de log)
- Permisos de escritura en los directorios: images/usuarios, images/foro, images/mailing, docs/
- Establecer configuración CKFinder: modificar $baseUrl y $baseDir en js/libs/CKFinder/config.php
- Establecer configuración de la comunidad desde el panel de administración->Datos generales


## Entorno desarrollo
Para la creación de un entorno de desarrollo con <a target="_blank" href="https://www.vagrantup.com/">Vagrant</a> emplear los archivos Vagrant y bootstrap.sh. Configurar correctamente rutas necesarias, ver <a href="#instalacion">instalación</a> - *utils/Vagrant*. Ver el archivo README para mas detalles - *utils/Vagrant/README*.

- GRUNT para la generación de ficheros CSS y JS (gruntfile.js esta en /bin)
- La hoja de estilos .CSS esta creada con SASS y COMPASS (styles.scss)

En la carpeta *utils/VirtualHost* esta el fichero de ejemplo para crear un host vistual: *comunidad.local.com.conf*. Ver el archivo README para mas detalles - *utils/VirtualHost/README*.

Para el desarrollo con **SublimeText**, existen snipets con funciones de la app - *utils/SublimeText/snipets*.

### Librerias de terceros
- **jQuery**: *js/jquery.php* - Javascript.
- **Bootstrap**: *css/bootstrap.min.css - js/bootstrap.min.js*
- **Bootstrap Datepicker**: *js/bootstrap-datepicker.js* - Javascript. Datapicker para formularios
- **Bootstrap Dropdown**: *js/bootstrap-dropdown.js* - Javascript. Incluye efecto de despligue de los dropdowns de bootstrap al hacer over sobre el elemento
- **Bootstrap FileInput**: *js/bootstrap.file-input.js* - Javascript. modifica aspecto de los input file
- **CKEditor**: *js/libs/ckeditor* - Javascript. Editor WYSIWYG
- **CKFinder**: *js/libs/ckfinder* - Javascript. Subida de archivos integrado en CKEditor
- **amCharts**: *js/libs/amcharts* - Javascript. Generación de gráficos
- **JWPlayer**: *js/libs/jwplayer* - Javascript. Reproductor de video
- **SweetAlert**: *js/libs/sweetalert* - Javascript. Muestra pop-ups para los avisos.
- **SwiftMailer**: *app/core/Swift-5.1.0* - php. Envío de emials
- **gpyc**: *app/core/gpyc-0.5* - php. Lectura y escritura de YAML
- **resizeImage**: *app/core/class.resizeimage.php* - php. Clase para generar miniaturas de imágenes
- **Zipfile**: *app/core/class.zipfile.php)* - php. Clase para generación de ficheros ZIP



## Estructura de archivos y directorios
La estructura de archivos y directorios básica es la siguiente:

###Estructura general

    ├── bin                     - herramienta de consola
    ├── documentacion           - documentación sobre la comunidad
    ├── httpdocs
    │   ├── css                 - Archivos CSS principales
    │   ├── docs                - directorio de almacenamiento de documentos
    │   ├── images              - directorio para imágenes
    │   ├── app
    │   │   ├── core            - núcleo del sistema
    │   │   ├── languajes       - archivos generales de traducciones
    │   │   └── modules         - directorio que contiene todos los módulos
    │   │
    │   └── js                  - archivos javascript generales de la comunidad
    │
    └── utils                   - herramientas utiles para desarrollo

###Estructura de un módulo
Módulos con versión menor 1.0 no están completamente testeados o finalizados.

    ├── my_module
    │   ├── classes             - acceso a la base de datos desde el módulo
    │   ├── controllers         - controladores del módulo
    │   ├── pages               - páginas del módulo
    │   ├── resources           - recursos del módulo
    │   │   ├── css             - archivos CSS del módulo
    │   │   ├── images          - imágenes del módulo
    │   │   ├── js              - javascripts del módulo
    │   │   └── languages       - ficheros de idiomas del módulo
    │   │
    │   ├── templates           - plantillas del módulo
    │   ├── config.yaml         - Opciones de configración del módulo
    │   └── my_module.php       - fichero de general del módulo
    │


## Herramienta console
>Aplicación de consola para la realizacion de tareas como la creación de módulos, búsqueda de páginas en la estructura de directorios de la app, etc.

Ejemplo de uso:

```bash
php bin/console options
```
Donde las opciones de console son:

* [createmodule](#createmodule)
* [findpage](#findpage)
* [showmodules](#showmodules)

### createmodule
Crea nuevo módulo con su estructura de directorios y ficheros básicos. Uso: 
```bash
php bin/console createmodule
```
Tras ejecutar el comando se preguntará por el nombre del nuevo modulo.

### findpage
Encuentra una pagina. Muestra en que módulo se encuentra. Uso:
```bash
php bin/console findpage
```
Tras ejecutar el comando se preguntará por la página a buscar. Si la página es encontrada mostrará su ruta.

### showmodules
Muestra todos los modulos con su información. Uso:
```bash
php bin/console showmodules
```
Tras ejecutar el comando se mostrarán todos los modulos instalados.

## Idiomas
Soporte para idiomas implementado. Establecer idioma en app/core/config.php. Los ficheros de traducciones se encuentran en app/languages. Cada módulo cuenta con sus propios ficheros de traducciones en app/modules/module_name/resources/languages.

Para mas información sobre el uso e las traducciones ver [strTranslate()](#strtranslate).

## Debug mode
Se puede activar desde app/core/config.php con la variable debug_app. Opciones:
- 0: debug mode desactivado
- 1: debug mode activado, salida por pantalla.
- 2: debug mode activado, salida a fichero log (app/core/errors.log). Sólo se registrarán los errores Php y sql, no se mostrarán las sentencias sql ejecutadas con éxito.

**IMPORTANTE: desactivar debug mode en servidores de producción (debug_app = 0) o establecer salida a fichero de log (debug_app = 2).**


## Referencia funciones
<span style="float:right">[Inicio](#community-php)</span>
> Funciones de la app, las funciones principales y otras funciones útiles.

### Core
* [addCss](#addcss)
* [addJavascripts](#addJavascripts)
* [getAsset](#getasset)
* [getListModules](#getlistmodules)
* [redirectURL](#redirecturl)
* [templateload](#templateload)

### Generación y procesamiento de archivos
* [array2csv](#array2csv)
* [fileToZip](#filetozip)
* [HTMLtoPDF](#htmltopdf)
* [uploadFileToFolder](#uploadfiletofolder)

### Sesiones
* [AccessLevel](#accesslevel)
* [createSession](#createsession)
* [destroySession](#destroysession)
* [setFlashMessage](#setflashmessage)
* [getFlashMessage](#getflashmessage)
* [ValidateSessionAjax](#validatesessionajax)

### Manejo de cadenas
* [createRandomPassword](#createrandompassword)
* [getDataFormat](#getDataFormat)
* [NormalizeText](#normalizetext)
* [sanitizeInput](#sanitizeinput)
* [showHtmlLinks](#showhtmllinks)
* [shortText](#shorttext)
* [strTranslate](#strtranslate)
* [e_strTranslate](#e_strtranslate)

### Validaciones
* [validateDate](#validatedate)
* [validateEmail](#validateemail)
* [validateNifCifNie](#validatenifcifnie)

### Base de datos
* [execute_query](#execute_query)
* [getSQL](#getsql)
* [SelectMaxReg](#selectmaxreg)
* [countReg](#countreg)
* [sumReg](#sumreg)
* [timeServer](#timeserver)

### Otras funciones
* [getBrowser](#getbrowser)
* [getPlatform](#getplatform)
* [messageProcess](#messageprocess)
* [noCache](#nocache)
* [Paginator](#paginator)
* [SearchForm](#searchform)


## Core
<span style="float:right">[Inicio](#community-php)</span>
>Métodos y funciones principales de la app - *httpdocs/app/core/functions.core.php*

### addCss
Agrega los ficheros Css específicos de una paguna. Uso:
```php
//my_page.php
addCss("css/my_page.css");
```

### addJavascripts
Agrega los ficheros JS específicos de una paguna. Uso:
```php
//my_page.php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("my_module")."js/my_page.js"));
```
Agrega los arvivos bootstrap.file-input.js y my_page.js, donde my_page.js pertenece al módulo my_module (para su carga se emplea la función [getAsset()] (#getasset)).

### getAsset
Obtiene la ruta de los assets del módulo especificado con $modulename. Uso:
```php
getAsset($modulename);
```

### getListModules
Devuelve un array con todos los módulos instalados. Uso:
```php
getListModules();
```

### redirectURL
Redirecciona a la url especificada. Uso:
```php
redirectURL($url);
```
### templateload
Carga la plantilla especificada con $template situada en el módulo especificado con $modulename. Uso:
```php
templateload($template,$modulename);
```

## Generación y procesamiento de archivos
<span style="float:right">[Inicio](#community-php)</span>
> Funciones y métodos útiles para el tratamiento de ficheros (generacion  CSV, ZIP, PDF, etc.). Todas las funciones están disponibles en cualquier ámbito a de la app. Incluidas en el fichero *httpdocs/app/core/functions.php*

### array2csv
Exporta a CSV un array, donde $array sera el array de registros a exportar. Uso, primero se envian las cabeceras para descarga:
```php
download_send_headers("nombre_fichero.csv");
array2csv($array);
```
**IMPORTANTE:** debe colacarse al comienzo de la página ya que se envía por las cabeceras HTTP y posterior a verificación de acceso en paginas de administración o con privilegios especiales.


### fileToZip
Comprime a zip el fichero especificado por $filename alojado en la ruta $path. Uso:
```php
fileToZip($filename, $path);
```
**IMPORTANTE:** debe colacarse al comienzo de la página ya que se envía por las cabeceras HTTP y posterior a verificación de acceso en paginas de administración o con privilegios especiales.

### HTMLtoPDF
Convierte a PDF la cadena de texto en formato HTML. Uso:
```php
HTMLtoPDF($content, [$size]);
```
Donde $content será la cadena de texto en formato HTML a convertir a PDF. El parámetro opcional $size indica el tamaño del documento, por defecto A4.

**IMPORTANTE:** debe colacarse al comienzo de la página ya que se envía por las cabeceras HTTP y posterior a verificación de acceso en paginas de administración o con privilegios especiales.
### uploadFileToFolder
Sube un fichero a la ruta especificada. Uso:
```php
uploadFileToFolder($file, $destination);
```
Donde $file será $_FILES['nombre_input_file'] y $destination el directorio donde se ha de subir la imágen


## Sesiones
<span style="float:right">[Inicio](#community-php)</span>
> Colección de funciones y métodos para la creación de sesiones y su manejo. Incluye la implementación de seguridad de la app. Todos los métodos están dentro de la clase **session** - httpdocs/app/core/class.session.php

### AccessLevel
Establece el nivel de acceso a una determinada página. Uso:
```php
$perfiles_autorizados = array("admin", "formador");
session::AccessLevel($perfiles_autorizados);
```
En el ejemplo anterior se restringe el acceso a usuarios con perfil admin y formador

### createSession
Crea una sesión si el usuario y contraseña es correcto. Tras el inicio de sesión si el usuario tiene sus datos pendientes de confirmar se redirige a la página "user-confirm" o a otra pagina establecida por el parámetro opcional $url. Uso: 
```php 
session::createSession($usuario, $password, [$url]);
```

### destroySession
Destruye la sesion actual y redirecciona a la url pasada por parámetro. Uso:
```php 
session::destroySession();
```
Si no se pasa pámetro redirige a "login".

### setFlashMessage
Crea un mensaje flash. Uso:
```php
//mensaje de operación realizada con éxito
session::setFlashMessage( 'actions_message', 'Registro insertado correctamente', 'alert alert-success');

//mensaje de operación realizada con error
session::setFlashMessage( 'actions_message', 'Error al insertar registro', 'alert alert-danger');
```
En el ejemplo se crea el mensaje flash 'actions_message' con el texto 'Registro insertado correctamente' y se le aplica la clase css 'alert alert-success'. Para recuperar un mensaje flash ver [session::getFlashMessage] (#session::getflashmessage).

### getFlashMessage
Obtiene el mensaje pasado por parámetro. Uso:
```php 
session::getFlashMessage( 'actions_message' );
```
Una vez mostrado el mensaje  'actions_message' será borrado de la memoria flash. Para crear un mensaje flash ver [session::setFlashMessage] (#session::setflashmessage).

### ValidateSessionAjax
Comprueba si un usuario esta correctamente autentificado, en caso contrario redirige a "login" o en su defecto a la página indicada por el paámetro opcional $url. Uso:
```php
session::ValidateSessionAjax([$url]);
```

## Manejo de cadenas
<span style="float:right">[Inicio](#community-php)</span>
> Colección de funciones útiles para el manejo de cadenas, fechas, traducciones, etc. Todas estas funciones están disponibles desde cualquier ámbito de la app. Incluidas en el fichero *httpdocs/app/core/functions.php*

### createRandomPassword
Genera una cadena aleatoria. Por defecto la cadena generada es alfanumérica, aunque se puede pasar como segundo parámetro los carateres permitidos. Uso:
```php
$pass = createRandomPassword(7);
$pass = createRandomPassword(7, "abcdefghijkmnopqrstuvwxyz023456789"); //especificando los caracteres aleatorios
```
### getDataFormat
Devuelve una fecha con el formato especificado (DAY, MONTH, MONTH_LONG, YEAR, SHORT, LONG, TIME, DATE_TIME). Uso:
```php
getDataFormat('2014-01-14', 'LONG'); //mostrará -> 14 de Enero 2014
```

### NormalizeText
Eliminada de una cadena de texto los carateres extraños (todo lo que no sean numeros, letras y algún caracter más). Uso:
```php
NormalizeText($text, $text_separator);
```
###sanitizeInput
Limpia una cadena. Utilizada para evitar errores y Sql injection. Uso:
```php
$valor = sanitizeInput($_POST['valor]);
```

### showHtmlLinks
Pone los enlaces html de una cadena de texto. Uso:
```php
$text = 'Texto con un enlace a google.com';
echo showHtmlLinks($text); //mostrará: Texto con un enlace a <a href="http://google.com">google.com</a>
```

### shortText
Acorta un texto añadiendo puntos suspensivos. Uso:
```php
shortText($text_html,$num_car);
```
Donde $text_html será la cadena a cortar y $num_car el numero de caracteres máximo de la cadena

### strTranslate
Traduce la cadena de texto pasada por parámetro en el idioma establecido por defecto. Uso: 
```php
echo strTranslate("Home"); //mostrará la traducción de la palabra 'Home'
```
La cadena de texto a traducir figurará en los ficheros general de idiomas - *httpdocs/app/languages/lan/language.php* o en los ficheros de idionas de los módulos - *httpdocs/app/modules/module_name/resources/languages/lan/language.php*.

### e_strTranslate
Escribe la cadena de texto traducida pasada por parámetro en el idioma establecido por defecto. Uso: 
```php
e_strTranslate("Home"); //mostrará la traducción de la palabra 'Home'
```

## Validaciones
<span style="float:right">[Inicio](#community-php)</span>
> Colección de funciones útiles para la validación de datos. Todas las funciones están disponibles desde cualquier ámbito de la app. Incluidas en el fichero *httpdocs/app/core/functions.php*

### validateDate
Comprueba si una cadena es una fecha válida según el formato especificado. Uso:
```php
$result = validateDate($date, 'Y-m-d H:i:s');
```
La comprobación devolverá true o false.

### validateEmail
Comprueba si un texto si es o no una cuenta de correo válida. Uso:
```php
$result = validateEmail($email);
```
La comprobación devolverá true o false.

### validateNifCifNie
Comprueba si un NIF, CIF o NIE es correcto. Uso:
```php
$result = checkNifCifNie($cif);
```
Devolverá:
- 1 = NIF ok
- 2 = CIF ok
- 3 = NIE ok
- -1 = NIF bad
- -2 = CIF bad
- -3 = NIE bad
- 0 = ??? incorrecto.

## Base de datos
<span style="float:right">[Inicio](#community-php)</span>
> Funciones principales para acceso a la base de datos y otras operaciones. Todos los métodos están dentro de la clase **connection** - httpdocs/app/core/class.connection.php

### execute_query
Ejecuta una consulta sql sobre la base de datos.

```php
$result = connection::execute_query("UPDATE users SET disabled=1 WHERE username='demo' ");
```
Devuelve true o false en función del resultado de la ejecución de la consulta.

### getSQL
Devuelve el resultado de una consulta sql sobre la base de datos.

```php
$result = connection::getSQL("SELECT * FROM users");
```
Devuelve un array de arrays con el resultado de la consulta.

### SelectMaxReg
Devuelve el valor maximo de un campo de una tabla, aplicando el filtro especificado.

```php
$field = "puntos";
$table = "users";
$filter = " AND disabled=0 ";
$maxreg = connection::SelectMaxReg($field, $table, $filter);
```

### countReg
Devuelve el número de registros de una tabla, aplicando el filtro especificado.

```php
$table = "users";
$filter = " AND disabled=0 ";
$counter = connection::countReg($table, $filter);
```

### sumReg
Devuelve la suma de los valores de un campo de una tabla, aplicando el filtro especificado.

```php
$table = "users";
$field = "puntos";
$filter = " AND disabled=0 ";
$sum = connection::sumReg($table, $field, $filter);
```

### timeServer
Devuelve la hora del servidor.

```php
$time_server = connection::timeServer();
```
## Otras funciones
<span style="float:right">[Inicio](#community-php)</span>
>Otras funciones útiles. Incluidas en el fichero *httpdocs/app/core/functions.php*

### getBrowser
Obtiene la versión del navegador según el UserAgent. Uso:
```php
getBrowser($_SERVER['HTTP_USER_AGENT']);
```

### getPlatform
Obtiene el Sistema Operativo según el UserAgent del navegador. Uso:
```php
getPlatform($_SERVER['HTTP_USER_AGENT']);
```
### messageProcess
Envia un email. Uso:
```php
messageProcess( $message_subject,
                $message_from = array('john@doe.com' => 'John Doe'),
                $message_to = array('receiver@domain.org', 'other@domain.org' => 'A name'),
                $message_body,
                $message_attachment = null,
                $message_protocol = "smtp");
```
**$message_protocol** puede ser Mail(valor por defecto), smtp o Sendmail. Si en $message_protocol se emplea smpt, se utilizá la configuración SMTP establecida en el fichero de configuraciópn general *config.php*. Para Sendmail la configuración se establecerá igualmente en *config.php*.

### noCache
Envia cabeceras para eliminar la cache del navegador. Uso:
```php
noCache();
```
### Paginator
Crea un paginador de registros. Uso:
```php
Paginator($pag, $reg, $total_reg, $pag_dest, $title, $find_reg, $num_paginas, $addClass, $pagecount_dest);

//example
Paginator($pag, $reg, $total_reg, 'blog?id='.$id_tema, 'comentarios', $find_reg, 10, 'selected-foro');
```
### SearchForm
Crea un buscador. El metodo de envio del formulario por defecto es *post*. Uso:
```php
SearchForm($reg, $pag, $formId, $labelForm, $labelButton, $clase_css, $class_form, $method_form);

//example
SearchForm($elements['reg'], "admin-users", "searchForm", "buscar usuario", "Buscar", "", "navbar-form");
```

## Modules
<span style="float:right">[Inicio](#community-php)</span>
>Existen modulos necesarios para el funcionamiento de la app: Core, Configuration, Users y Visitas. Se pueden crear nuevos modulos siguiendo la estructura descrita o mediante la herramienta de consola.

* [Menu user](#menu-user)
* [Menu admin](#menu-admin)
* [Module Core](#module-core)
* [Module Users](#module-usuarios)
* [Module Visitas](#module-visitas)
* [Module Configuration](#module-configuration)

Ver la herramienta de consola [createmodule](#createmodule) para la creación de automática de nuevos módulos.

### Menu user
El menu principal de la app se generica dinamicante desde **userMainMenu()** en *httpdocs/app/modules/class.menu.php*. Los elementos al menu son añadidos por cada módulo desde el fichero general de cada módulo - *httpdocs/app/modules/my_module/my_module.php*. El fichero de opciones del módulo debe tener agregada la funcción **userMenu()**:

```php
public static function userMenu(){
    $array_final = array();

    array_push($array_final, array("LabelIcon" => "fa fa-envelope",
                    "LabelItem" => 'Contact',
                    "LabelUrl" => 'contact',
                    "LabelTarget" => '_self',
                    "LabelPos" => 7));

    array_push($array_final, array("LabelIcon" => "fa fa-trophy",
                    "LabelItem" => 'Ranking',
                    "LabelUrl" => 'ranking',
                    "LabelTarget" => '_self',
                    "LabelPos" => 8));

    return $array_final;
}
```
La función devolverá un array con los elementos añadidos por el modulo al menu.


### Menu admin
El menu de admministración de la app se generica dinamicante desde **adminMenu()** en *httpdocs/app/modules/class.menu.php*. Los elementos al menu son añadidos por cada módulo desde el fichero general de cada módulo - *httpdocs/app/modules/my_module/my_module.php*. El fichero de opciones del módulo debe tener agregada la funcción **adminMenu()**:

```php
public static function adminMenu(){
    return array(
        menu::addAdminMenu(array(
            "PageName" => "admin-users",
            "LabelHeader" => "Tools",
            "LabelSection" => strTranslate("Users"),
            "LabelItem" => strTranslate("Users_list"),
            "LabelUrl" => "admin-users",
            "LabelPos" => 1,
        )),
        menu::addAdminMenu(array(
            "PageName" => "admin-cargas-users",
            "LabelHeader" => "Tools",
            "LabelSection" => strTranslate("Users"),
            "LabelItem" => strTranslate("Users_import"),
            "LabelUrl" => "admin-cargas-users",
            "LabelPos" => 2
        ))
    );
}
```
La función devolverá un array con los elementos añadidos por el modulo al menu.

### Module Core
Módulo con páginas genericas: *home*, *404*, *contact*, *underconstruction*.

### Module Configuration
Módulo para establecer la configuración de la app. Tablas en la base de datos:
- config

### Module Users
Módulo para la gestión de usuarios y permisos de usuarios. Tablas en la base de datos:
- users
- users_tiendas
- users_connected
- users_participaciones
- users_permissions
- users_puntuaciones

### Module Visitas
Encargado de generar las estadisticas de acceso a la app. Tablas en la base de datos:
- accesscontrol

## Seguridad
<span style="float:right">[Inicio](#community-php)</span>
Las sesiones están implementadas en el fichero httpdocs/app/core/class.session.php. Para una descripción detalladas de los metodos disponibles ver [Sesiones](#sesiones).

Por defecto, todas las páginas de la Web estarán protegidas por usuario y contraseña. Para hacer una página accesible sin necesidad de loguearse en la app, debemos añadir dicha página al array ***$paginas_free*** (httpdocs/app/core/constants.php).

El acceso al zona de administración sólo será accesible para los usuarios con perfil admin. Todas aquellas páginas que comiencen por admin se entenderá que son páginas protegidas y solo disponibles para usuarios administradores.

Se pueden establecer permisos específicos para cada usuario y a cada página (Modulo users). Desde el panel de administración, se peden editar individualmente los permisos de cada usuario.

## Forms
Se emplean mensajes flash para mostrar avisos sobre el resultado del envio de un formulario. Ejemplo:

En el controlador donde se recibe el formulario, tras las acciones correspondientes crearemos un mensaje de error o de exito. A continuacion con ***redirectUrl()*** redirigimos a la página deseada.

```php
public static function deleteAction(){
    $mymodule = new mymodule();
    if (isset($_REQUEST['id']) and $_REQUEST['id'] != ""){
        if ($mymodule->deleteItem($_REQUEST['id'])) {
            session::setFlashMessage( 'actions_message', "Todo bien!!!", "alert alert-success");}
        else {
            session::setFlashMessage( 'actions_message', "Error!!!", "alert alert-danger");}

        redirectURL("pagename");
    }
}
```

En la página donde es redirigida, normalmente la misma desde la que se envía el formulario, mostraremos el mensaje flash - **IMPORTANTE**: *getFlashMessage()* tiene que ir antes que las llamadas a los controladores
```php
	session::getFlashMessage( 'actions_message' ); 
	mymoduleController::deleteAction();
```

###Formularios predefinidos
####SearchForm()
Muestra por pantalla un formulario de búsqueda. Para más información ver [SearchForm()](#searchform).