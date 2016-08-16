<?php
; Author: David Noguera Gutierrez
; License: GPL
; Date: 2010-03-01
; Description: login users
; Please don´t remove these lines


[first_section]
;Datos principales de configuracion: conexión base de datos,
;configuración servidor web y rutas, ...
;HOST
host = "localhost"

;USER BBDD
user = "comunidad"

;PASSWORD BBDD
pass = "comunidad"

;BBDD
db = "comunidad"

;Sql connector. Posibles valores: mysql, mysqli
sql_connector = "mysqli"

;DEBUG OPTIONS. Poner 0 en servidores de producción. 1 salida por pantalla. 2 salida fichero error
debug_app = 0

;UNDERCONSTRUCTION - only admins can access. Values: true or false
underconstruction = false

[SMTP settings]
smtp_domain = "smtp.example.org"
smtp_port = 25
smtp_user = "your username"
smtp_pass = "your password"

[Sendmail settings]
sendmail_command = "/usr/sbin/sendmail -bs"
?>