UNCSurveys: Aplicación Web Colaborativa para Encuestas en su Diseño, Implementación, Difusión y Visualización de Resultados
================================
La aplicación fue desarrollada como parte de una Tesis de grado de la carrera 
Licenciatura en Ciencias de la Computación de la Universidad Nacional del Comahue.

UNCSurveys es una aplicación web de código abierto, que permite diseñar encuestas, brindar acceso a distintas encuestas desarrolladas y publicadas, recolectar y 
visualizar resultados. Brinda además la posibilidad de realizar todo este proceso en forma colaborativa.


INSTALACIÓN
-----------
###Descargar los fuentes del presente repositorio y copiarlos en una carpeta pública del apache.

CONFIGURACIÓN DE LA BASE DE DATOS
-------------
UNCSurveys trabaja con el motor de base de datos MYSQL.

Crear una Base de datos en base al archivo que esta en la carpeta /BD del proyecto.

Editar el archivo `libs/PDOConfig.php` los datos de conexión a la base creada  

```php
    public function __construct(){
        $this->engine = 'mysql';
        $this->host = 'localhost';
        $this->database = 'uncsurveysdb';
        $this->user = 'usuario';
        $this->pass = 'password';
        $this->debug = false;
    }
```

LENGUAJE R
-----------
R es un lenguaje de programación interpretado, orientado a el cálculo estadístico y generación 
de gráficos. Es multiplataforma, de distribución libre, bajo Licencia GNU. 
UNCSurveys implementa el análisis de encuestas usando R.


INSTALACIÓN DE INTERPRETE DE R EN UBUNTU

sudo add-apt-repository "deb http://cran.rstudio.com/bin/linux/ubuntu $(lsb_release -cs)/"

sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys E084DAB9

sudo apt-get update

sudo apt-get install r-base r-base-dev


INSTALACIÓN DE PAQUETE RMySQL

sudo apt-get install r-cran-rmysql

OTROS PARAMETROS A CONFIGURAR

Editar el archivo `Negocios/parametrosConfig.php` con los siguientes datos:  

```php
    define("_RPATH", "usr/bin/Rscript"); //Path al interprete de R
    define("_LINKREC", "http://midominio/r/index.php"); //URL de acceso a encuesta 
    define("_LINKUNCSURVEY", "http://midominio/index.php"); //URL de acceso a UNCSurveys 

    define("_SMTP", "smtp.gmail.com"); //Servidor SMPT desde donde se envían los emails  
    define("_FROM", "direccionEmail"); // Cuenta desde donde se envían los emails
    define("_EMAILUSR", "direccionEmail"); // Cuenta para el envío los emails
    define("_EMAILPASS", "passCuenta"); // Password de la cuenta para el envío los emails
    define("_PUERTO", 465);// Puerto SSL
```