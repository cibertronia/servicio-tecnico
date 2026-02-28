<?php
session_start();
// include 'init.php';
include 'includes/conexion.php';
include 'includes/date.php';
include 'includes/funciones.php';
include 'vendor/autoload.php';
include 'init.php';
include 'includes/historial_repuestos/historial_stock_productos.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$mailInfo = "info@yapame.support";
$pswdMail = "ES72900968";
$mail = new PHPMailer(true);
$Host = "yuliimport.com";
$Soporte = "Soporte";
$url = "https://yapame.support";
$terminosCondiciones = "https://yapame.com.bo/terminos-y-condiciones/";
$linkSoporte = "https://yapame.com.bo/soporte/";
$Acciones = filter_var($_POST['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
switch ($Acciones) {
    case 'Login':
        $userMail = $_POST['usuario'];
        $password = $_POST['pswd'];
        $Q_Usuario = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE correo='$userMail' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
        $ResultQuery = mysqli_num_rows($Q_Usuario);
        if ($ResultQuery > 0) {
            $dataUser = mysqli_fetch_assoc($Q_Usuario);

            // restriccion de acceso al sistema en horario y dias laboral para usuario normal o tecnico
            if ($dataUser['idRango'] == 1 || $dataUser['idRango'] == 4) {
                $horaInicio = "08:30:00";
                $horaFinal = "18:30:00";

                // Dias de la semana laboral (0=Domingo, 6=Sábado)
				$diasLaborales = array(1, 2, 3, 4, 5, 6); // Lunes a Sabado

                $horaActual = date("H:i:s");
                $diaActual  = date("w");
                if ($horaActual < $horaInicio || $horaActual > $horaFinal || !in_array($diaActual, $diasLaborales)) { ?>
                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'error',
                            title: 'Fuera de Horario Laboral',
                            html: 'El acceso al sistema solo está permitido de <strong>08:30 AM</strong> a <strong>06:30 PM</strong>.',
                            showConfirmButton: false,
                            timer: 7500,
                            timerProgressBar: true,
                        });
                    </script>
                    <?php 
                    exit();
                }

            }

            if (password_verify($password, $dataUser['contrasena'])) {
                if ($dataUser['idRango'] == 1) {
                    if ($dataUser['estado'] == 0) {
                        alert_cuentaNoVerificada();
                    } elseif ($dataUser['estado'] == 2) {
                        alert_cuentaCancelada($dataUser['motivo']);
                        //enviar alerta al administrador
                        /*******************************************************
                         * /////////////////////////////////////////////////////
                         * /////////////////////////////////////////////////////
                         * /////////////////////////////////////////////////////
                         * /////////////////////////////////////////////////////
                         * ****************************************************/
                    } else {
                        $time = time();
                        $plus = 1850;
                        $tiempo = $time + $plus;
                        $idUser = $_SESSION['idUser'] = $dataUser['idUser'];
                        $idTienda = $_SESSION['idTienda'] = $dataUser['idTienda'];
                        $session = $_SESSION['time'] = $tiempo;
                        $_SESSION['idRango'] = $dataUser['idRango'];
                        mysqli_query($MySQLi, "UPDATE usuarios SET session='$session', onLine=1 WHERE idUser='$idUser' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        echo '
							<script type="text/javascript">
								$(".auth").fadeOut("slow", function() {
									location.reload()
								});
							</script>';
                    }
                } else {
                    $time = time();
                    $plus = 1850;
                    $tiempo = $time + $plus;
                    $idUser = $_SESSION['idUser'] = $dataUser['idUser'];
                    $idTienda = $_SESSION['idTienda'] = $dataUser['idTienda'];
                    $session = $_SESSION['time'] = $tiempo;
                    $_SESSION['idRango'] = $dataUser['idRango'];
                    mysqli_query($MySQLi, "UPDATE usuarios SET session='$session', onLine=1 WHERE idUser='$idUser' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                    echo '
							<script type="text/javascript">
								$(".auth").fadeOut("slow", function() {
									location.reload()
								});
							</script>';
                }
            } else {
                alert_contrasenaNoValida();
            }
        } else {
            alert_usuarioNoExiste();
        }
        break;
        // REGISTRO USUARIOS
    case 'RegistrarUsuario':
        if (isset($_SESSION['idUser'])) {
            if ($_SESSION['idRango'] == 1) {
                mysqli_close($MySQLi);
                alert_sinAutorizacion();
            } else {
                $idUser = $_SESSION['idUser'];
                $nombre = $_POST['nombre'];
                $idSexo = $_POST['sexo'];
                $cargo = $_POST['cargo'];
                $correo = $_POST['correo'];
                $telefono = $_POST['telefono'];
                $idTelegram = $_POST['idTelegram'];
                $idSucursal = $_POST['idSucursal'];
                $idRango = $_POST['idRango'];
                $zonaHoraria = $_POST['zonaHoraria'];
                $userPswd = password();
                $pswdHash = password_hash($userPswd, PASSWORD_DEFAULT);
                //Verificamos si el correo ya está registrado
                $Q_userMail = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE correo='$correo' ");
                $resMail = mysqli_num_rows($Q_userMail);
                if ($resMail > 0) { ?>
                    <script type="text/javascript">
                        $(".correoExiste").removeClass('d-none');
                        setTimeout(function() {
                            $(".correoExiste").addClass('d-none');
                            $("#correoUsuario").focus();
                        }, 1500);
                    </script><?php
                            } else {
                                //LLAMAMOS LA PLANTILLA Y SUSTITUIMOS LOS DATOS
                                // $Q_Plantillas    =  mysqli_query($MySQLi,"SELECT * FROM plantillasHTML WHERE nombre='Cuenta usuario Panel' ");
                                // $dataPlantilla= mysqli_fetch_assoc($Q_Plantillas);
                                // $html                 = utf8_decode($dataPlantilla['html']);
                                // $html                 = str_replace('{welcomeUsuario}', $idSexo==1?'Bienvenido':'Bienvenida', $html);
                                // $html                 = str_replace('{nombreUsuario}', $nombre, $html);
                                // $html                 = str_replace('{correoUsuario}', $correo, $html);
                                // $html                 = str_replace('{pswdUsuario}', $userPswd, $html);
                                // $html                 = str_replace('{fechaEnvio}', $fecha, $html);
                                // $html                 = str_replace('{horaEnvio}', $hora, $html);
                                // $html                 = str_replace('{anioActual}', $Year, $html);
                                // $html                 = str_replace('{hostSistema}', $url, $html);
                                // $html                 = str_replace('{linkTerminos}', $terminosCondiciones, $html);
                                // $html                 = str_replace('{linkSoporte}', $linkSoporte, $html);
                                if ($idSucursal == '1') {
                                    $ciudadUsuario = 'Cochabamba';
                                }
                                if ($idSucursal == '2') {
                                    $ciudadUsuario = 'La Paz';
                                }
                                if ($idSucursal == '3') {
                                    $ciudadUsuario = 'Santa Cruz';
                                }
                                if ($idSucursal == '4') {
                                    $ciudadUsuario = 'Tarija';
                                } else {
                                    $ciudadUsuario = 'otro';
                                }

                                if ($idRango == '1') {
                                    $tipo = 'U';
                                } else {
                                    $tipo = 'A';
                                }

                                $insertInf = mysqli_query($MySQLi, "INSERT INTO usuarios VALUES (null,'$idSexo', '$idRango', '$idSucursal', '$cargo', '$nombre', '$correo', '$pswdHash', '$telefono', '$idTelegram','',0,0, '$zonaHoraria', null,1,'$ciudadUsuario','$tipo')") or die("<br>" . mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

                                $html = "<style>.contenedor {width: 75%;}.logo {text-align: center;}p{margin-left: 10%;font-size: 16px}</style><meta charset='UTF-8'><body><div class='contenedor'><div class=''><img src='https://yapame.com.bo/wp-content/uploads/2019/06/logo-350.png' width='20%' alt='Logo'>";
                                if ($sexo == 'masculino') {
                                    $html .= "<h3>Bienvenido: " . $nombre . "</h3>";
                                } else {
                                    $html .= "<h3>Bienvenida:
							 " . $nombre . "</h3>";
                                }
                                $html .= "</div><p>Tu nueva cuenta ha sido creada exitosamente<br> Los datos de acceso son los siguientes:<br><br> Usuario: <strong>
						" . $correo . "</strong><br>Contrase&ntilde;a: <strong>
						" . $userPswd . "</strong><br><br> Puedes accesar desde aqu&iacute;:<br> <a target='_blank' href='https://serviciotecnico.yuliimport.com'>Sistema Servicio Tecnico</a><br><br> Mensaje enviado desde el Sistema Automatizado el d&iacute;a:<br>
						" . $Fecha . "<br>" . $hora . "</p></div></body>";
                                // try {
                                // $mail->SMTPDebug     = 0;
                                // $mail->isSMTP();
                                // $mail->Host       = APP_EMAIL_HOST;
                                // $mail->SMTPAuth   = true;
                                // $mail->Username   = APP_EMAIL_USER;
                                // $mail->Password   = APP_EMAIL_PASSWORD;
                                // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                // $mail->Port       = 465;

                                // //Recipients
                                // $mail->setFrom(APP_EMAIL_USER, $Soporte);
                                // $mail->addAddress($correo);
                                // $mail->addBCC(APP_EMAIL_USER);
                                // // Content
                                // $mail->Charset = 'utf-8';
                                // $mail->isHTML(true);
                                // $mail->Subject = 'Tu cuenta ha sido creada';
                                // $mail->Body    = $html;
                                // $mail->send();
                                // }
                                // catch (Exception $e) {
                                //     //mysqli_close($MySQLi); errorMail();
                                //     alert_errorAlRegistraralUsuario();
                                // }

                                try {
                                    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
                                    $mail->isSMTP();
                                    $mail->Host = 'yuliimport.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'support@yuliimport.com';
                                    $mail->Password = '0fT2+#Y=BOW]';
                                    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                    $mail->Port = 465;
                                    $mail->setFrom('support@yuliimport.com', 'Soporte');
                                    $mail->addAddress('support@yuliimport.com', 'Soporte');
                                    $mail->addAddress($correo);
                                    //$mail->addReplyTo('support@yuliimport.com', 'Soporte');
                                    //$mail->addBCC('administracion@yuliimport.com');
                                    //$mail->addCC('abrahan.zambrana@gmail.com');
                                    //Content
                                    $mail->Charset = 'utf-8';
                                    $mail->isHTML(true);
                                    $mail->Subject = "Tu cuenta ha sido creada";
                                    $mail->Body = $html;
                                    $envio = $mail->send();
                                    //mysqli_close($MySQLi);usuarioRegistrado();
                                    // if ($envio) {
                                    //     //alert_usuarioRegistradoOK();
                                    //     header("Location: ?root=usuarios");
                                    // }

                                    mysqli_close($MySQLi);
                                } catch (Exception $e) {
                                    alert_errorAlRegistraralUsuario();
                                    mysqli_close($MySQLi);
                                    //exit();
                                }

                                alert_usuarioRegistradoOK();

                                //mysqli_close($MySQLi);
                            }
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'nuevoUsuario':
                    $nombre = $_POST['nombre'];
                    $idSexo = $_POST['sexo'];
                    $telefono = $_POST['telefono'];
                    $idTelegram = $_POST['idTelegram'];
                    $correo = $_POST['correo'];
                    $idSucursal = $_POST['sucursal'];
                    $userPswd = password();
                    $pswdHash = password_hash($userPswd, PASSWORD_DEFAULT);
                    //Verificamos si el correo ya está registrado
                    $Q_userMail = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE correo='$correo' ");
                    $resMail = mysqli_num_rows($Q_userMail);
                    if ($resMail > 0) { ?>
            <script type="text/javascript">
                $(".correoExiste").removeClass('d-none');
                setTimeout(function() {
                    $(".correoExiste").addClass('d-none');
                    $("#correoUsuario").focus();
                }, 1500);
            </script><?php
                    } else {
                        if ($idSexo == 1) {
                            $cargo = 'Vendedor';
                        } else {
                            $cargo = 'Vendedora';
                        }

                        // $Q_Plantillas    =  mysqli_query($MySQLi,"SELECT * FROM plantillasHTML WHERE nombre='Nueva cuenta creada' ");
                        // $dataPlantilla= mysqli_fetch_assoc($Q_Plantillas);
                        // $html                 = utf8_decode($dataPlantilla['html']);
                        // $html                 = str_replace('{welcomeUsuario}', $idSexo==1?'Bienvenido':'Bienvenida', $html);
                        // $html                 = str_replace('{nombreUsuario}', $nombre, $html);
                        // $html                 = str_replace('{correoUsuario}', $correo, $html);
                        // $html                 = str_replace('{pswdUsuario}', $userPswd, $html);
                        // $html                 = str_replace('{fechaEnvio}', $fecha, $html);
                        // $html                 = str_replace('{horaEnvio}', $hora, $html);
                        // $html                 = str_replace('{anioActual}', $Year, $html);
                        // $html                 = str_replace('{hostSistema}', $url, $html);
                        // $html                 = str_replace('{linkTerminos}', $terminosCondiciones, $html);
                        // $html                 = str_replace('{linkSoporte}', $linkSoporte, $html);
                        // try {
                        // $mail->SMTPDebug     = 0;
                        // $mail->isSMTP();
                        // $mail->Host       = APP_EMAIL_HOST;
                        // $mail->SMTPAuth   = true;
                        // $mail->Username   = APP_EMAIL_USER;
                        // $mail->Password   = APP_EMAIL_PASSWORD;
                        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        // $mail->Port       = 465;

                        // //Recipients
                        // $mail->setFrom(APP_EMAIL_USER, $Soporte);
                        // $mail->addAddress($correo);
                        // $mail->addBCC(APP_EMAIL_USER);
                        // // Content
                        // $mail->Charset = 'utf-8';
                        // $mail->isHTML(true);
                        // $mail->Subject = 'Tu cuenta ha sido creada';
                        // $mail->Body    = utf8_decode($html);
                        // $mail->send();
                        // }
                        // catch (Exception $e) {
                        //     //mysqli_close($MySQLi); errorMail();
                        //     alert_errorAlRegistraralUsuario();
                        // }

                        if ($idSucursal == '1') {
                            $ciudadUsuario = 'Cochabamba';
                        } else {
                            $ciudadUsuario = 'Santa Cruz';
                        }
                        if ($idRango == '1') {
                            $tipo = 'U';
                        } else {
                            $tipo = 'A';
                        }
                        $insertInf = mysqli_query($MySQLi, "INSERT INTO usuarios (idSexo, idRango, idTienda, cargo, Nombre, correo, contrasena, telefono, idTelegram) VALUES ('$idSexo', 1, $idSucursal, '$cargo', '$nombre', '$correo', '$pswdHash', '$telefono', '$idTelegram','','')") or die("<br>" . mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        alert_usuarioRegistradoFromPagina();
                        mysqli_close($MySQLi);
                    }
                    break;
                case 'actualizarUsuario':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            mysqli_close($MySQLi);
                            alert_sinAutorizacion();
                        } else {
                            $idUser = $_POST['idUser'];
                            $nombre = $_POST['nombre'];
                            $idSexo = $_POST['sexo'];
                            $cargo = $_POST['cargo'];
                            $correo = $_POST['correo'];
                            $telefono = $_POST['telefono'];
                            $idTeleG = $_POST['idTelegram'];
                            $idTienda = $_POST['idSucursal'];
                            $idRango = $_POST['idRango'];
                            /*    COMPORAMOS LOS DATOS Y VERIFICAMOS SI EXISTEN CAMBIOS    */
                            $Q_usuario = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUser' ");
                            $dataUser = mysqli_fetch_assoc($Q_usuario);
                            if ($nombre == $dataUser['Nombre'] and $idSexo == $dataUser['idSexo'] and $cargo == $dataUser['cargo'] and $correo == $dataUser['correo'] and $telefono == $dataUser['telefono'] and $idTeleG == $dataUser['idTelegram'] and $idTienda == $dataUser['idTienda'] and $idRango == $dataUser['idRango']) {
                                alert_noCambiosUsuarioEdit();
                            } else {
                                mysqli_query($MySQLi, "UPDATE usuarios SET Nombre='$nombre', idSexo='$idSexo', cargo='$cargo', correo='$correo', telefono='$telefono', idTelegram='$idTeleG', idTienda='$idTienda', idRango='$idRango' WHERE idUser='$idUser' ");
                                mysqli_close($MySQLi);
                                alert_usuarioEditAcualizado();
                            }
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'HabilitarCuentaUsuario':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            $idUser = $_POST['idUser'];
                            mysqli_query($MySQLi, "UPDATE usuarios SET estado=1 WHERE idUser='$idUser' ");
                            alert_cuentaUsuarioActivada();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'cancelarCuentaUsuario':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            $idUser = $_POST['idUser'];
                            $razon = $_POST['razon'];
                            mysqli_query($MySQLi, "UPDATE usuarios SET estado=3, motivo='$razon' WHERE idUser='$idUser' ");
                            alert_cuentaUsuarioCancelada();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //PAGINA DE REGISTRO
                case 'HabilitarPaginaRegistro':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET registrar=1 ");
                            alert_paginaRegistrarHabilitada();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'DeshabilitarPaginaRegistro':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET registrar=0 ");
                            alert_paginaRegistrarDeshabilitada();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //DOBLE MONEDA (PRECIO USD)
                case 'DeshabilitarPrecioUSD':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET precioDolar=0 ");
                            alert_precioUSDDeshabilitado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'HabilitarPrecioUSD':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET precioDolar=1 ");
                            alert_precioUSDHabilitado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'cambiarMonedaPricipal':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            $idMoneda = $_POST['monedaPrincipal'];
                            $Q_Monedas = mysqli_query($MySQLi, "SELECT simbolo FROM monedas WHERE idMoneda='$idMoneda' ");
                            $dataMoneda = mysqli_fetch_assoc($Q_Monedas);
                            $simbolo = $dataMoneda['simbolo'];
                            mysqli_query($MySQLi, "UPDATE configuraciones SET monedaP='$idMoneda',simbolo='$simbolo' "); ?>
                <script type="text/javascript">
                    var simbolo = "<?php echo $simbolo ?>";
                    var idMoneda = "<?php echo $idMoneda ?>";
                    $(".simboloMoneda").html(simbolo);
                    $("#monedaPrincipal").val(idMoneda);
                    setTimeout(function() {
                        alert_monedaPricipal();
                    }, 500);

                    function alert_monedaPricipal() {
                        $("#openModalEditImagen").modal('hide');
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Moneda cambiada.',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                        /*setTimeout(function() {
                          location.reload()
                        },2000);*/
                    }
                </script><?php
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //PROVEEDORES
                case 'DeshabilitarProveedores':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET proveedores=0 ");
                            alert_proveedoresDeshabilitado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'HabilitarProveedores':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET proveedores=1 ");
                            alert_proveedoresHabilitado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //CATEGORIAS
                case 'DeshabilitarCategorias':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET categorias=0 ");
                            alert_categoriasDeshabilitado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'HabilitarCategorias':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "UPDATE configuraciones SET categorias=1 ");
                            alert_categoriasHabilitado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //STOCK
                case 'DeshabilitarStock':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            mysqli_query($MySQLi, "DELETE FROM inventario");
                            mysqli_query($MySQLi, "UPDATE configuraciones SET stock=0 ");
                            alert_stockDeshabilitado();
                            mysqli_query($MySQLi, "ALTER TABLE inventario MODIFY `idInventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; ");
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'HabilitarStock':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            alert_sinAutorizacion();
                        } else {
                            $Q_Productos = mysqli_query($MySQLi, "SELECT idProducto FROM productos WHERE estado=1 ");
                            $resultProds = mysqli_num_rows($Q_Productos);
                            $Q_Sucursales = mysqli_query($MySQLi, "SELECT idTienda FROM sucursales WHERE estado=1 ");
                            $resultSucurs = mysqli_num_rows($Q_Sucursales);
                            for ($i = 0; $i < $resultProds; $i++) {
                                $Q_Producto = mysqli_query($MySQLi, "SELECT idProducto FROM productos WHERE estado=1 LIMIT $i,1 ");
                                $dataProduc = mysqli_fetch_assoc($Q_Producto);
                                $idProducto = $dataProduc['idProducto'];
                                for ($j = 0; $j < $resultSucurs; $j++) {
                                    $Q_Sucursal = mysqli_query($MySQLi, "SELECT idTienda FROM sucursales WHERE estado=1 LIMIT $j,1");
                                    $dataSucur = mysqli_fetch_assoc($Q_Sucursal);
                                    $idTienda = $dataSucur['idTienda'];
                                    mysqli_query($MySQLi, "INSERT INTO inventario VALUES(null,'$idProducto','$idTienda',0)") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                }
                            }
                            mysqli_query($MySQLi, "UPDATE configuraciones SET stock=1 ");
                            alert_stockHabilitado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //CLIENTES
                case 'RegistrarNuevoCliente':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_SESSION['idUser'];
                        $idTienda = $_POST['idTienda'];
                        $nombre = $_POST['nombreCliente'];
                        $idCiudad = $_POST['ciudadCliente'];
                        $correo = $_POST['correoCliente'];
                        $empresa = $_POST['empresaCliente'];
                        $telEmpresa = $_POST['telefonoEmpresa'];
                        $extEmpresa = $_POST['extEmpresa'];
                        $telCliente = $_POST['telefonoCliente'];
                        $idTelegram = $_POST['idTelegram'];
                        $direccion = $_POST['direccion'];
                        $comentarios = $_POST['comentarios'];
                        mysqli_query($MySQLi, "INSERT INTO clientes (idUser, idTienda, idCiudad, idTelegram, nombre, correo, empresa, telEmpresa, ext, celular, direccion, comentarios) VALUES ('$idUser', '$idTienda', '$idCiudad', '$idTelegram', '$nombre', '$correo', '$empresa', '$telEmpresa', '$extEmpresa', '$telCliente', '$direccion', '$comentarios') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        alert_nuevoClienteRegistrado();
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'ActualizarmiCliente':
                    if (isset($_SESSION['idUser'])) {
                        $idCliente = $_POST['idCliente'];
                        $nombre = $_POST['nombreCliente'];
                        $idCiudad = $_POST['ciudadCliente'];
                        $correo = $_POST['correoCliente'];
                        $empresa = $_POST['empresaCliente'];
                        $telEmpresa = $_POST['telefonoEmpresa'];
                        $extEmpresa = $_POST['extEmpresa'];
                        $telCliente = $_POST['telefonoCliente'];
                        $idTelegram = $_POST['idTelegram'];
                        $direccion = $_POST['direccion'];
                        $comentarios = $_POST['comentarios'];
                        /*    VERIFICAMOS SI LOS DATOS HAN CAMBIADO     */
                        $Q_miCliente = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE idCliente='$idCliente' ");
                        $dataCliente = mysqli_fetch_assoc($Q_miCliente);
                        if ($dataCliente['idCiudad'] == $idCiudad & $dataCliente['idTelegram'] == $idTelegram & $dataCliente['nombre'] == $nombre & $dataCliente['correo'] == $correo & $dataCliente['empresa'] == $empresa & $dataCliente['telEmpresa'] == $telEmpresa & $dataCliente['ext'] == $extEmpresa & $dataCliente['celular'] == $telCliente & $dataCliente['direccion'] == $direccion & $dataCliente['comentarios'] == $comentarios) {
                            mysqli_close($MySQLi);
                            alert_noCambiosEditMiCliente();
                        } else {
                            mysqli_query($MySQLi, "UPDATE clientes SET idCiudad='$idCiudad', idTelegram='$idTelegram', nombre='$nombre', correo='$correo', empresa='$empresa', telEmpresa='$telEmpresa', ext='$extEmpresa', celular='$telCliente', direccion='$direccion', comentarios='$comentarios'  WHERE idCliente='$idCliente' ");
                            mysqli_close($MySQLi);
                            alert_clienteEditAcualizado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'ActualizarCliente':
                    if (isset($_SESSION['idUser'])) {
                        $idCliente = $_POST['idCliente'];
                        $nombre = $_POST['nombreCliente'];
                        $idCiudad = $_POST['ciudadCliente'];
                        $correo = $_POST['correoCliente'];
                        $empresa = $_POST['empresaCliente'];
                        $telEmpresa = $_POST['telefonoEmpresa'];
                        $extEmpresa = $_POST['extEmpresa'];
                        $telCliente = $_POST['telefonoCliente'];
                        $idTelegram = $_POST['idTelegram'];
                        $direccion = $_POST['direccion'];
                        $comentarios = $_POST['comentarios'];
                        /*    VERIFICAMOS SI LOS DATOS HAN CAMBIADO     */
                        $Q_miCliente = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE idCliente='$idCliente' ");
                        $dataCliente = mysqli_fetch_assoc($Q_miCliente);
                        if ($dataCliente['idCiudad'] == $idCiudad & $dataCliente['idTelegram'] == $idTelegram & $dataCliente['nombre'] == $nombre & $dataCliente['correo'] == $correo & $dataCliente['empresa'] == $empresa & $dataCliente['telEmpresa'] == $telEmpresa & $dataCliente['ext'] == $extEmpresa & $dataCliente['celular'] == $telCliente & $dataCliente['direccion'] == $direccion & $dataCliente['comentarios'] == $comentarios) {
                            mysqli_close($MySQLi);
                            alert_noCambiosEditMiCliente();
                        } else {
                            mysqli_query($MySQLi, "UPDATE clientes SET idCiudad='$idCiudad', idTelegram='$idTelegram', nombre='$nombre', correo='$correo', empresa='$empresa', telEmpresa='$telEmpresa', ext='$extEmpresa', celular='$telCliente', direccion='$direccion', comentarios='$comentarios'  WHERE idCliente='$idCliente' ");
                            mysqli_close($MySQLi);
                            alert_clienteEditAcualizado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //SUCURSALES
                case 'RegistrarSucursal':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] < 3) {
                            alert_sinAutorizacion();
                        } else {
                            $nombre = $_POST['nombre'];
                            $codigo = strtoupper($_POST['codigo']);
                            $serviStock = $_POST['serviStock'];
                            $insertSucur = mysqli_query($MySQLi, "INSERT INTO sucursales (sucursal, codeTienda) VALUES ('$nombre', '$codigo')") or die("<br>" . mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                            if ($serviStock == 1) {
                                //Buscamos el ID de la sucursal recien registrada
                                $Q_Sucursal = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE sucursal='$nombre' AND codeTienda='$codigo' ");
                                $dataSucursa = mysqli_fetch_assoc($Q_Sucursal);
                                $idTienda = $dataSucursa['idTienda'];
                                //Buscamos la cantidad de productos registrados hasta el momento
                                $Q_Productos = mysqli_query($MySQLi, "SELECT idProducto FROM productos WHERE estado=1");
                                $resultProds = mysqli_num_rows($Q_Productos);
                                for ($i = 0; $i < $resultProds; $i++) {
                                    $Q_Producto = mysqli_query($MySQLi, "SELECT idProducto FROM productos WHERE estado=1 LIMIT $i,1 ");
                                    $dataProduc = mysqli_fetch_assoc($Q_Producto);
                                    $idProducto = $dataProduc['idProducto'];
                                    //Insertamos los datos de la tienda en la tabla inventarios por cada producto disponible
                                    mysqli_query($MySQLi, "INSERT INTO inventario VALUES(null, '$idProducto', '$idTienda', 0) ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                }
                            }
                            mysqli_close($MySQLi);
                            alert_nuevaSucursalCreada();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'actualizarSucursal':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] < 3) {
                            alert_sinAutorizacion();
                        } else {
                            $idSucursal = $_POST['idSucursal'];
                            $nombre = $_POST['nombre'];
                            $codigo = $_POST['codigo'];
                            /*    VERIFICAMOS SI HAY CAMBIOS    */
                            $Q_Sucursal = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idSucursal' ");
                            $dataSucursa = mysqli_fetch_assoc($Q_Sucursal);
                            if ($dataSucursa['sucursal'] == $nombre & $dataSucursa['codeTienda'] == $codigo) {
                                alert_noCambiosSucursalEdit();
                            } else {
                                mysqli_query($MySQLi, "UPDATE sucursales SET sucursal='$nombre', codeTienda='$codigo' WHERE idTienda='$idSucursal' ");
                                mysqli_close($MySQLi);
                                alert_sucursalEditActualizada();
                            }
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'DeshabilitarSucursal':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] < 3) {
                            alert_sinAutorizacion();
                        } else {
                            $idSucursal = $_POST['idSucursal'];
                            mysqli_query($MySQLi, "UPDATE sucursales SET estado=0 WHERE idTienda='$idSucursal' ");
                            alert_sucursalDeshabilitada();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'HabilitarSucursal':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] < 3) {
                            alert_sinAutorizacion();
                        } else {
                            $idSucursal = $_POST['idSucursal'];
                            mysqli_query($MySQLi, "UPDATE sucursales SET estado=1 WHERE idTienda='$idSucursal' ");
                            alert_sucursalHabilitada();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'cambiaImagendePerfil':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_POST['idUser'];
                        $imgAnterior = $_POST['avatarAnterior'];
                        $idRangoDf = $_POST['idRango'];
                        $idSexoDf = $_POST['idSexo'];
                        $imagen = $_FILES['imagen']['name'];
                        $ruta = "assets/img/avatars/";
                        $rutas = $ruta . basename($_FILES['imagen']['name'], $ruta);
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutas)) {
                            mysqli_query($MySQLi, "UPDATE usuarios SET miAvatar='$imagen' WHERE idUser='$idUser' ");
                            $rutaAvatar = "assets/img/avatars/" . $imgAnterior;
                            if (file_exists($rutaAvatar)) {
                                unlink($rutaAvatar);
                            }
                        }
                        alert_imagenPerfilCargado();
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //PRODUCTOS
                case 'GuardarProducto':
                    if (isset($_SESSION['idUser'])) {
                        $servicioProveedor = $_POST['servicioProveedor'];
                        if ($servicioProveedor == 1) {
                            $idProveedor = $_POST['proveedor'];
                        } else {
                            $idProveedor = 0;
                        }
                        $servicioCategorias = $_POST['servicioCategorias'];
                        if ($servicioCategorias == 1) {
                            $idCategoria = $_POST['categorias'];
                        } else {
                            $idCategoria = 0;
                        }
                        $servicioStock = $_POST['servicioStock'];
                        if ($servicioStock == 1) {
                            $stockProducto = $_POST['stockProducto'];
                        } else {
                            $stockProducto = 0;
                        }
                        $nombreProducto = $_POST['nombreProducto'];
                        $marcaProducto = $_POST['marcaProducto'];
                        $modeloProducto = $_POST['modeloProducto'];
                        $industriaProducto = $_POST['industriaProducto'];
                        $precioProducto = $_POST['precioProducto'];
                        $caracteristicas = $_POST['caracteristicasProducto'];
                        $ruta = "Productos/";
                        $img = $_FILES['imagen'];
                        $ruta = $ruta . basename($_FILES['imagen']['name'], $ruta);
                        $nombreImagen = $_FILES['imagen']['name'];
                        $sizeImagen = $_FILES['imagen']['size'];
                        $numeroSucursales = $_POST['numeroSucursales'];
                        $mercaderia = $_POST['mercaderia'];
                        $observaciones = $_POST['observaciones'];

                        if (isset($_POST['codigoProducto'])) {
                            $codigoProducto = $_POST['codigoProducto'];
                        } else {
                            $codigoProducto = 0;
                        }
                        /*    VERIFICAMOS SI EL NOMBRE DE LA IMAGEN YA EXISTE     */
                        if (isset($_FILES['imagen']['name']) && ($_FILES['imagen']['name'] <> "") && ($sizeImagen > 10) && file_exists($ruta)) {
                            alert_nombreIMG_yaexiste();
                            exit();
                        } else {
                            mysqli_query(
                                $MySQLi,
                                "INSERT INTO productos
                 ( `idCategoria`, `idProveedor`,
                  `codigoProducto`, `nombre`,
                   `marca`, `modelo`,
                    `industria`, `precio`,
                     `imagen`, `descripcion`,
                      `fecha`, `estado`,
                       `observaciones`, `mercaderia`) 
                       VALUES('$idCategoria', '$idProveedor', 
                       '$codigoProducto', '$nombreProducto',
                        '$marcaProducto', '$modeloProducto',
                         '$industriaProducto', '$precioProducto',
                          '$nombreImagen', '$caracteristicas', 
                          '$fecha','1','$observaciones','$mercaderia') "
                            ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                            $Q_Producto = mysqli_query($MySQLi, "SELECT idProducto FROM productos WHERE nombre='$nombreProducto' AND imagen='$nombreImagen' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                            $dataProducto = mysqli_fetch_assoc($Q_Producto);
                            $idProducto = $dataProducto['idProducto'];
                            if ($servicioStock == 1) {
                                $stocks = count($stockProducto);
                                $idSucursal = $_POST['idTienda'];
                                for ($i = 0; $i < $stocks; $i++) {
                                    $idTienda = $idSucursal[$i];
                                    $cantidad = $stockProducto[$i];
                                    mysqli_query($MySQLi, "INSERT INTO inventario() VALUES (null, '$idProducto', '$idTienda', '$cantidad') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                }
                            }
                            if (($sizeImagen > 10) && move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
                                alert_productoCargado();
                            }
                            else
                                alert_productoCargado();
                            // if ($numeroSucursales==1) {
                            //     mysqli_query($MySQLi,"INSERT INTO productos() VALUES(null, '$idCategoria', '$idProveedor', '$codigoProducto', '$nombreProducto', '$marcaProducto', '$modeloProducto', '$industriaProducto', '$precioProducto', '$stockProducto', '$nombreImagen', '$caracteristicas',1) ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                            // }else{
                            //     mysqli_query($MySQLi,"INSERT INTO productos() VALUES(null, '$idCategoria', '$idProveedor', '$codigoProducto', '$nombreProducto', '$marcaProducto', '$modeloProducto', '$industriaProducto', '$precioProducto', 0, '$nombreImagen', '$caracteristicas',1) ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                            //         PARA INSERTAR STOCK, NECESITAMOS EL ID DEL PRODUCTO
                            //     $Q_Producto             = mysqli_query($MySQLi,"SELECT idProducto FROM productos WHERE nombre='$nombreProducto' AND imagen='$nombreImagen' ");
                            //     $dataProducto         = mysqli_fetch_assoc($Q_Producto);
                            //     $idProducto             = $dataProducto['idProducto'];
                            //     $stocks                     = count($stockProducto);
                            //     $idSucursal             = $_POST['idTienda'];
                            //     for ($i=0; $i < $stocks; $i++) {
                            //         $idTienda             = $idSucursal[$i];
                            //         $cantidad                = $stock[$i];
                            //         mysqli_query($MySQLi,"INSERT INTO inventario() VALUES (null, '$idProducto', '$idTienda', '$precioProducto', '$cantidad') ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                            //     }
                            // }
                            // alert_productoCargado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'actualzarImagenProducto':
                    if (isset($_SESSION['idUser'])) {
                        $idProducto = $_POST['idProducto'];
                        $nuevaImagen = $_FILES['imagen']['name'];
                        /*    VERIFICAR SI EL NOMBRE DE LA IMAGEN, YA EXISTE    */
                        /*    VERIFICAMOS SI LA IMAGEN ANTERIOR ESTA VINCULADA CON OTRO PRODUCTO    */
                        $Q_Producto = mysqli_query($MySQLi, "SELECT imagen FROM productos WHERE idProducto='$idProducto' ");
                        $dataImgProd = mysqli_fetch_assoc($Q_Producto);
                        $imgenVieja = $dataImgProd['imagen']; //Este es el nombre de la imagen vieja
                        $Q_Productos = mysqli_query($MySQLi, "SELECT * FROM productos WHERE imagen='$imgenVieja' ");
                        $resultImgs = mysqli_num_rows($Q_Productos);
                        if ($resultImgs == 1) { //La imagen vieja solo está vinculada a ella misma, por lo tanto, podemos bborrar la imagen vieja.
                            unlink('Productos/' . $imgenVieja);
                        }
                        $ruta = 'Productos/';
                        $img = $_FILES['imagen'];
                        $ruta = $ruta . basename($_FILES['imagen']['name'], $ruta);
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
                            mysqli_query($MySQLi, "UPDATE productos SET imagen='$nuevaImagen' WHERE idProducto='$idProducto' ");
                            alert_imagenProductoActualizado();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'acualizarDatosProducto':
                    if (isset($_SESSION['idUser'])) {
                        
                        $Q_U = mysqli_query($MySQLi, "SELECT tipo FROM usuarios WHERE idUser=" . $_SESSION['idUser'] );
                        $dataU = mysqli_fetch_assoc($Q_U);
                        $esAdmin = (isset($dataU['tipo']) && ($dataU['tipo'] == 'A')) ? true : false;
                        
                        if (isset($_POST['codigoProducto'])) {
                            $codigoProducto = $_POST['codigoProducto'];
                        } else {
                            $codigoProducto = '';
                        }
                        $idProducto = $_POST['idProducto'];
                        if (isset($_POST['proveedor'])) {
                            $idProveedor = $_POST['proveedor'];
                        } else {
                            $idProveedor = 0;
                        }
                        if (isset($_POST['categorias'])) {
                            $idCategoria = $_POST['categorias'];
                        } else {
                            $idCategoria = 0;
                        }
                        $nombreProducto = $_POST['nombreProducto'];
                        $mercaderiaProducto = $_POST['mercaderiaProducto'];
                        $marcaProducto = $_POST['marcaProducto'];
                        $modeloProducto = $_POST['modeloProducto'];
                        $obsProducto = $_POST['obsProducto'];
                        $industriaProducto = $_POST['industriaProducto'];
                        $precioProducto = $_POST['precioProducto'];
                        $caracteristicas = $_POST['caracteristicasProducto'];
                        $Q_Producto = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
                        $dataProducto = mysqli_fetch_assoc($Q_Producto);
                        if (
                            $dataProducto['idCategoria'] == $idCategoria &
                            $dataProducto['idProveedor'] == $idProveedor &
                            $dataProducto['nombre'] == $nombreProducto &
                            $dataProducto['mercaderia'] == $mercaderiaProducto &
                            $dataProducto['marca'] == $marcaProducto &
                            $dataProducto['observaciones'] == $obsProducto &
                            $dataProducto['modelo'] == $modeloProducto &
                            $dataProducto['industria'] == $industriaProducto &
                            $dataProducto['precio'] == $precioProducto &
                            $dataProducto['descripcion'] == $caracteristicas
                        ) {
                            alert_noCambiosEditProducto();
                        } else {
                            
                            if ($esAdmin)
                        mysqli_query($MySQLi, "UPDATE productos SET
						idCategoria 	= '$idCategoria',
						idProveedor 	= '$idProveedor',
						codigoProducto= '$codigoProducto',
						nombre 				= '$nombreProducto',
						mercaderia			= '$mercaderiaProducto',
						marca 				= '$marcaProducto',
						modelo 				= '$modeloProducto',
						observaciones				= '$obsProducto',
						industria 		= '$industriaProducto',
						precio 				= '$precioProducto',
						descripcion 	= '$caracteristicas' WHERE idProducto='$idProducto' ");                            
                            else
                            
                            mysqli_query($MySQLi, "UPDATE productos SET
						idCategoria 	= '$idCategoria',
						idProveedor 	= '$idProveedor',
						codigoProducto= '$codigoProducto',
						nombre 				= '$nombreProducto',
						mercaderia			= '$mercaderiaProducto',
						marca 				= '$marcaProducto',
						modelo 				= '$modeloProducto',
						observaciones				= '$obsProducto',
						industria 		= '$industriaProducto',
						precio 				= case when '$precioProducto'  < precio then precio else '$precioProducto' end,
						descripcion 	= '$caracteristicas' WHERE idProducto='$idProducto' ");
						
						    if (($precioProducto < $dataProducto['precio'] ) && (!$esAdmin))
						                                alert_productoActualizadoOK(false);
						    else
                                alert_productoActualizadoOK();
                        }
                        //alert_productoActualizadoOK(false);
                        // precio 				= case when '$precioProducto'  < precio then precio else '$precioProducto' end,
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                case 'ActualizarStockSucursal':
                    if (isset($_SESSION['idUser'])) {
                        
                        $Q_U = mysqli_query($MySQLi, "SELECT correo, tipo FROM usuarios WHERE idUser=" . $_SESSION['idUser'] );
                        $dataU = mysqli_fetch_assoc($Q_U);
                        $esAdmin = (isset($dataU['tipo']) && ($dataU['tipo'] == 'A')) ? true : false;
                        $correo =  $dataU['correo'];
                        
                        
                        $idInventario = $_POST['idInventario'];
                        $stock = $_POST['stock'];
                        $sucursal = $_POST['sucursal'];
                        $servicioStock = $_POST['serviStock'];
                        
                                $Q_Producto_stock = mysqli_query($MySQLi, "SELECT idproducto, stock FROM inventario WHERE idInventario='$idInventario'");
                                $dataProductoStock = mysqli_fetch_assoc($Q_Producto_stock);
                                $ProductoStock = $dataProductoStock['stock'];                                
                                $idproductoq = $dataProductoStock['idproducto'];                                
                                if (($stock < $ProductoStock) && (!$esAdmin))
                                    $stock = $ProductoStock;
                                    
                        mysqli_query($MySQLi, "UPDATE inventario SET stock='$stock' WHERE idInventario='$idInventario' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        //listaProductos($MySQLi, $servicioStock);
                        
                        
                        $sqll = "insert into logss values(now(),1,$idproductoq,'$correo cambio stock de $ProductoStock a $stock en $sucursal')";
                         mysqli_query($MySQLi, $sqll);
                        
                        $Q_U = mysqli_query($MySQLi, "SELECT sum(stock) total FROM `inventario` where idProducto =( SELECT idProducto FROM `inventario` where idInventario = $idInventario)");
                        $dataU = mysqli_fetch_assoc($Q_U);
                        $total = $dataU['total'];
                         echo ($total);
                         
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    //    TELEGRAM
                case 'enviarSMSTeleGram':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_POST['idUser'];
                        $idTelegram = $_POST['idTelegram'];
                        $Mensaje = $_POST['mensaje'];
                        $bottoken = "831308895:AAE5FHf7G3IhNAiJ260yz-zr1IThvq5kv-0";
                        $website = "https://api.telegram.org/bot" . $bottoken;
                        $update = file_get_contents('php://input');
                        $update = json_decode($update, true);
                        $info = "\n\nMensaje enviado desde la plataforma de Yapame, el día: " . $Fecha . ", a la(s): " . $hora;
                        $url = $website . "/sendMessage?chat_id=" . $idTelegram . "&parse_mode=HTML&text=" . urlencode($Mensaje . $info);
                        file_get_contents($url);
                        alert_smsTeleGramEnviado();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                    //COTIZACIONES
                case 'GuardarProductoTemporal':
                    if (isset($_SESSION['idUser'])) {
                        $idProducto = $_POST['idProducto'];
                        $cantidad = $_POST['cantidad'];
                        $precioVenta = $_POST['precioVenta'];
                        $precioEspecial = $_POST['precioEspecial'];
                        $claveTemporal = $_POST['claveTemporal'];
                        mysqli_query($MySQLi, "INSERT INTO claveTemporal() VALUES (null,'$claveTemporal', '$idProducto', '$cantidad', '$precioVenta', '$precioEspecial') ");
                        //consultamos los registros temporales generados
                        listaProductosTemporales($MySQLi, $claveTemporal);
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'ActualizarDatosCotizacion':
                    if (isset($_SESSION['idUser'])) {
                        $claveTemporal = $_POST['claveTemporal'];
                        $formaPago = $_POST['formaPago'];
                        $tiempoEntrega = $_POST['tiempoEntrega'];
                        $validezCotizacion = $_POST['validezCotizacion'];
                        $detallesGarantia = $_POST['detallesGarantia'];
                        $observaciones = $_POST['observaciones'];
                        mysqli_query($MySQLi, "UPDATE cotizaciones SET formaPago='$formaPago', fechaOferta='$validezCotizacion', tiempoEntrega='$tiempoEntrega', garantiaDetalles='$detallesGarantia', comentarios='$observaciones' WHERE clave='$claveTemporal' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        mysqli_close($MySQLi);
                        alert_cotizacionActualizada();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'ActualizarProductoTemporal':
                    if (isset($_SESSION['idUser'])) {
                        $claveCotizacion = $_POST['claveTemporal'];
                        $idClave = $_POST['idClave'];
                        $cantidad = $_POST['cantidad'];
                        $precioEspecial = $_POST['precioEspecial'];
                        mysqli_query($MySQLi, "UPDATE claveTemporal SET cantidad='$cantidad',precioEspecial='$precioEspecial' WHERE idClave='$idClave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        listaProductosTemporales($MySQLi, $claveCotizacion);
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'mostrarProductosTemporales':
                    if (isset($_SESSION['idUser'])) {
                        $claveCotizacion = $_POST['claveCotizacion'];
                        listaProductosTemporales($MySQLi, $claveCotizacion);
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'borrarProductoTemporal':
                    if (isset($_SESSION['idUser'])) {
                        $idClave = $_POST['idClave'];
                        $claveTemporal = $_POST['claveTemporal'];
                        mysqli_query($MySQLi, "DELETE FROM claveTemporal WHERE idClave='$idClave' ");
                        listaProductosTemporales($MySQLi, $claveTemporal);
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'generarCotizacion':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_SESSION['idUser'];
                        $servicioStock = $_POST['serviStock'];
                        $servicioProveedor = $_POST['serviProveedor'];
                        $servicioCategoria = $_POST['serviCategoria'];
                        $numeroSucursales = $_POST['numerodeSucursale'];
                        $clienteExistente = $_POST['clienteExistente'];
                        $claveTemporal = $_POST['claveTemporal'];
                        $idCliente = $_POST['idCliente'];
                        $nombreCliente = $_POST['nombreCliente'];
                        $celularCliente = $_POST['telefonoCliente'];
                        $idCiudadCliente = $_POST['ciudadCliente'];
                        $correoCliente = $_POST['correo'];
                        $empresaCliente = $_POST['empresaCliente'];
                        $telempresaCliente = $_POST['telefonoEmpresa'];
                        $extEmpresaCliente = $_POST['extEmpresa'];
                        $direccion = $_POST['direccion'];
                        $comentarios = $_POST['comentarios'];
                        $idTelegram = $_POST['idTelegram'];

                        $precioVenta = $_POST['precioVenta'];
                        $cantidadProducto = $_POST['cantidadProducto'];
                        $precioEspecial = $_POST['precioEspecial'];

                        $formaPago = $_POST['formaPago'];
                        $tiempoEntrega = $_POST['tiempoEntrega'];
                        $validezCotizacion = $_POST['validezCotizacion'];
                        $detallesGarantia = $_POST['detallesGarantia'];
                        $observaciones = $_POST['observaciones'];

                        $idCliente = $_POST['idCliente'];
                        $idTienda = $_SESSION['idTienda'];

                        $codigoCotizacion = codigoCotizacion($MySQLi, $idTienda);
                        if ($clienteExistente == 0) {
                            $guardarCliente = mysqli_query($MySQLi, "INSERT INTO clientes() VALUES (null, '$idUser', '$idTienda', '$idCiudadCliente', '$idTelegram', '$nombreCliente', '$correoCliente', '$empresaCliente', '$telempresaCliente', '$extEmpresaCliente', '$celularCliente', '$direccion', '$comentarios', '$fecha')");
                            /*    Buscar cliente creado    */
                            $buscarCliente = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE nombre='$nombreCliente' AND idUser='$idUser' AND idTienda='$idTienda' ");
                            $dataCliente = mysqli_fetch_assoc($buscarCliente);
                            $clienteExistente = $dataCliente['idCliente'];
                        } else {
                            $updateCliente = mysqli_query($MySQLi, "UPDATE clientes SET idTelegram='$idTelegram', nombre='$nombreCliente', correo='$correoCliente', empresa='$empresaCliente', telEmpresa='$telempresaCliente', ext='$extEmpresaCliente', celular='$celularCliente', direccion='$direccion', comentarios='$comentarios' WHERE idCliente='$clienteExistente' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        }
                        mysqli_query($MySQLi, "INSERT INTO cotizaciones() VALUES(null, '$codigoCotizacion', '$claveTemporal', '$idUser', '$clienteExistente', '$idTienda', '$formaPago', '$validezCotizacion', '$tiempoEntrega', '$detallesGarantia', '$observaciones', '$fecha', '$Hora', 0) ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        mysqli_close($MySQLi);
                        alert_cotizacionGuardada();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'borrarCotizacionGenerada':
                    if (isset($_SESSION['idUser'])) {
                        $idCotizacion = $_POST['idCotizacion'];
                        $claveCotiza = $_POST['clave'];
                        $borrarCotiza = mysqli_query($MySQLi, "DELETE FROM cotizaciones WHERE idCotizacion='$idCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        $borrarClaves = mysqli_query($MySQLi, "DELETE FROM claveTemporal WHERE claveTemporal='$claveCotiza' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        alert_cotizacionBorrada();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'marcarComoEntregada':
                    if (isset($_SESSION['idUser'])) {
                        $idCotizacion = $_POST['idCotizacion'];
                        mysqli_query($MySQLi, "UPDATE cotizaciones SET estado=1 WHERE idCotizacion='$idCotizacion' ");
                        alert_cotizacionEntrega();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'VenderCotizacionCash':
                    if (isset($_SESSION['idUser'])) {
                        $serviPrecioDolar = $_POST['serviPrecioDolar'];
                        $serviStock = $_POST['serviStock'];
                        if ($serviPrecioDolar == 1) {
                            $idMoneda = $_POST['moneda'];
                            $precioDolar = $_POST['dolar'];
                            if ($idMoneda != 1) {
                                $cantidadNumeros1 = 0;
                                $cantidadNumeros2 = $_POST['cantidad'] / $precioDolar;
                            } else {
                                $cantidadNumeros1 = $_POST['cantidad'] / $precioDolar;
                                $cantidadNumeros2 = 0;
                            }
                        } else {
                            $idMoneda = 1;
                            $precioDolar = 0;
                            $cantidadNumeros1 = $_POST['cantidad'];
                            $cantidadNumeros2 = 0;
                        }
                        $idCotizacion = $_POST['idCotizacion'];
                        $claveCotizacion = $_POST['clave'];
                        $idVendedor = $_POST['idVendedor'];
                        
                        if ($idVendedor == "-1") {
                            $sql = "INSERT INTO usuarios VALUES (null,1, 2, '-1', 'Vendedor', '" . $_POST['nombreVendedor'] . "', '', '', '', '','',0,0, '', null,1,'','V')";
                            mysqli_query($MySQLi, $sql);
                            
                            $nombreVendedor = "";
                            $buscarCliente = mysqli_query($MySQLi, "SELECT idUser, Nombre FROM usuarios WHERE Nombre='" . $_POST['nombreVendedor'] . "'");
                            $dataCliente = mysqli_fetch_assoc($buscarCliente);
                            $nombreVendedor = $dataCliente['Nombre'];
                            $idVendedor = $dataCliente['idUser'];
                        }
                        else {
                            $nombreVendedor = "";
                            $buscarCliente = mysqli_query($MySQLi, "SELECT idUser, Nombre FROM usuarios WHERE idUser='$idVendedor'");
                            $dataCliente = mysqli_fetch_assoc($buscarCliente);
                            $nombreVendedor = $dataCliente['Nombre'];
                            //$_POST['nombreVendedor'];
                        }
                        
                        $idTienda = $_POST['idTienda'];
                        $codigoCotizacion = $_POST['codigoCotizacion'];
                        $idCliente = $_POST['idCliente'];
                        $nombreCliente = $_POST['recibide'];
                        $cantidadLetras = $_POST['cantidadLetras'];
                        $concepto = $_POST['concepto'];
                        // Generamos el recibo
                        mysqli_query($MySQLi, "INSERT INTO recibos VALUES(null,'$idCotizacion', '$codigoCotizacion', '$claveCotizacion', '$idTienda', '$idVendedor', '$nombreVendedor', '$idCliente', '$nombreCliente', '$idMoneda', '$precioDolar', '$cantidadNumeros1', '$cantidadNumeros2', '$cantidadLetras', '$concepto', '$cantidadNumeros1', '$cantidadNumeros2', 0,0,0,0, '$fecha',1) ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        // llamamos el recibo generado
                        $Q_Recibos = mysqli_query($MySQLi, "SELECT idRecibo FROM recibos WHERE idCotizacion='$idCotizacion' ");
                        $resultQ_Recibos = mysqli_num_rows($Q_Recibos);
                        if ($resultQ_Recibos > 1) {
                            $ultimoRecibo = $resultQ_Recibos - 1;
                            $Q_Recibo = mysqli_query($MySQLi, "SELECT idRecibo FROM recibos WHERE idCotizacion='$idCotizacion' LIMIT $ultimoRecibo,1");
                            $dataRecibo = mysqli_fetch_assoc($Q_Recibo);
                            $idRecibo = $dataRecibo['idRecibo'];
                        } else {
                            $dataRecibo = mysqli_fetch_assoc($Q_Recibos);
                            $idRecibo = $dataRecibo['idRecibo'];
                        }
                        // Generamos la nota de entrega
                        mysqli_query($MySQLi, "INSERT INTO notaEntrega VALUES(null,'$idCotizacion', '$codigoCotizacion', '$claveCotizacion', '$idTienda', '$idVendedor', '$nombreVendedor', '$idCliente', '$nombreCliente','', '$fecha') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        // Llamamos la nota de entrega generada
                        $Q_NotasdeEntrega = mysqli_query($MySQLi, "SELECT idNotaE FROM notaEntrega WHERE idCotizacion='$idCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        $resultQ_Notas = mysqli_num_rows($Q_NotasdeEntrega);
                        if ($resultQ_Notas > 1) {
                            $ultimaNotaEntrega = $resultQ_Notas - 1;
                            $Q_NotadeEntrega = mysqli_query($MySQLi, "SELECT idNotaE FROM notaEntrega WHERE idCotizacion='$idCotizacion' LIMIT $ultimaNotaEntrega,1 ");
                            $dataNotaEntrega = mysqli_fetch_assoc($Q_NotadeEntrega);
                            $idNotaEntrega = $dataNotaEntrega['idNotaE'];
                        } else {
                            $dataNotaEntrega = mysqli_fetch_assoc($Q_NotasdeEntrega);
                            $idNotaEntrega = $dataNotaEntrega['idNotaE'];
                        }
                        // Ahora, descontamos los productos de la base de datos
                        $Q_Claves = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        while ($dataClave = mysqli_fetch_assoc($Q_Claves)) {
                            $idProducto = $dataClave['idProducto'];
                            $cantidadProducto = $dataClave['cantidad'];

                            $precioVenta1 = $dataClave['precioVenta'] * $precioDolar;
                            $precioEspecial1 = $dataClave['precioEspecial'] * $precioDolar;
                            $precioVenta2 = $dataClave['precioVenta'];
                            $precioEspecial2 = $dataClave['precioEspecial'];

                            if ($serviStock == 1) {
                                $Q_Sucursal = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idTienda' ");
                                $dataSucursal = mysqli_fetch_assoc($Q_Sucursal);
                                $nombreSucursal = $dataSucursal['sucursal'];
                                $Q_Inventario = mysqli_query($MySQLi, "SELECT stock FROM inventario WHERE idProducto='$idProducto'AND idTienda='$idTienda' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                $dataInventario = mysqli_fetch_assoc($Q_Inventario);
                                $stockProducto = $dataInventario['stock'];
                                $nuevoStock = $stockProducto - $cantidadProducto;
                                //historial stock cotizaciones
                                registro_stock_repuestos($MySQLi, $idTienda, $idProducto, $stockProducto, $cantidadProducto, $nuevoStock, 'Descuento Stock Cotizaciones', '-');

                                $Q_Producto = mysqli_query($MySQLi, "SELECT nombre FROM productos WHERE idProducto='$idProducto' ");
                                $dataProducto = mysqli_fetch_assoc($Q_Producto);
                                $nombreProducto = $dataProducto['nombre'];
                                
                                $Q_Producto_stock = mysqli_query($MySQLi, "SELECT stock FROM inventario WHERE idProducto='$idProducto' and idTienda='$idTienda'");
                                $dataProductoStock = mysqli_fetch_assoc($Q_Producto_stock);
                                $ProductoStock = $dataProductoStock['stock'];                                
                                
                                ///if ($nuevoStock < $ProductoStock)
                                ///    $nuevoStock = $ProductoStock;
                                
                                mysqli_query($MySQLi, "UPDATE inventario SET stock='$nuevoStock' WHERE idProducto='$idProducto'AND idTienda='$idTienda' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                // if ($nuevoStock < 10) {
                                //     $Q_Admin = mysqli_query($MySQLi, "SELECT correo FROM usuarios WHERE idRango=2 ");
                                //     $resultAdmin = mysqli_num_rows($Q_Admin);
                                //     $Q_Plantilla = mysqli_query($MySQLi, "SELECT html FROM plantillashtml WHERE nombre='stockBajo' ");
                                //     $dataPlantilla = mysqli_fetch_assoc($Q_Plantilla);
                                //     $html = $dataPlantilla['html'];
                                //     $html = str_replace('{nombreProducto}', $nombreProducto, $html);
                                //     $html = str_replace('{numerodeProductos}', $cantidadProducto, $html);
                                //     $html = str_replace('{nombreSucursal}', $nombreSucursal, $html);
                                //     $html = str_replace('{stockAnterior}', $stockProducto, $html);
                                //     $html = str_replace('{stockActual}', $nuevoStock, $html);
                                //     $html = str_replace('{anioActual}', $Year, $html);
                                //     $html = str_replace('{linkSoporte}', 'https://yapame.com.bo/soporte', $html);
                                //     $html = str_replace('{linkTerminos}', 'https://yapame.com.bo/terminos-y-condiciones/', $html);
                                //     $html = str_replace('{linkPrivacidad}', 'https://yapame.com.bo/terminos-y-condiciones/', $html);

                                //     for ($i = 0; $i < $resultAdmin; $i++) {
                                //         $Q_MailAdmin = mysqli_query($MySQLi, "SELECT correo FROM usuarios WHERE idRango>2 LIMIT $i,1 ");
                                //         $dataMailAdmin = mysqli_fetch_assoc($Q_MailAdmin);
                                //         $correoAdmin = $dataMailAdmin['correo'];
                                //         try {
                                //             $mail->SMTPDebug = 0;
                                //             $mail->isSMTP();
                                //             $mail->Host = APP_EMAIL_HOST;
                                //             $mail->SMTPAuth = true;
                                //             $mail->Username = APP_EMAIL_USER;
                                //             $mail->Password = APP_EMAIL_PASSWORD;
                                //             $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                //             $mail->Port = 465;

                                //             //Recipients
                                //             $mail->setFrom(APP_EMAIL_USER, $Soporte);
                                //             $mail->addAddress($correoAdmin, $Soporte);
                                //             $mail->addBCC(APP_EMAIL_USER);
                                //             // Content
                                //             $mail->Charset = 'utf-8';
                                //             $mail->isHTML(true);
                                //             $mail->Subject = 'Prueba DESCUENTO STOCK';
                                //             $mail->Body = $html;
                                //             $mail->send();
                                //         } catch (Exception $e) {
                                //             //mysqli_close($MySQLi); errorMail();
                                //             //alert_errorAlRegistraralUsuario();
                                //             echo "error al intentar enviar el correo<br> " . $e;
                                //             exit();
                                //         }
                                //     }
                                // }
                            }
                            // Ingresamos los datos de la venta a la base de datos
                            $totalVenta1 = $cantidadProducto * $precioEspecial1;
                            $totalVenta2 = $cantidadProducto * $precioEspecial2;
                            mysqli_query(
                                $MySQLi,
                                "INSERT INTO ventas VALUES(null, '$idCotizacion', '$codigoCotizacion',
                  '$claveCotizacion', '$idTienda', '$idVendedor', '$nombreVendedor',
                   '$idCliente', '$nombreCliente', '$idRecibo', '$idNotaEntrega',
                    '$idProducto', '$cantidadProducto', '$idMoneda',
                     '$precioDolar', '$precioVenta1', '$precioEspecial1',
                      '$totalVenta1', '$precioVenta2', '$precioEspecial2',
                       '$totalVenta2', '$fecha', 1,1) "
                            ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                            //insertamos a soporte_ventas tb

                            $fecha_completado = $fecha; //soporte sucursales
                            $fecha_recepcion = $fecha;
                            $fecha_nota_entrega_yuli = json_encode(['Venta Directa Repuesto'], JSON_UNESCAPED_UNICODE);
                            $nro_servicio_recepcion = 0; //soporte sucursales
                            $nota_entrega_venta_maquina = json_encode(['0'], JSON_UNESCAPED_UNICODE);
                            $nro_factura = 0; //yuli factura ---------------

                            $q_cliente = mysqli_query($MySQLi, "SELECT nombre FROM clientes WHERE idCliente='$idCliente' ");
                            $d_cliente = mysqli_fetch_assoc($q_cliente);
                            $nombre_cliente = $d_cliente['nombre'];

                            $nit_cliente = 0; //de la emision vendra

                            $nombre_maquinas = json_encode(['Venta Directa Repuesto'], JSON_UNESCAPED_UNICODE);

                            $garantias_repuestos = json_encode(['no'], JSON_UNESCAPED_UNICODE);
                            $garantias_mano = json_encode(['no'], JSON_UNESCAPED_UNICODE);

                            $q_producto = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
                            $d_producto = mysqli_fetch_assoc($q_producto);
                            $nombre_repuesto = $d_producto['mercaderia'] . '  ' . $d_producto['nombre'] . '  ' . $d_producto['marca'] . '  ' . $d_producto['modelo'];
                            $repuestos_nombres = json_encode([[$nombre_repuesto]], JSON_UNESCAPED_UNICODE);

                            $repuestos_precio_lista = json_encode([[$precioVenta1]], JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                            $repuestos_cantidad = json_encode([[$cantidadProducto]], JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                            $repuestos_precio_venta = json_encode([[$precioEspecial1]], JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                            $insumo_externo = json_encode([['Venta Directa Repuesto']], JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos

                            $servicio_externo = json_encode([['Venta Directa Repuesto']], JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                            $otros_gastos = json_encode([['Venta Directa Repuesto']], JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos

                            $precio_mano_obra = json_encode(['Venta Directa Repuesto'], JSON_UNESCAPED_UNICODE); //soporte claves costo
                            $costo_adicional = json_encode(['Venta Directa Repuesto'], JSON_UNESCAPED_UNICODE); //soporte claves costo
                            $total_cobrar_bs = (float)$totalVenta1; //sumar todo los equipos y sus repuestos y insumos

                            $q_precio_dolar = mysqli_query($MySQLi, "SELECT * FROM `preciodolar`");
                            $d_precio_dolar = mysqli_fetch_assoc($q_precio_dolar);
                            $precio_dolar = (float)$d_precio_dolar['precio'];
                            $total_cobrar_usd = (float)$totalVenta2;

                            $importe_facturado = 0; //de la emision vendra---------------
                            $id_user = $idVendedor;
                            $id_user_entrego = $idVendedor;
                            $descripcion_reparacion = json_encode(['Venta Directa Repuesto'], JSON_UNESCAPED_UNICODE); //soporte Claves
                            //sucursal id
                            $idUser = $_SESSION['idUser'];
                            $q_id_sucursal = mysqli_query($MySQLi, "SELECT idTienda FROM usuarios WHERE idUser='$idUser'");
                            $d_id_sucursal = mysqli_fetch_assoc($q_id_sucursal);
                            //$id_sucursal = $d_id_sucursal['idTienda'];
                            $id_sucursal = $idTienda;


                            $idCotizacion = $idCotizacion;
                            $idSoporte = 0;

                            $clave_soporte = 'Venta Directa Repuesto';
                            $estado = 1;


                                   mysqli_query($MySQLi,"delete from soporte_ventas where 
                               nro_servicio_recepcion =$$idSoporte and fecha_recepcion='$fecha_recepcion' and
                               idSoporte = $idSoporte and
                               estado = 1");
                               
                            mysqli_query(
                                $MySQLi,
                                "INSERT INTO `soporte_ventas`( `fecha_completado`, `fecha_recepcion`,
              `fecha_nota_entrega_yuli`, `nro_servicio_recepcion`,
               `nota_entrega_venta_maquina`, `nro_factura`,
                `nombre_cliente`, `nit_cliente`,
                 `nombre_maquinas`,`garantias_repuestos`,`garantias_mano`, `repuestos_nombres`,
                  `repuestos_precio_lista`, `repuestos_cantidad`,
                   `repuestos_precio_venta`, `insumo_externo`,
                   `servicio_externo`, `otros_gastos`,
                    `precio_mano_obra`, `costo_adicional`, `total_cobrar_bs`, `precio_dolar`,
                     `total_cobrar_usd`, `importe_facturado`,
                      `id_user`, `id_user_entrego`,
                       `descripcion_reparacion`, `id_sucursal`, `idCotizacion`, `idSoporte`,
                        `clave_soporte`, `estado`) VALUES ('$fecha_completado','$fecha_recepcion',
                        '$fecha_nota_entrega_yuli','$nro_servicio_recepcion',
                        '$nota_entrega_venta_maquina','$nro_factura',
                        '$nombre_cliente','$nit_cliente',
                        '$nombre_maquinas','$garantias_repuestos','$garantias_mano','$repuestos_nombres',
                        '$repuestos_precio_lista','$repuestos_cantidad',
                        '$repuestos_precio_venta','$insumo_externo',
                        '$servicio_externo','$otros_gastos',
                        '$precio_mano_obra','$costo_adicional','$total_cobrar_bs', '$precio_dolar',
                        '$total_cobrar_usd','$importe_facturado',
                        '$id_user','$id_user_entrego',
                        '$descripcion_reparacion','$id_sucursal', '$idCotizacion', '$idSoporte',
                        '$clave_soporte','$estado')"
                            ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        }
                        mysqli_query($MySQLi, "UPDATE cotizaciones SET estado=2, fecha='$fecha' WHERE idCotizacion='$idCotizacion' ");
                        $claveTemporal = $claveCotizacion;
                        // ahora, abrimos el modal de la nota de entrega 
                            ?>
            <script type="text/javascript">
                $("#openModalNotaEntrega").modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#idNotaEntregaModal").val("<?php echo $idNotaEntrega ?>");
            </script>
            <?php
                        listaProductos_notaEntrega($MySQLi, $claveTemporal);
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'actualizarNotaEntrega':
                    if (isset($_SESSION['idUser'])) {
                        $idNotaEntrega = $_POST['idNotaEntrega'];
                        $descripcion = $_POST['descripcion'];
                        mysqli_query($MySQLi, "UPDATE notaEntrega SET observaciones='$descripcion' WHERE idNotaE='$idNotaEntrega' ");
                        alert_notaEntregaOK();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                    // PLANTILLAS HTML
                case 'actualizarPlantilla':
                    if (isset($_SESSION['idUser'])) {
                        $idPlantilla = $_POST['idPlantilla'];
                        $nombrePlant = $_POST['nombrePlantilla'];
                        $contenidoPlan = $_POST['contenidoPlantilla'];
                        mysqli_query($MySQLi, "UPDATE plantillasHTML SET nombre='$nombrePlant',html='$contenidoPlan' WHERE idPlantilla='$idPlantilla' ");
                        mysqli_close($MySQLi) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        exit();
                        alert_plantillaHTMLactualizada();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                case 'guardarPlantilla':
                    if (isset($_SESSION['idUser'])) {
                        $nombrePlant = $_POST['nombrePlantilla'];
                        $contenidoPlan = $_POST['contenidoPlantilla'];
                        mysqli_query($MySQLi, "INSERT INTO plantillasHTML () VALUES (null, '$nombrePlant', '$contenidoPlan',1)") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        mysqli_close($MySQLi);
                        alert_plantillaHTMLcreada();
                    } else {
                        alert_sesionCaducada();
                    }
                    break;
                    //USUARIOS
                case 'updataUser':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_POST['idUser'];
                        $telefono = $_POST['telefono'];
                        $correo = $_POST['correo'];
                        $apiTele = $_POST['idTelegram'];
                        // verificamos si hay cambios
                        $Q_Usuario = mysqli_query($MySQLi, "SELECT telefono,correo,idTelegram FROM usuarios WHERE idUser='$idUser' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        $dataUser = mysqli_fetch_assoc($Q_Usuario);
                        if ($dataUser['telefono'] == $telefono & $dataUser['correo'] == $correo and $dataUser['idTelegram'] == $apiTele) { ?>
                <script type="text/javascript">
                    $(".updateDatos").before(
                        "<div class='text-center text-danger my-2 nadaQueGuardar'><b>NO HAY DATOS QUE GUARDAR!!</b></div>");
                    setTimeout(function() {
                        $(".nadaQueGuardar").remove();
                    }, 1500);
                </script>
            <?php
                        } else {
                            mysqli_query($MySQLi, "UPDATE usuarios SET telefono='$telefono', correo='$correo', idTelegram='$apiTele' WHERE idUser='$idUser' "); ?>
                <script type="text/javascript">
                    var telefono = "<?php echo $telefono ?>";
                    var correo = "<?php echo $correo ?>";
                    var apiTele = "<?php echo $apiTele ?>";
                    $("#mailUser").val(correo);
                    $("#telUser").val(telefono);
                    $("#idTelegram").val(apiTele);
                </script><?php
                            if ($dataUser['correo'] != $correo) {
                                session_destroy(); ?>
                    <script type="text/javascript">
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Datos Actualizados.',
                            html: 'Como el correo ahora es diferente, tu sesión será cerrada para que puedas ingresar con tu nuevo correo, la contraseña sigue siendo la misma por ahora.',
                            showConfirmButton: false,
                        })
                        setTimeout(function() {
                            location.reload()
                        }, 4000);
                    </script><?php
                            }
                        }
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'DeshabilitarUsuario':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['idRango'] == 1) {
                            sinAutorizacion($MySQLi);
                        } else {
                            $idUser = $_POST['idUser'];
                            $Q_user = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUser' ");
                            $data = mysqli_fetch_assoc($Q_user);
                            $idRango = $data['idRango'];
                            if ($idRango == 1) {
                                mysqli_query($MySQLi, "UPDATE usuarios SET Estado=0 WHERE idUser='$idUser' ");
                                mysqli_close($MySQLi);
                                usuarioDesactivado();
                            } else {
                                mysqli_close($MySQLi);
                                noPermitido();
                            }
                        }
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'cambiarPswdmiPerfil':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_POST['idUser'];
                        $password = $_POST['password'];
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        // VERIFICAMOS SI HAY CAMBIOS
                        $Q_Usuario = mysqli_query($MySQLi, "SELECT contrasena FROM usuarios WHERE idUser='$idUser' ");
                        $dataUsuario = mysqli_fetch_assoc($Q_Usuario);
                        if (password_verify($password, $dataUsuario['contrasena'])) { ?>
                <script type="text/javascript">
                    $(".responseBtnChangePswd").before(
                        "<div class='text-center text-danger my-2 nadaQueGuardar2'><b>NO HAY DATOS QUE GUARDAR!!</b></div>");
                    setTimeout(function() {
                        $(".nadaQueGuardar2").remove();
                    }, 1500);
                </script><?php
                        } else {
                            mysqli_query($MySQLi, "UPDATE usuarios SET contrasena='$password_hash' WHERE idUser='$idUser' ");
                            session_destroy();
                            mysqli_close($MySQLi);
                            contrasenaUPDATED();
                        }
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'ActualizarAPITele':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_POST['idUser'];
                        $apiTele = $_POST['api'];
                        $Q_user = mysqli_query($MySQLi, "SELECT apitelegram FROM usuarios WHERE idUser='$idUser' ");
                        $dataUser = mysqli_fetch_assoc($Q_user);
                        if ($dataUser['apitelegram'] == $apiTele) {
                            apiTelesincambios();
                            exit();
                        }
                        mysqli_query($MySQLi, "UPDATE usuarios SET apitelegram='$apiTele' WHERE idUser='$idUser' ");
                        apiTeleActualizada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'BorrarmiCliente':
                    if (isset($_SESSION['idUser'])) {
                        $idCliente = $_POST['idCliente'];
                        $idUser = $_SESSION['idUser'];
                        $idRango = $_SESSION['idRango'];
                        mysqli_query($MySQLi, "DELETE FROM clientes WHERE idCliente='$idCliente' ");
                        listaClientes($MySQLi, $idUser, $idRango);
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'enviarCotizacionxCorreo':
                    if (isset($_SESSION['idUser'])) {
                        $idCotizacion = $_POST['idCotizacion'];
                        $correoCliente = $_POST['correoCliente'];
                        $asunto = $_POST['asunto'];
                        $mensaje = $_POST['mensaje'];
                        try {
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = 'yuliimport.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'support@yuliimport.com';
                            $mail->Password = '0fT2+#Y=BOW]';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                            $mail->Port = 465;

                            //Recipients
                            $mail->setFrom('support@yuliimport.com', 'Soporte');
                            //$mail->addAddress('support@yuliimport.com', 'Soporte');

                            $mail->addAddress($correoCliente);
                            //$mail->addBCC(APP_EMAIL_USER);
                            // Content
                            $mail->Charset = 'utf-8';
                            $mail->isHTML(true);

                            $mail->Subject = utf8_decode($asunto);
                            $mail->Body = $mensaje;
                            echo 'gaa';
                            $ruta = "Cotizaciones/Cotizacion " . $idCotizacion . ".pdf";
                            if (isset($ruta)) {
                                $mail->addAttachment($ruta);
                                $mail->send();
                                echo 'llego';
                                unlink($ruta);
                            } else {
                                echo "no existe la ruta";
                            }
                            alert_cotizacionEnviadaporMail();
                        } catch (Exception $e) {
                            //mysqli_close($MySQLi); errorMail();
                            //alert_errorAlRegistraralUsuario();
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    // SMS
                case 'EnviarSMS':
                    if (isset($_SESSION['idUser'])) {
                        $clientes = $_POST['cliente'];
                        $idUser = $_POST['idUsuario'];
                        $mensaje = $_POST['mensaje'];
                        $idCliente = count($clientes);
                        for ($i = 0; $i < $idCliente; $i++) {
                            $ClienteID = $clientes[$i] . "<br>";
                            //Aqui la librería de clockwork
                            /*<==========================>*/
                            echo "función en proceso";
                        }
                    } else {
                        mysqli_close($MySQLi);
                        session_unset();
                        session_destroy();
                        alert_sesionCaducada();
                    }
                    break;
                    // SOPORTE TECNICO 22 01 2023
                case 'GuardarDetallesdeReparacion':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_SESSION['idUser'];
                        $clave = $_POST['clave'];
                        $realizado = isset($_POST['realizado']) ? $_POST['realizado'] : array();
                        $realizados = is_array($realizado) ? count($realizado) : 0;
                        $costos = isset($_POST['costo']) ? $_POST['costo'] : array();
                        $idClaves = isset($_POST['idClave']) ? $_POST['idClave'] : array();
                        $sucursal = $_POST['sucursal'];
                        // if ($sucursal == 'Cochabamba') {
                        //     $dataBase = "soporte_cba";
                        // } else {
                        //     $dataBase = "soporte_stc";
                        // }
                        for ($i = 0; $i < $realizados; $i++) {
                            $trabajoRealizado = $realizado[$i];
                            $costo = $costos[$i];
                            $idClave = $idClaves[$i];
                            mysqli_query($MySQLi, "UPDATE soporte_claves SET trabajoRealizado='$trabajoRealizado', costoAdicional='$costo', estado=2 WHERE idClave='$idClave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        }
                        mysqli_query($MySQLi, "UPDATE soporte_sucursales SET estado=2, idUser_Reparo='$idUser', fechaReparacion='$fecha' WHERE clave_soporte='$clave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        equipoReparado();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                    //SECCION EDITADA EL 17 NOV 2021
                case 'GuardarnuevoServicio':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_SESSION['idUser'];
                        $sucursal = $_POST['sucursal'];
                        $idSucursal = $_POST['idSucursal'];
                        $claveServicio = $_POST['claveSoporte'];
                        $nombreCliente = $_POST['nombre'];
                        $cellCliente = $_POST['celular'];
                        $equipo = $_POST['equipo'];
                        $marca = $_POST['marca'];
                        $modelo = $_POST['modelo'];
                        $serie = $_POST['serie'];
                        $direccion = $_POST['direccion'];
                        $problema = $_POST['problema'];
                        $observaciones = $_POST['observaciones'];

                        $fechaVenta = $_POST['fechaVenta']; //nuevos campos
                        $garantiaEquipoRepuesto = $_POST['garantiaEquipoRepuesto']; //nuevos campos
                        $garantiaEquipoMano = $_POST['garantiaEquipoMano']; //nuevos campos
                        $json_yuli = $_POST['getDataClientesYuliJson'];

                        // if($nombreCliente!='' || $equipo!=''){
                        //         $insertDatos = mysqli_query($MySQLi,
                        //          "INSERT INTO soporte_claves (sucursal,idSucursal,
                        //           clave, equipo, marca, modelo, serie, problema,
                        //         observaciones, fechaCompra,garantia_vigente_repuesto,garantia_vigente_mano)
                        //          VALUES ('$sucursal', '$idSucursal',
                        //           '$claveServicio', '$equipo', '$marca', '$modelo', '$serie', '$problema',
                        //            '$observaciones',  '$fechaVenta','$garantiaEquipoRepuesto','$garantiaEquipoMano') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        // }
                        $insertDatosServ = mysqli_query(
                            $MySQLi,
                            "INSERT INTO soporte_sucursales (sucursal,idSucursal,
                  idUser, clave_soporte,
                   nombreCliente, telCliente, direccion,
                   json_yuli) VALUES ('$sucursal','$idSucursal', '$idUser', '$claveServicio', '$nombreCliente', '$cellCliente', '$direccion', '$json_yuli') "
                        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        //$insertDatosServ = mysqli_query($MySQLi, "INSERT INTO soporte_stc (sucursal, idUser, clave_soporte, nombreCliente, telCliente) VALUES ('$sucursal', '$idUser', '$claveServicio', '$nombreCliente', '$cellCliente') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

                        registroServicioGuardado();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'GuardarClaveServicio':
                    if (isset($_SESSION['idUser'])) {
                        $sucursal = $_POST['sucursal'];
                        $idSucursal = $_POST['idSucursal'];
                        $claveServicio = $_POST['Clave'];
                        $equipo = $_POST['equipo'];
                        $marca = $_POST['marca'];
                        $modelo = $_POST['modelo'];
                        $serie = $_POST['serie'];
                        $problema = $_POST['problema'];
                        $observaciones = $_POST['observaciones'];

                        $fechaVenta = $_POST['fechaVenta']; //nuevos campos

                        if ($fechaVenta == '') {

                            $fechaVenta = '0000-00-00';
                        }
                        $garantiaEquipoRepuesto = $_POST['garantiaEquipoRepuesto']; //nuevos campos
                        $garantiaEquipoMano = $_POST['garantiaEquipoMano']; //nuevos campos
                        $notaEntrega = $_POST['notaEntrega'];

                        $insertDatos = mysqli_query(
                            $MySQLi,
                            "INSERT INTO soporte_claves (sucursal,idSucursal,
             clave, equipo, marca, modelo, serie, problema,
           observaciones, fechaCompra,garantia_vigente_repuesto,garantia_vigente_mano,notaEntrega)
            VALUES ('$sucursal', '$idSucursal',
             '$claveServicio', '$equipo', '$marca', '$modelo', '$serie', '$problema',
              '$observaciones',  '$fechaVenta','$garantiaEquipoRepuesto','$garantiaEquipoMano','$notaEntrega') "
                        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                            ?>
            <table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
                <thead>
                    <tr>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Marca</th>
                        <th class="text-center">Modelo</th>
                        <th class="text-center">Serie</th>

                        <th class="text-center">Garantia Repuesto</th>
                        <th class="text-center">Garantia Mano de obra</th>

                        <th class="text-center">Fecha de<br>Compra</th>
                        <th class="text-center">N&ordm; de Nota de Entrega</th>
                    </tr>
                </thead>
                <tbody><?php
                        $Q_Service = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$claveServicio' AND sucursal='$sucursal' ORDER BY equipo ASC ");
                        $resultServ = mysqli_num_rows($Q_Service);
                        if ($resultServ > 0) {
                            while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) { ?>
                            <tr>
                                <td><?= $dataRegistros['equipo'] ?></td>
                                <td><?= $dataRegistros['marca'] ?></td>
                                <td><?= $dataRegistros['modelo'] ?></td>
                                <td><?= $dataRegistros['serie'] ?></td>

                                <td class="text-center"><?= $dataRegistros['garantia_vigente_repuesto'] ?></td>
                                <td class="text-center"><?= $dataRegistros['garantia_vigente_mano'] ?></td>

                                <td class="text-center"><?= $dataRegistros['fechaCompra'] ?></td>
                                <td class="text-center"><?= $dataRegistros['notaEntrega'] ?></td>

                                <!--td class="text-center"-->
                                <!--button class="btn btn-success btn-sm btn-icon rounded-circle openModalEditServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar Servicio (<?php //echo $dataRegistros['idClave'] 
                                                                                                                                                                                                                                                                                                                                        ?>)" id="<?php //echo $dataRegistros['idClave']
                                                                                                                                                                                                                                                                                                                                                    ?>"><i class="fal fa-edit"></i></button-->&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                                                                            //if ($resultServ>1) { 
                                                                                                                                                                                                                                                                                                                                                                                                            ?>
                                <!--button class="btn btn-danger btn-sm btn-icon rounded-circle deleteServicio"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Eliminar servicio (<?php //echo $dataRegistros['idClave'] 
                                                                                                                                                                                                                                                                                                                                ?>)" id="<?php //echo $dataRegistros['idClave']
                                                                                                                                                                                                                                                                                                                                            ?>"><i class="fal fa-trash-alt"></i></button-->
                                <!--/td-->
                                <?php
                                //}

                                ?>
                            </tr> <?php    }
                            } else {
                                echo '<tr>
									<td colspan="7" class="text-center text-danger" style="letter-spacing: 1px">NO HAY SERVICIOS QUE MOSTRAR</td></tr>';
                            } ?>
                </tbody>
            </table><?php
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'GuardarClaveServicio2':
                    if (isset($_SESSION['idUser'])) {
                        $claveServicio = $_POST['Clave'];
                        $equipo = $_POST['equipo'];
                        $marca = $_POST['marca'];
                        $modelo = $_POST['modelo'];
                        $serie = $_POST['serie'];
                        $problema = $_POST['problema'];
                        $observaciones = $_POST['observaciones'];
                        $realizar = $_POST['realizar'];
                        $garantia = $_POST['garantia'];

                        $sucursal = $_POST['sucursal'];
                        $idSucursal = $_POST['idSucursal'];

                        if ($garantia == 'no') {

                            $insertDatos = mysqli_query($MySQLi, "INSERT INTO soporte_claves (sucursal,idSucursal,clave, equipo, marca, modelo, serie, problema, observaciones, realizar, garantia) VALUES ('$sucursal','$idSucursal','$claveServicio', '$equipo', '$marca', '$modelo', '$serie', '$problema', '$observaciones', '$realizar', '$garantia') ");
                        } else {
                            $fechaCompra = $_POST['fechaCompra'];
                            $numeroFactura = $_POST['numeroFactura'];
                            $insertDatos = mysqli_query($MySQLi, "INSERT INTO soporte_claves (sucursal,idSucursal,clave, equipo, marca, modelo, serie, problema, observaciones, realizar, garantia, fechaCompra, numFactura) VALUES ('$sucursal','$idSucursal','$claveServicio', '$equipo', '$marca', '$modelo', '$serie', '$problema', '$observaciones', '$realizar', '$garantia', '$fechaCompra', '$numeroFactura') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        }

                        otroEquipoAgregado();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'CancelarOrdenparticularReparacion':
                    if (isset($_SESSION['idUser'])) {
                        $idClave = $_POST['idClave'];
                        $motivo = $_POST['motivo'];
                        $clave = $_POST['clave'];
                        $sucursal = $_POST['sucursal'];

                        $finClaves = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$clave' ");
                        $resultClave = mysqli_num_rows($finClaves);

                        $cancelar = mysqli_query($MySQLi, "UPDATE soporte_claves SET estado=4, motivo='$motivo' WHERE idClave='$idClave' ");
                        if ($resultClave == 1) {
                            $findSoporte = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE clave_soporte='$clave'");
                            $dataSoporte = mysqli_fetch_assoc($findSoporte);
                            $idSoporte = $dataSoporte['idSoporte'];
                            mysqli_query($MySQLi, "UPDATE soporte_sucursales SET estado=4 WHERE idSoporte='$idSoporte' ");
                        }
                        ordenIndividualCancelada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'CancelarOrdenReparacion':
                    if (isset($_SESSION['idUser'])) {
                        $idSoporte = $_POST['idSoporte'];
                        $motivo = $_POST['motivo'];
                        $cancelar = mysqli_query($MySQLi, "UPDATE soporte SET estado=4, motivo='$motivo' WHERE idSoporte='$idSoporte' ");
                        $Q_clave = mysqli_query($MySQLi, "SELECT clave_soporte FROM soporte WHERE idSoporte='$idSoporte' ");
                        $dataClave = mysqli_fetch_assoc($Q_clave);
                        $claveSoport = $dataClave['clave_soporte'];
                        $cancelClave = mysqli_query($MySQLi, "UPDATE SET estado=4 WHERE clave='$claveSopport' ");
                        ordenTotalCancelada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'IngresaCostosReparacion':
                    if (isset($_SESSION['idUser'])) {
                        $sucursal = $_POST['sucursal'];
                        $idSucursal = $_POST['idSucursal'];
                        $clave = $_POST['clave'];
                        //estos son array
                        $Costos = isset($_POST['costo']) ? $_POST['costo'] : array();
                        $idClaves = isset($_POST['idClave']) ? $_POST['idClave'] : array();
                        $Realizar = isset($_POST['realizar']) ? $_POST['realizar'] : array();
                        /********************************/
                        $cantIDS = count($idClaves);
                        for ($i = 0; $i < $cantIDS; $i++) {
                            $idClave = $idClaves[$i];
                            $costo = $Costos[$i];
                            $realizar = $Realizar[$i];
                            mysqli_query($MySQLi, "UPDATE soporte_claves SET costo='$costo', estado=1, realizar='$realizar' WHERE idClave='$idClave' AND sucursal='$sucursal' AND idSucursal='$idSucursal' ");
                        }
                        $finClave = mysqli_query($MySQLi, "SELECT clave FROM soporte_claves WHERE idClave='$idClave' ");
                        $dataClave = mysqli_fetch_assoc($finClave);
                        $clave = $dataClave['clave'];
                        mysqli_query($MySQLi, "UPDATE soporte_sucursales SET estado=1 WHERE clave_soporte='$clave' AND idSucursal='$idSucursal' ");
                        /*if ($sucursal=='Cochabamba') {
            mysqli_query($MySQLi,"UPDATE soporte_cba SET estado=1 WHERE clave_soporte='$clave' ");
            }else{
            mysqli_query($MySQLi,"UPDATE soporte_stc SET estado=1 WHERE clave_soporte='$clave' ");
            }*/
                        costosIngresados();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'EntregarOrdendeEquipo':
                    if (isset($_SESSION['idUser'])) {
                        $clave = $_POST['clave'];
                        $idUser = $_POST['idUser'];
                        $descripc = $_POST['descripcion'];
                        $sucursal = $_POST['sucursal'];

                        $Q_Claves = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$clave' AND estado=2 ");


                        $fecha_nota_entrega_yuli = [];
                        $nota_entrega_venta_maquina = [];
                        $nombre_maquinas = [];

                        $garantias_repuestos = [];
                        $garantias_mano = [];

                        $repuestos_nombres = [];
                        $repuestos_precio_lista = [];
                        $repuestos_cantidad = [];
                        $repuestos_precio_venta = [];

                        $insumo_externo = [];

                        $servicio_externo = [];
                        $otros_gastos = [];

                        $precio_mano_obra = [];
                        $costo_adicional = [];

                        (float)$total_cobrar_bs = 0;

                        $descripcion_reparacion = [];

                        while ($data = mysqli_fetch_assoc($Q_Claves)) {
                            $idClave = $data['idClave'];
                            mysqli_query($MySQLi, "UPDATE soporte_claves SET estado=3 WHERE idClave='$idClave'") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

                            $fecha_nota_entrega_yuli[] = $data['fechaCompra'];
                            $nota_entrega_venta_maquina[] = $data['notaEntrega'];
                            $nombre_maquinas[] = $data['equipo'];

                            $garantias_repuestos[] = $data['garantia_vigente_repuesto'];
                            $garantias_mano[] = $data['garantia_vigente_mano'];

                            $descripcion_reparacion[] = "Problema:" . $data['problema'] . "/ Trabajo a Realizar:" . $data['realizar'] . "/ Trabajo Realizado:" . $data['trabajoRealizado'];

                            //calculando total_cobrar_bs
                            $total_cobrar_bs += $data['costo'];
                            $total_cobrar_bs += $data['costoAdicional'];

                            $q_soporte_repuestos = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='repuesto_sistema'");
                            $array1 = [];
                            $array2 = [];
                            $array3 = [];
                            $array4 = [];
                            while ($d_soporte_repuestos = mysqli_fetch_assoc($q_soporte_repuestos)) {
                                $array1[] = $d_soporte_repuestos['nombre_repuesto'];
                                $array2[] = (float)$d_soporte_repuestos['precioVenta'];
                                $array3[] = $d_soporte_repuestos['cantidad'];
                                $array4[] = (float)$d_soporte_repuestos['precioEspecial'];

                                $total_cobrar_bs += ((float)$d_soporte_repuestos['precioEspecial'] * (int)$d_soporte_repuestos['cantidad']);
                            }
                            $repuestos_nombres[] = $array1;
                            $repuestos_precio_lista[] = $array2;
                            $repuestos_cantidad[] = $array3;
                            $repuestos_precio_venta[] = $array4;


                            //insumo externo
                            $q_soporte_insumos = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='insumo_externo'");
                            $array5 = [];
                            while ($d_soporte_insumos = mysqli_fetch_assoc($q_soporte_insumos)) {
                                $array5[] = ((float)$d_soporte_insumos['precioVenta'] * (int)$d_soporte_insumos['cantidad']);

                                $total_cobrar_bs += ((float)$d_soporte_insumos['precioVenta'] * (int)$d_soporte_insumos['cantidad']);
                            }
                            $insumo_externo[] = $array5;

                            //servicio externo
                            $q_servicio_externo = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='servicio_externo'");
                            $array6 = [];
                            while ($d_servicio_externo = mysqli_fetch_assoc($q_servicio_externo)) {
                                $array6[] = (float)$d_servicio_externo['precioVenta'] * (int)$d_servicio_externo['cantidad'];

                                $total_cobrar_bs += ((float)$d_servicio_externo['precioVenta'] * (int)$d_servicio_externo['cantidad']);
                            }
                            $servicio_externo[] = $array6;

                            //otros gastos
                            $q_otros_gastos = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='otros_gastos'");
                            $array7 = [];
                            while ($d_otros_gastos = mysqli_fetch_assoc($q_otros_gastos)) {
                                $array7[] = (float)$d_otros_gastos['precioVenta'] * (int)$d_otros_gastos['cantidad'];

                                $total_cobrar_bs += ((float)$d_otros_gastos['precioVenta'] * (int)$d_otros_gastos['cantidad']);
                            }
                            $otros_gastos[] = $array7;


                            $mano_obra = ($data['costo'] == '' || $data['costo'] == null) ? 0 : $data['costo'];
                            $precio_mano_obra[] = (float)$mano_obra;

                            $costo_adi = ($data['costoAdicional'] == '' || $data['costoAdicional'] == null) ? 0 : $data['costoAdicional'];
                            $costo_adicional[] = (float)$costo_adi;
                        }
                        $idUser = $_SESSION['idUser'];
                        mysqli_query($MySQLi, "UPDATE soporte_sucursales SET estado=3, idUser_entrego='$idUser', fechaEntrega='$fecha', observaciones='$descripc' WHERE clave_soporte='$clave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        equipoEntregado();

                        //marcando como venta
                        //soporte Sucursal
                        $soporte_sucursal_query = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE clave_soporte='$clave' AND estado=3 ");
                        $data_soporte_sucursal_query = mysqli_fetch_assoc($soporte_sucursal_query);

                        $fecha_completado = $fecha; //soporte sucursales
                        $fecha_recepcion = $data_soporte_sucursal_query['fechaRegistro']; //soporte sucursales
                        $fecha_nota_entrega_yuli = json_encode($fecha_nota_entrega_yuli, JSON_UNESCAPED_UNICODE);
                        $nro_servicio_recepcion = $data_soporte_sucursal_query['idSoporte']; //soporte sucursales
                        $nota_entrega_venta_maquina = json_encode($nota_entrega_venta_maquina, JSON_UNESCAPED_UNICODE);
                        $nro_factura = 0; //de la emision vendra---------------
                        $nombre_cliente = $data_soporte_sucursal_query['nombreCliente'];
                        $nit_cliente = 0; //de la emision vendra
                        $nombre_maquinas = json_encode($nombre_maquinas, JSON_UNESCAPED_UNICODE); //soporte Claves

                        $garantias_repuestos = json_encode($garantias_repuestos, JSON_UNESCAPED_UNICODE); //soporte Claves
                        $garantias_mano = json_encode($garantias_mano, JSON_UNESCAPED_UNICODE); //soporte Claves

                        $repuestos_nombres = json_encode($repuestos_nombres, JSON_UNESCAPED_UNICODE); //soporte Claves
                        $repuestos_precio_lista = json_encode($repuestos_precio_lista, JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                        $repuestos_cantidad = json_encode($repuestos_cantidad, JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                        $repuestos_precio_venta = json_encode($repuestos_precio_venta, JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                        $insumo_externo = json_encode($insumo_externo, JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos

                        $servicio_externo = json_encode($servicio_externo, JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos
                        $otros_gastos = json_encode($otros_gastos, JSON_UNESCAPED_UNICODE); //soporte_claves_repuestos

                        $precio_mano_obra = json_encode($precio_mano_obra, JSON_UNESCAPED_UNICODE); //soporte claves costo
                        $costo_adicional = json_encode($costo_adicional, JSON_UNESCAPED_UNICODE); //soporte claves costo
                        $total_cobrar_bs = (float)$total_cobrar_bs; //sumar todo los equipos y sus repuestos y insumos

                        $q_precio_dolar = mysqli_query($MySQLi, "SELECT * FROM `preciodolar`");
                        $d_precio_dolar = mysqli_fetch_assoc($q_precio_dolar);
                        $precio_dolar = (float)$d_precio_dolar['precio'];
                        $total_cobrar_usd = (float)$total_cobrar_bs / $precio_dolar;

                        $importe_facturado = 0; //de la emision vendra---------------
                        $id_user = $data_soporte_sucursal_query['idUser'];
                        $idUser = $_SESSION['idUser'];
                        $id_user_entrego = $idUser;
                        $descripcion_reparacion = json_encode($descripcion_reparacion, JSON_UNESCAPED_UNICODE); //soporte Claves
                        //sucursal id
                        $idUser = $_SESSION['idUser'];
                        $q_id_sucursal = mysqli_query($MySQLi, "SELECT idTienda FROM usuarios WHERE idUser='$idUser'");
                        $d_id_sucursal = mysqli_fetch_assoc($q_id_sucursal);
                        $id_sucursal = $d_id_sucursal['idTienda'];
                        $idCotizacion = 0;
                        $idSoporte = $data_soporte_sucursal_query['idSoporte'];;
                        $clave_soporte = $clave;
                        $estado = 1;

 
                            mysqli_query($MySQLi,"delete from soporte_ventas where idSoporte = $idSoporte");

                        mysqli_query(
                            $MySQLi,
                            "INSERT INTO `soporte_ventas`( `fecha_completado`, `fecha_recepcion`,
              `fecha_nota_entrega_yuli`, `nro_servicio_recepcion`,
               `nota_entrega_venta_maquina`, `nro_factura`,
                `nombre_cliente`, `nit_cliente`,
                 `nombre_maquinas`, `garantias_repuestos`,`garantias_mano`,`repuestos_nombres`,
                  `repuestos_precio_lista`, `repuestos_cantidad`,
                   `repuestos_precio_venta`, `insumo_externo`,
                   `servicio_externo`, `otros_gastos`,
                    `precio_mano_obra`, `costo_adicional`, `total_cobrar_bs`, `precio_dolar`,
                     `total_cobrar_usd`, `importe_facturado`,
                      `id_user`, `id_user_entrego`,
                       `descripcion_reparacion`, `id_sucursal`, `idCotizacion`, `idSoporte`,
                        `clave_soporte`, `estado`) VALUES ('$fecha_completado','$fecha_recepcion',
                        '$fecha_nota_entrega_yuli','$nro_servicio_recepcion',
                        '$nota_entrega_venta_maquina','$nro_factura',
                        '$nombre_cliente','$nit_cliente',
                        '$nombre_maquinas','$garantias_repuestos','$garantias_mano','$repuestos_nombres',
                        '$repuestos_precio_lista','$repuestos_cantidad',
                        '$repuestos_precio_venta','$insumo_externo',
                        '$servicio_externo','$otros_gastos',
                        '$precio_mano_obra','$costo_adicional','$total_cobrar_bs', '$precio_dolar',
                        '$total_cobrar_usd','$importe_facturado',
                        '$id_user','$id_user_entrego',
                        '$descripcion_reparacion','$id_sucursal', '$idCotizacion', '$idSoporte',
                        '$clave_soporte','$estado')"
                        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'RestaurarOredenSoporte':
                    if (isset($_SESSION['idUser'])) {
                        $idClave = $_POST['idClave'];
                        //Verificamos cuantas claves hay
                        $finClaves = mysqli_query($MySQLi, "SELECT clave FROM soporte_claves WHERE idClave='$idClave' ");
                        $dataClave = mysqli_fetch_assoc($finClaves);
                        $estaClave = $dataClave['clave'];
                        $Q_Claves = mysqli_query($MySQLi, "SELECT clave,sucursal FROM soporte_claves WHERE clave='$estaClave' ");
                        $resultClave = mysqli_num_rows($Q_Claves);
                        $cancelar = mysqli_query($MySQLi, "UPDATE soporte_claves SET estado=0, motivo='' WHERE idClave='$idClave' ");
                        if ($resultClave == 1) {
                            $dataClaves = mysqli_fetch_assoc($Q_Claves);
                            $sucursal = $dataClaves['sucursal'];
                            // if ($sucursal == 'Cochabamba') {
                            //     $dataBase = "soporte_cba";
                            // } else {
                            //     $dataBase = "soporte_stc";
                            // }
                            mysqli_query($MySQLi, "UPDATE soporte_sucursales SET estado=0 WHERE clave_soporte='$estaClave'  ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        }

                        // $Q_clave        = mysqli_query($MySQLi,"SELECT clave_soporte FROM soporte WHERE idSoporte='$idSoporte' ");
                        // $dataClave     = mysqli_fetch_assoc($Q_clave);
                        // $claveSoport= $dataClave['clave_soporte'];
                        // $cancelClave= mysqli_query($MySQLi,"UPDATE SET estado=0 WHERE clave='$claveSopport' ");
                        ordenRestaurada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'ActualizaDatosEquipoSoporte':
                    if (isset($_SESSION['idUser'])) {
                        $sucursal = $_POST['sucursal'];
                        $idClave = $_POST['idClave'];
                        $equipo = $_POST['equipo'];
                        $marca = $_POST['marca'];
                        $modelo = $_POST['modelo'];
                        $serie = $_POST['serie'];
                        $problema = $_POST['problema'];
                        $observaciones = $_POST['observaciones'];
                        $garantia = $_POST['garantia'];
                        $fechaCompra = $_POST['fechaCompra'];
                        $numeroFactura = $_POST['numeroFactura'];
                        /*    Este caso, no necesita el dato de la sucursal    */
                        if ($garantia == 'si') {
                            $updateClave = mysqli_query($MySQLi, "UPDATE soporte_claves SET equipo='$equipo', marca='$marca', modelo='$modelo', serie='$serie', problema='$problema', observaciones='$observaciones', garantia='$garantia', fechaCompra='$fechaCompra', numFactura='$numeroFactura' WHERE idClave='$idClave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        } else {
                            $updateClave = mysqli_query($MySQLi, "UPDATE soporte_claves SET equipo='$equipo', marca='$marca', modelo='$modelo', serie='$serie', problema='$problema', observaciones='$observaciones', garantia='$garantia' WHERE idClave='$idClave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        }
                        productoSoporteActualizado();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'borrarEquipo_soporteClaves':
                    if (isset($_SESSION['idUser'])) {
                        $idClave = $_POST['idClave'];
                        $delServicio = mysqli_query($MySQLi, "DELETE FROM soporte_claves WHERE idClave='$idClave' ");
                        equipoBorrado_soporteClave();
                    } else {
                        expirado($MySQLi);
                    }
                    break;

                case 'BorrarServicio_clave':
                    if (isset($_SESSION['idUser'])) {
                        $idClave = $_POST['idClave'];
                        $Q_Clave = mysqli_query($MySQLi, "SELECT clave FROM soporte_claves WHERE idClave='$idClave' ");
                        $dataClave = mysqli_fetch_assoc($Q_Clave);
                        $Clave = $dataClave['clave'];
                        $delClave = mysqli_query($MySQLi, "DELETE FROM soporte_claves WHERE idClave='$idClave' "); ?>
            <table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
                <thead>
                    <tr>
                        <th class="text-center">Equipo</th>
                        <th class="text-center">Marca</th>
                        <th class="text-center">Modelo</th>
                        <th class="text-center">Serie</th>
                        <th class="text-center">Garantia</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody><?php
                        $Q_Service = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$Clave' ");
                        $resultQry = mysqli_num_rows($Q_Service);
                        if ($resultQry > 0) {
                            while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) { ?>
                            <tr>
                                <td><?= $dataRegistros['equipo'] ?></td>
                                <td><?= $dataRegistros['marca'] ?></td>
                                <td><?= $dataRegistros['modelo'] ?></td>
                                <td><?= $dataRegistros['serie'] ?></td><?php
                                                                        if ($dataRegistros['garantia'] == 0) {
                                                                            echo '<td class="text-center">No</td>';
                                                                        } else {
                                                                            echo '<td class="text-center">Sí</td>';
                                                                        } ?>
                                <td class="text-center">
                                    <button class="btn btn-success btn-sm btn-icon rounded-circle openModalEditServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar Servicio (<?= $dataRegistros['idClave'] ?>)" id="<?= $dataRegistros['idClave'] ?>"><i class="fal fa-edit"></i></button>&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                if ($resultServ > 1) { ?>
                                    <button class="btn btn-danger btn-sm btn-icon rounded-circle deleteServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Eliminar servicio (<?= $dataRegistros['idClave'] ?>)" id="<?= $dataRegistros['idClave'] ?>"><i class="fal fa-trash-alt"></i></button><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                } ?>
                                </td>
                            </tr><?php }
                            } else {
                                echo '<tr>
									<td colspan="6" class="text-center text-danger" style="letter-spacing: 1px">NO HAY SERVICIOS QUE MOSTRAR</td></tr>';
                            } ?>
                </tbody>
            </table>
        <?php
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'CambiarEstadoAComprada':
                    if (isset($_SESSION['idUser'])) {
                        $idCotizacion = $_POST['idCotizacion'];
                        $Q_Cotiza = mysqli_query($MySQLi, "UPDATE cotizaciones SET estado=2 WHERE id='$idCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__); ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cotización actualizada correctamente',
                    showConfirmButton: false,
                })
                setTimeout(function() {
                    location.replace('?root=compradas');
                }, 2500)
            </script>
        <?php
                    } else {
                        expirado($MySQLi);
                    }
                    break;

                case 'CambiarEstadoA1':
                    if (isset($_SESSION['idUser'])) {
                        $idCotizacion = $_POST['idCotizacion'];
                        $Q_Cotiza = mysqli_query($MySQLi, "UPDATE cotizaciones SET estado=1 WHERE id='$idCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__); ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cotización actualizada correctamente',
                    showConfirmButton: false,
                })
                setTimeout(function() {
                    location.replace('?root=entregadas');
                }, 2500)
            </script>
        <?php
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'cambiaraEntregado':
                    if (isset($_SESSION['idUser'])) {
                        $idServicio = $_POST['idServicio'];
                        $idUser = $_SESSION['idUser'];
                        $cambiaSt = mysqli_query($MySQLi, "UPDATE servicio SET estado=2, idue='$idUser', fechae='$fecha' WHERE id='$idServicio' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__); ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Se cambió a entregado',
                    showConfirmButton: false,
                })
                setTimeout(function() {
                    location.replace('?root=entregados');
                }, 2500)
            </script>
        <?php
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'cancelarReparacion':
                    if (isset($_SESSION['idUser'])) {
                        $idServicio = $_POST['idServicio'];
                        $updServicio = mysqli_query($MySQLi, "UPDATE soporte SET estado=3 WHERE idSoporte='$idServicio' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__); ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Reparación cancelada',
                    showConfirmButton: false,
                })
                setTimeout(function() {
                    location.replace('?root=cancelados');
                }, 2500)
            </script><?php
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'actualizarfichaServicio':
                    if (isset($_SESSION['idUser'])) {
                        $idServicio = $_POST['idServicio'];
                        $nombreCliente = $_POST['nombre'];
                        $telCliente = $_POST['telefono'];
                        $cellCliente = $_POST['celular'];
                        $maquinaClient = $_POST['maquina'];
                        $marcaClient = $_POST['marca'];
                        $modeloClient = $_POST['modelo'];
                        $industrClient = $_POST['serie'];
                        $observaciones = $_POST['observaciones'];
                        $trabajo = $_POST['trabajo'];
                        $updateServi = mysqli_query($MySQLi, "UPDATE servicio SET cliente='$nombreCliente', telefono='$telCliente', celular='$cellCliente', maquina='$maquinaClient', marca='$marcaClient', modelo='$modeloClient', serie='$industrClient', obsr='$observaciones', realizar='$trabajo' WHERE id='$idServicio' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        fichaServicioActualizada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'actualizarReparaciones':
                    if (isset($_SESSION['idUser'])) {
                        $idServicio = $_POST['idServicio'];
                        $trabajo = $_POST['realizado'];
                        $updateServi = mysqli_query($MySQLi, "UPDATE servicio SET realizado='$trabajo' WHERE id='$idServicio' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        fichaServicioActualizada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'IngresarReparaciones':
                    if (isset($_SESSION['idUser'])) {
                        $idServicio = $_POST['idServicio'];
                        $trabajo = $_POST['realizado'];
                        $idUser = $_SESSION['idUser'];
                        $updateTrabajo = mysqli_query($MySQLi, "UPDATE servicio SET estado=1, realizado='$trabajo', fechareparacion='$fecha', idureparo='$idUser'  WHERE id='$idServicio' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                        reparacionGuardada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;

                case 'registrarNuevoServicio':
                    if (isset($_SESSION['idUser'])) {
                        $idUser = $_SESSION['idUser'];
                        $miCiudad = $_POST['sucursal'];
                        $nombre = $_POST['nombre'];
                        $telefono = $_POST['telefono'];
                        $celular = $_POST['celular'];
                        $equipo = $_POST['maquina'];
                        $marca = $_POST['marca'];
                        $modelo = $_POST['modelo'];
                        $serie = $_POST['serie'];
                        $observ = $_POST['observaciones'];
                        $trabajo = $_POST['trabajo'];
                        $maquina = $equipo . " " . $marca . " " . $modelo;
                        $insertFicha = mysqli_query($MySQLi, "INSERT INTO servicio (idur, fechar, cliente, telefono, celular, maquina, marca, modelo, serie, obsr, realizar, cr, estado) VALUES ('$idUser', '$fecha', '$nombre', '$telefono', '$celular', '$maquina', '$marca', '$modelo', '$serie', '$observ', '$trabajo', '$miCiudad',0) ") or die(mysqli_error($MySQLi) . "<br>Error ne la linea: " . __LINE__);
                        fichaRegistroGuarada();
                    } else {
                        expirado($MySQLi);
                    }
                    break;
                case 'deleteFichaTecnica':
                    if (isset($_SESSION['idUser'])) {
                        if ($_SESSION['Tipo'] == 'A') {
                            $idServicio = $_POST['idServicio'];
                            $delServicio = mysqli_query($MySQLi, "DELETE FROM servicio WHERE id='$idServicio' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                            fichaTecnicaBorrada();
                        } else {
                            sinAutorizacion($MySQLi);
                        }
                    } else {
                        expirado($MySQLi);
                    }
                    break;
    ################ ACTUALIZACION ABRIL 2025 #####################
    case 'updateDolar':
        if (isset($_SESSION['idUser'])) {
            if ($_SESSION['idRango'] >= 2) {
                $precio_dolar = $_POST['precio'];
                $query = "UPDATE preciodolar SET precio = '$precio_dolar'";
                $response = mysqli_query($MySQLi, $query) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);   
            } else {
                sinAutorizacion($MySQLi);
            }
            
        } else {
            expirado($MySQLi);
        }
        break;
    
    default:
        alert_peticionDesconocida();
        break;
            }
                        ?>