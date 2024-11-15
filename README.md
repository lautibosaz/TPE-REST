# TPE-REST

La pagina cuenta con los sugientes endpoints:

///PARA LA TABLA GENERO:

http://localhost/web2/TPE-REST/api/generos (Metodo GET) -> Realiza un getAll de todos los generos en la DB.

http://localhost/web2/TPE-REST/api/generos/id (Metodo GET) -> Realiza un get de un genero en especifico por su id.

http://localhost/web2/TPE-REST/api/generos/id (Metodo DELETE) -> Elimina un genero segun su id.

http://localhost/web2/TPE-REST/api/generos (Metodo POST) -> Permite agregar un genero. En el body debe estar definido un array del siguiente estilo:
{
  "genero":"string",
  "descripcion":"string"
}

http://localhost/web2/TPE-REST/api/generos/id (Metodo POST) -> Permite editar los datos de un genero por su id. En el body debe estar definido un array del siguiente estilo:
{
  "genero":"string",
  "descripcion":"string"
}

///PARA LA TABLA PELICULAS:

http://localhost/web2/TPE-REST/api/peliculas (Metodo GET) -> Realiza un getAll de todas las peliculas en la DB. Estas pueden:
- Filtrarse con ?genero=terror por ejemplo -> (si el genero no existe, salta error).
- Ordenarse con ?orderBy=titulo por ejemplo (y cualquier otro campo de la tabla exceptuando los id).
- El orden puede realizarse de forma ascendente o descendente  con ?direccion=ASC o ?direccion=DESC -> (default esta ASC).

http://localhost/web2/TPE-REST/api/peliculas/id (Metodo GET) -> Realiza un get de una pelicula en especifico por su id.

http://localhost/web2/TPE-REST/api/peliculas/id (Metodo DELETE) -> Elimina una pelicula segun la id.

http://localhost/web2/TPE-REST/api/peliculas (Metodo POST) ->  Permite agregar una película. En el body debe estar definido un array del siguiente estilo: 
{
  "id_genero":"terror", 
  "titulo":"string",
  "director":"string",
  "descripcion":"string",
  "calificacion":"int",
  "estreno":"x/x/x"
} -> (Si el genero no existe salta error).

http://localhost/web2/TPE-REST/api/peliculas/id (Metodo PUT) -> Permite editar los datos de una pelicula por su id. En el body debe estar definido un array del siguiente estilo:
{
  "titulo":"string",
  "director":"string",
  "descripcion":"string",
  "calificacion":"int",
  "estreno":"x/x/x"
}

