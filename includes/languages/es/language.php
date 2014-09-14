<?php
///////////////////////////////////////////////////////////////////////////////////
// LOCALE, DATE AND TIME DEFINITIONS
///////////////////////////////////////////////////////////////////////////////////
@setlocale(LC_TIME, 'es_ES.ISO_8859-1');
setlocale(LC_TIME, 'spanish');
date_default_timezone_set('Europe/Madrid');
define('DATE_MONTH', '%m');  // this is used for strftime()
define('DATE_DAY', '%d');  // this is used for strftime()
define('DATE_YEAR', '%Y');  // this is used for strftime()
define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y');  // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('TIME_FORMAT', ' %H:%M:%S');


Hello = "Hola"
Home = "Inicio"
Contact = "Contactar"
Your_message = "Tu mensaje"
Message_subject = "Asunto del mensaje"
Introduce_subject = "Escribe el asunto"
Introduce_your_message = "Escribe tu mensaje"
Send_us_an_email = "Envíanos un mensaje con tus consultas."
Edit = "Editar"
Send ="Enviar"
Send_data = "Enviar datos"
Save = "Guardar"
Save_data = "Guardar datos"
Delete = "Borrar"
Are_you_sure_to_delete = "¿Seguro que deseas borrar el elemento?"
Go_back = "volver"
Click_here ="pincha aquí"
Error_procesing = "Se ha producido un error, por favor intentelo más tarde"
Update_procesing = "Datos actualizados correctamente"
Insert_procesing = "Datos insertados correctamente"
Tools = "Herramientas"
Import_file = "Importar archivo"
Choose_file = "Seleccionar archivo"
Search = "Buscar"
Export = "Exportar"
Nick = "Alias"
Name = "Nombre"
Surname ="Apellidos"
Address = "Dirección"
Born_date = "Fecha nacimiento"
Picture = "Foto"
Change_picture = "Cambiar foto"
Rights_and_responsabilities = "Declaración de derechos y responsabilidades"
Private_policy = "Política de privacidad"
Acept = "Acepto"
Terms_and_conditions = "Términos y condiciones"
Already_exist = "ya existe"
Total = "Total"
Items = "Registros"
Statistics = "Estadísticas"
Delete_photo = "Borrar foto"
Photo = "Foto"
Main_data = "Datos generales"
says = "dice"
uploaded_by ="subido por"
Date = "Fecha"
Author = "Autor"
Title = "Título"
Description = "Descripción"
Comment = "Comentario"
Comments = "Comentarios"
Reply = "Responder"
Reply_comment = "Responder el comentario"
Vote_comment = "Votar el comentario"
Go_to = "Ir a"
Go_back = "Volver atrás"
Visits = "Visitas"
Characters = "Caracteres";
?>