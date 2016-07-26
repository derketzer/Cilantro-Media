#Cilantro Media#

Se requiere tener composer instalado. De lo contrario seguir las instrucciones en [Symfony](http://symfony.com/doc/current/book/installation.html#linux-and-mac-os-x-systems) para ello.

## Para instalar ##
```console
rm -rf var/cache/*
rm -rf var/logs/*
rm -rf var/sessions/*
```

Posteriormente es necesario revisar esté bien configurado, se pueden seguir las instrucciones de [Symfony](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup)

Instalar los paquetes necesarios  
`composer install`

## Para correrlo ##
Para probar basta con ejecutar el servidor interno de symfony desde la carpeta del código  
`php bin/console server:run`
