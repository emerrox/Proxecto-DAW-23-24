# FASE DE IMPLANTACIÓN

- [FASE DE IMPLANTACIÓN](#fase-de-implantación)
  - [1- Manual técnico](#1--manual-técnico)
    - [1.1- Instalación](#11--instalación)
    - [1.2- Administración do sistema](#12--administración-do-sistema)
  - [2- Manual de usuario](#2--manual-de-usuario)
  - [3- Melloras futuras](#3--melloras-futuras)

## 1- Manual técnico

### 1.1- Instalación

**Requisitos**

  Un servidor como xampp con phpmyadmin y php o un servidor en la nube de terceros en los que subir los archivos o incluso uno dedicado, debe tener php y phpmyadmin

**Descarga e instalación:**

  Bajar la carpeta [www](/www) y añadirlo directamente al htdocs (xamp)

**Configuración de la base de datos**

   [Archivo sql](./utils/kayakplus_schema.sql) para replicar el esquema la base de datos

   [Archivo sql](./utils/kayakplus_schema.sql) para añadir datos de prueba a la base de datos
   
   **Probar**

  Si añadiste los datos de prueba vas a tener registrados 5 usuarios llamados User1, User2, User3 ,etc. y todos con contraseña "abc123."

### 1.2- Administración do sistema

**copias de seguridad**

Una vez terminada la fase de desarrollo, se pasaría todo el proyecto del entorno de pruebas con xamp a un servidor en la nube de terceros, que dentro del servicio ofrece copias de seguridad automaticas tanto de los archivos de la aplicacion como de la base de datos (informacion de usuarios y entrenos)

## 2- Manual de usuario

La web tiene un flujo sencillo e intuitivo pero a mayores se incluira un apartado de preguntas frecuentes o ayuda para algunas acciones en concreto

## 3- Melloras futuras

Para mejorar la seguridad y la facilidad de inicio de sesion y registro de usuarios se implementará oauth de google que ademas permite el uso de la api de google calendar para sincronizar los calendarios
