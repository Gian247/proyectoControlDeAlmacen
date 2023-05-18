<?php

class ControladorUsuarios{
    public function ctrIngresoUsuario(){
        if(isset($_POST["ingUsuario"])){
            if(preg_match('/^[a-zA-Z0-9]+$/',$_POST["ingUsuario"]) &&
            preg_match('/^[a-zA-Z0-9]+$/',$_POST["ingPassword"])){

                //$encriptar=crypt($_POST["ingPassword"],'$2a$07$usesomesillystringforsalt$');

                $tabla="usuario";
                $item="user";
                $valor=$_POST["ingUsuario"];
                
                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
                if(is_array($respuesta)){
                    if($respuesta["user"]===$_POST["ingUsuario"] && 
                    $respuesta["contra"]===$_POST["ingPassword"]){
                            
                            //Validar si el usuario esta habilitado o desabilitado del sistema
                            if ($respuesta["estado"]==1){
                                //Iniciamos las variables de sesion
                                $_SESSION["iniciarSesion"]="ok";
                                $_SESSION["id"]=$respuesta["id_usuario"];
                                $_SESSION["nombre"]=$respuesta["nombres"];
                                $_SESSION["apellido"]=$respuesta["apellidos"];
                                $_SESSION["foto"]=$respuesta["foto"];
                                $_SESSION["perfil"]=$respuesta["id_perfil"];

                                //*****Registrar fecha para saber ultimo login *********/
                                
                                date_default_timezone_set('America/Lima');
                                $fecha=date('Y-m-d');
                                $hora=date('H:i:s');
                                $fechaActual = $fecha.' '.$hora;
                                $item1="ultimo_login";
                                $valor1=$fechaActual;
                                $item2="id_usuario";
                                $valor2=$respuesta["id_usuario"];
                                $ultimoLogin= ModeloUsuarios::mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2);

                                if($ultimoLogin=="ok"){
                                    echo '
                                    <script>
                            
                                        window.location="inicio";
                                    </script>;';

                                }

                            }else{
                                echo '<br><div class="alert alert-danger">El usuario aun no esta activo</div>';
                            }
                    

                            

                    }else{
                        echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
                    }

                }
                else{
                    echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
                }
                
            }
            
        }
        
    }


    /************************************
         Mostrar Usuarios
     ************************************/
    static public function ctrMostrarUsuarios($item,$valor){
        $tabla="usuario";
        $respuesta=ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);
        return $respuesta;


    }

    /************************************
         CREAR REGISTRO USUARIO
     ************************************/

     static public function ctrCrearUsuario(){
        
        if(isset($_POST["nuevoUsuario"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
               preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
               preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){
              
                /************************************
                        VALIDAR IMAGEN
                ************************************/
                $ruta="";
                //Analiza si vienen archivos files
                $vimagen = $_FILES["nuevaFoto"];
                //Validando si nose rellena el campo de foto..para asignar la imagen por defecto
                if($_FILES["nuevaFoto"]["name"]!=null){
                    //Esta funcion lo toma los valores de ancho y alto de la imagen y las almacena en las variables
                    //dichas valores estan almacenados en el indice 0 y 1 del array que da la imagen
                    list($ancho,$alto)=getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
                    $nuevoAncho=500;
                    $nuevoAlto=500;

                    /******************************************************************
                        CREAMOS DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                    ********************************************************************/

                    $directorio="vistas/img/usuarios/".$_POST["nuevoUsuario"];
                    //En platzi en los comentarios de imagenes dan la solucion para permisos
                    //Crea la carpeta
                    mkdir($directorio,0755, true);

                    /************************************************************************
                    De acuerdo al tipo de imagen aplicamos las funciones por defecto de PHP
                    **************************************************************************/

                    if($_FILES["nuevaFoto"]["type"]=="image/jpeg"){
                        /********************************************************
                                        Guardando imagen en el directorio
                        *******************************************************/
                        $aleatorio=mt_rand(100,999);
                        //Definimos la ruta de la imagen
                        $ruta="vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";
                        //Crear una imagen a partir de la imgen temporal que se crea en el file
                        $origen=imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                        //
                        $destino=imagecreatetruecolor($nuevoAncho,$nuevoAlto);
                        imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAlto,$ancho,$alto);
                        imagejpeg($destino,$ruta);


                    }
                    if($_FILES["nuevaFoto"]["type"]=="image/png"){
                        /********************************************************
                                        Guardando imagen en el directorio
                        *******************************************************/
                        $aleatorio=mt_rand(100,999);
                        //Definimos la ruta de la imagen
                        $ruta="vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";
                        //Crear una imagen a partir de la imgen temporal que se crea en el file
                        $origen=imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                        //
                        $destino=imagecreatetruecolor($nuevoAncho,$nuevoAlto);
                        imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAlto,$ancho,$alto);
                        imagepng($destino,$ruta);


                    }


                }

                 $tabla="usuario";
                //Envuelve la contraseña en un monton de caracteres y numeros haciendo dificil el desiframiento
                 //$encriptar=crypt($_POST["nuevoPassword"],'$2a$07$usesomesillystringforsalt$');
                 $datos=array("nombre"=>$_POST["nuevoNombre"],
                            "apellido"=>$_POST["nuevoApellido"],
                             "usuario"=>$_POST["nuevoUsuario"],
                             "correo"=> $_POST["nuevoCorreo"],
                             "password"=>$_POST["nuevoPassword"],
                             "perfil"=>$_POST["nuevoPerfil"],
                            "foto"=>$ruta);
                 $respuesta=ModeloUsuarios::mdlIngresarUsuario($tabla,$datos);
                 if($respuesta=="ok"){
                     echo '
                     <script>
                         swal({

                             type: "success",
                             title: "¡El usuario usuario ha sido guardado correctamente!",
                             showConfirmButton: true,
                             confirmButtonText: "Cerrar"

                         }).then(function(result){

                             if(result.value){
                            
                                 window.location = "usuarios";

                             }

                         });
                     </script>
                    
                     ';
                 }
            }
            else{


                echo '<script>

                    swal({

                        type: "error",
                        title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"

                    }).then(function(result){

                        if(result.value){
                        
                            window.location = "usuarios";

                        }

                    });
            

                </script>';
            }

        }
    }


    /************************************
         Editar Usuario
     ************************************/

     static public function ctrEditarUsuario(){

		if(isset($_POST["editarUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "usuario";

				if($_POST["editarPassword"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

						
                        $encriptar=$_POST["editarPassword"];

					}else{

						echo'<script>

								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
										if (result.value) {

										window.location = "usuarios";

										}
									})

						  	</script>';

					}

				}else{

					$encriptar= $_POST["passwordActual"];

				}

				$datos = array("nombre" => $_POST["editarNombre"],
                                "apellido" => $_POST["editarApellido"],
                                "correo" => $_POST["editarCorreo"],
							   "usuario" => $_POST["editarUsuario"],
							   "password" => $encriptar,
							   "perfil" => $_POST["editarPerfil"],
							   "foto" => $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "usuarios";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "usuarios";

							}
						})

			  	</script>';

			}

		}

	}
    /************************************
         Borrar Usuario
     ************************************/


     public function ctrBorrarUsuario(){

		if(isset($_GET["idUsuario"])){

			$tabla ="usuario";
			$datos = $_GET["idUsuario"];
            
			if($_GET["fotoUsuario"] != ""){

				unlink($_GET["fotoUsuario"]);
				rmdir('vistas/img/usuarios/'.$_GET["usuario"]);

			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "usuarios";

								}
							})

				</script>';

			}		

		}

	}

    

}