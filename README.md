# vhostwinautomate
Automatiza el proceso de creación de virtual Host para apache en windows.

### Funciones 
- automatiza el proceso de creación del certificado SSL con la herramienta openssl que viene por defecto en las instalaciones de XAMPP para windows .
- Agrega al archivo httpd-vhosts.conf los virtualhost y configura toda la estructura necesaria para trabajar bajo un nombre de dominio con una conexion SSL en localhost.
- Modifica  archivo hosts de windows apunta el dominio para resolucion DNS desde localhost

### Requisitos
- [ ] deberá ejecutar este script con privilegios elevados
- [ ] php deberá estar en el PATH.

### En proximos releases...
- [ ]  A este script le falta automatizar el proceso de instalar el certificado creado mediante la herramienta certmgr a certificado local / Entidades de certificacion raiz de confianza  / certificados
- [ ]  Eliminar los archivos sslpr.bat y cert.conf al terminar la ejecucion de script
