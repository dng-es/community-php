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
user = "root"

;PASSWORD BBDD
pass = "Admin*1m4g4r37"

;BBDD
db = "comunidad2"

;Sql connector. Posibles valores: mysql, mysqli
sql_connector = "mysqli"

;DEFAULT LANGUAGE
language = "es"
language_selector = true

;DEBUG OPTIONS. Poner 0 en servidores de producción. 1 salida por pantalla. 2 salida fichero error
debug_app = 0

[SMTP settings]
smtp_domain = "smtp.example.org"
smtp_port = 25
smtp_user = "your username"
smtp_pass = "your password"

[Sendmail settings]
sendmail_command = "/usr/sbin/sendmail -bs"
?>