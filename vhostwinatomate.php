<?php

$domain = readline("ingrese el nombre del dominio con extension: ");
$route = readline("indique la ruta donde estaran los datos del virtual server: ");
$ruta_xampp = readline("Indique la ruta de instalacion de xampp: "); 

##validar errores de ejecucion en los comandos de shell exec

##realizar un menu

/* if(!$data_domain['path']){
print("el dominio $domain no es un dominio valido");
}	 */

/* function menu(){
items del menu
ver dominio virtual
nuevo dominio virtual
eliminar dominio virtual
} */

$ruta_host=$ruta_xampp."\\apache\\conf\\extra\\";
$archivo_virtualhost="httpd-vhosts.conf";
$apache_cert_dst="\\apache\\crt";
$apache_bin_ssl="\\apache\\bin\\openssl";

$SSL = readline("Desea crear certificado SSL para este dominio {Y/N]: ");

if($SSL=="y" || $SSL="Y"){

 ##write cert.conf
 $file = fopen("cert.conf","a+");
fwrite($file,"[ req ]".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"default_bits = 2048".PHP_EOL);
fwrite($file,"default_keyfile = server-key.pem".PHP_EOL);
fwrite($file,"distinguished_name = subject".PHP_EOL);
fwrite($file,"req_extensions = req_ext".PHP_EOL);
fwrite($file,"x509_extensions = x509_ext".PHP_EOL);
fwrite($file,"string_mask = utf8only".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"[ subject ]".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"countryName = Country Name (2 letter code)".PHP_EOL);
fwrite($file,"countryName_default = CO".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"stateOrProvinceName = State or Province Name (full name)".PHP_EOL);
fwrite($file,"stateOrProvinceName_default = Cundinamarca".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"localityName = Locality Name (eg, city)".PHP_EOL);
fwrite($file,"localityName_default = Bogota".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"organizationName = Organization Name (eg, company)".PHP_EOL);
fwrite($file,"organizationName_default = 1004 - Enterprise, LLC".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"commonName = Common Name (e.g. server FQDN or YOUR name)".PHP_EOL);
fwrite($file,"commonName_default = $domain".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"emailAddress = Email Address".PHP_EOL);
fwrite($file,"emailAddress_default = test@example.com".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"[ x509_ext ]".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"subjectKeyIdentifier = hash".PHP_EOL);
fwrite($file,"authorityKeyIdentifier = keyid,issuer".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"basicConstraints = CA:FALSE".PHP_EOL);
fwrite($file,"keyUsage = digitalSignature, keyEncipherment".PHP_EOL);
fwrite($file,"subjectAltName = @alternate_names".PHP_EOL);
fwrite($file,"nsComment = \"OpenSSL Generated Certificate\"".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"[ req_ext ]".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"subjectKeyIdentifier = hash".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"basicConstraints = CA:FALSE".PHP_EOL);
fwrite($file,"keyUsage = digitalSignature, keyEncipherment".PHP_EOL);
fwrite($file,"subjectAltName = @alternate_names".PHP_EOL);
fwrite($file,"nsComment = \"OpenSSL Generated Certificate\"".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"[ alternate_names ]".PHP_EOL);
fwrite($file,"".PHP_EOL);
fwrite($file,"DNS.1 = $domain".PHP_EOL);
fclose($file);
#write ssl-generator

$file = fopen("sslpr.bat","a+");
fwrite($file,"@echo off".PHP_EOL);
fwrite($file,"if not exist $ruta_xampp$apache_cert_dst\\".$domain." mkdir $ruta_xampp$apache_cert_dst\\".$domain."".PHP_EOL);
fwrite($file,''.PHP_EOL);
fwrite($file,"$ruta_xampp$apache_bin_ssl req -config cert.conf -new -sha256 -newkey rsa:2048 -nodes -keyout $ruta_xampp$apache_cert_dst\\".$domain."\\server.key -x509 -days 365 -out $ruta_xampp$apache_cert_dst\\".$domain."\\server.crt".PHP_EOL);
fwrite($file,'pause'.PHP_EOL);
fclose($file);

echo exec('cmd /c sslpr.bat');

$NewRoute=str_replace("\\","/",$route);

$file = fopen($ruta_host.$archivo_virtualhost, "a");
fwrite($file,"".PHP_EOL);
fwrite($file,"<VirtualHost $domain:80>".PHP_EOL);
fwrite($file,"   DocumentRoot \"$NewRoute\"".PHP_EOL);
fwrite($file,"    ServerName $domain".PHP_EOL);
fwrite($file,"    ServerAlias www.$domain".PHP_EOL);
fwrite($file,"        <Directory \"$NewRoute\">".PHP_EOL);
fwrite($file,"        	AllowOverride All".PHP_EOL);
fwrite($file,"        	Require all Granted".PHP_EOL);
fwrite($file,"        </Directory>".PHP_EOL);
fwrite($file,"    Redirect / https://$domain".PHP_EOL);
fwrite($file,"</VirtualHost>".PHP_EOL);
fclose($file);


$file = fopen($ruta_host.$archivo_virtualhost, "a");
fwrite($file,"".PHP_EOL);
fwrite($file,"<VirtualHost $domain:443>".PHP_EOL);
fwrite($file,"   DocumentRoot \"$NewRoute\"".PHP_EOL);
fwrite($file,"    ServerName $domain".PHP_EOL);
fwrite($file,"    ServerAlias www.$domain".PHP_EOL);
fwrite($file,"        <Directory \"$NewRoute\">".PHP_EOL);
fwrite($file,"        	AllowOverride All".PHP_EOL);
fwrite($file,"        	Require all Granted".PHP_EOL);
fwrite($file,"        </Directory>".PHP_EOL);
fwrite($file,"    SSLEngine on".PHP_EOL);
fwrite($file,"    SSLCertificateFile \"$ruta_xampp$apache_cert_dst\\$domain\\server.crt\"".PHP_EOL);
fwrite($file,"    SSLCertificateKeyFile \"$ruta_xampp$apache_cert_dst\\$domain\\server.key\"".PHP_EOL);
fwrite($file,"    Header always set Strict-Transport-Security \"max-age=4838400; includeSubdomains;\"".PHP_EOL);
fwrite($file,"</VirtualHost>".PHP_EOL);
fclose($file);
echo 'write Domain on vhosts \r\n';
}elseif($SSL=="N" || $SSL=="n"){
	
$NewRoute=str_replace("\\","/",$route);

$file = fopen($ruta_host.$archivo_virtualhost, "a");
fwrite($file,"".PHP_EOL);
fwrite($file,"<VirtualHost $domain:80>".PHP_EOL);
fwrite($file,"   DocumentRoot \"$NewRoute\"".PHP_EOL);
fwrite($file,"    ServerName $domain".PHP_EOL);
fwrite($file,"    ServerAlias www.$domain".PHP_EOL);
fwrite($file,"        <Directory \"$NewRoute\">".PHP_EOL);
fwrite($file,"        	AllowOverride All".PHP_EOL);
fwrite($file,"        	Require all Granted".PHP_EOL);
fwrite($file,"        </Directory>".PHP_EOL);
fwrite($file,"</VirtualHost>".PHP_EOL);
fclose($file);
}

$file = fopen("C:\\Windows\\System32\\drivers\\etc\\hosts", "a");
fwrite($file,"	127.0.0.1	$domain".PHP_EOL);
echo 'write on Hosts \n';
?>