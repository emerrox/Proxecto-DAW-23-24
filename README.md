# Proxecto fin de ciclo

- [Proxecto fin de ciclo](#proxecto-fin-de-ciclo)
  - [Taboleiro do proyecto](#taboleiro-do-proyecto)
  - [Descrición](#descrición)
  - [Instalación / Posta en marcha](#instalación--posta-en-marcha)
  - [Uso](#uso)
  - [Sobre o autor](#sobre-o-autor)
  - [Licenza](#licenza)
  - [Índice](#índice)
  - [Guía de contribución](#guía-de-contribución)
  - [Links](#links)

## Taboleiro do proyecto

Proyecto en fase de desarrollo

## Descrición

KayakPlus es una aplicación diseñada para brindar apoyo a los deportistas y entrenadores de cualquier deporte de embarcaciones ligeras. Los entrenadores podrán seguir, organizar y ver estádisticas de los entrenamientos de sus deportistas de forma detallada, al organizar entrenos podran elegir a que deportistas asignarlos y el dia y los propios deportistas pueden ver el programa semanal que le corresponde para su categoria y modalidad.

## Instalación / Posta en marcha

Usar xampp 8.2.4-0 con phpmyadmin 5.2.1 y PHP 8.2.4, copiar el contenido de la carpeta [www](/www) en htdocs y en el phpmyadmin ejecutar el archivo sql para [crear la bbdd](/doc/utils/kayakplus_schema.sql) y opcionalmente el de [insercion de datos](/doc/utils/kayakplus_pruebas.sql) de prueba

## Uso

- **Registro de usuario:** Permite a los usuarios registrarse en la plataforma, añadiendo sus datos a la base de datos.
- **Inicio de sesión:** Al iniciar sesión, los usuarios son redirigidos a la página de inicio de su sesión.
- **Añadir entreno:** Los entrenadores pueden añadir un nuevo entreno a la base de datos.
- **Modificar entreno:** Los entrenadores pueden modificar los detalles de un entreno existente en la base de datos.
- **Eliminar entreno:** Los entrenadores pueden eliminar un entreno de la base de datos.
- **Abrir entreno:** Los usuarios pueden ver información detallada de un entreno específico en la página web.
- **Crear grupo:** Se crea un grupo en la bbdd y el usuario que lo crea se convierte en entrenador.
- **Entrar a grupo:** Se relaciona un grupo y un usuario como deportista.
- **Eliminar grupo:** Se borran todos los datos del grupo.
- **Salir del grupo:** Se borra la relacion entre el usuario y el grupo.
- **Editar grupo:** El entrenador puede cambiar o editar la relacion de los demas usuarios con el grupo.

## Sobre o autor

Soy mauro cordal, manejo técnologias tanto de front-end como html,css,javascript como de back-end php o java también con bases de datos. Ademas en mi tiempo libre hago kayakismo, por eso, vi la necesidad de una aplicación para que los entrenadores y deportistas puedan llevar un registro detallado de sus entrenamientos y así mejorar su rendimiento.

**Contacto:**
- Correo electrónico: [maurocordal@gmail.com](mailto:maurocordal@gmail.com)
- GitHub: [Emerrox](https://github.com/emerrox)

## Licenza

Este proyecto está licenciado bajo la [Licencia Pública General de GNU (GPL-3.0)](LICENSE).

## Índice

1. [Anteproyecto](doc/1_Anteproxecto.md)
2. [Análise](doc/2_Analise.md)
3. [Deseño](doc/3_Deseño.md)
4. [Codificación e probas](doc/4_Codificacion_e_probas.md)
5. [Implantación](doc/5_Implantación.md)
6. [Referencias](doc/6_Referencias.md)
7. [Incidencias](doc/7_Incidencias.md)

## Guía de contribución

1. Clona el repositorio
2. Realiza los cambios
3. Haz commit
4. Abre una pull request

## Links

- [Selector de colores](https://htmlcolorcodes.com/es/selector-de-color/)
- [Documentacion de fullcalendar](https://fullcalendar.io/)

