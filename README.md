# Examen De Campo A Campo

El programa utiliza el framework slim v4 solamente para realizar aprovechar el ruteo, para poder instalarlo en el raiz del directorio se encuentra el archivo "deCampoACampo.sql" que les permite crear la base de datos.

- Ejecutar "composer install" en el directorio del sistema para poder descargar las librerias necesarias para que el sistema funcione.

- La configuración de los parámetros de conexion a la BD se encuentran en "Src/Config/env.php", en ese mismo archivo se puede configurar el valor del dolar. 

- En el archivo "App/routes.php" se encuentran definidas las rutas de la API que son: 
	
	GET		"/"					Muestra la página principal.
	GET		"/products"			Obtiene todos los productos.
	GET		"/products/{id}"	Obtiene el detalle de un producto.
	POST	"/product/new"		Crea un nuevo producto.
	POST	"/product/update"	Actualiza los datos del producto.
	DELETE	"/product/{id}"		Borra un producto.

- El archivo "/src/Lib/DBConn.php" es la clase que crea la conexión con la BD.

- El archivo "/src/Models/Product.php" Contiene la clase que realiza las consultas a la BD.

- El archivo "/src/Transformers/ProductOutputTransformer.php" se utiliza para formatear la salida de datos de los productos agregando el precio en dolares del mismo.

- En la carpeta "src/Templates/" se encuentran los archivos del front