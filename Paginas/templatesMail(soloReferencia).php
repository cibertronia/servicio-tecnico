<?php
    $idUser =   $_SESSION['uid'];
    $query  =   mysqli_query($MySQLi,"SELECT * FROM Admins WHERE idUser='$idUser'");
    $User   =   mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Plantillas Email</title>
        <?php include 'php/links.php'; ?>
    </head>
    <body class="mod-bg-1 ">
        <?php include 'php/functionTheme.php'; ?>
        <!-- BEGIN Page Wrapper -->
        <div class="page-wrapper">
            <div class="page-inner">
                <?php include 'php/leftMenu.php'; ?>
                <div class="page-content-wrapper">
                    <?php include 'php/topMenu.php'; ?>
                    <!-- ========================================================================
                    =====================INICIA CONTENIDO PRINCIPAL =============================
                    ========================================================================= -->
                    
                    <main id="js-page-content" role="main" class="page-content"><div class="respuesta"></div>
                        <?php //include 'php/Tarjetas.php'; ?>


                        <div class="row d-none" id="editorPl">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Editor <span class="fw-300"><i>HTML</i>&nbsp;&nbsp;&nbsp;&nbsp;<button title="Ocultar esta sección" class="btn btn-xs btn-primary ocultarSection" style="letter-spacing: 1px"> OCULTAR SECCION</button></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <!-- <div class="panel-tag">
                                                This is the default <code>summernote</code> example, with full toolbar buttons. We have also added a custom auto save script for localStorage which uses <code>onChange</code> and <code>onInit</code> hooks to load and save to <code>localStorage</code>
                                            </div> -->
                                            <form id="save_template">
                                                <div class="row text-center mb-2">
                                                    <div class="col-md-3"><input type="hidden" name="action" value="saveTemplEmail"></div>
                                                    <div class="col-md-6">
                                                        <label for="Titulo">Nombre de la Plantilla HML</label>
                                                        <input type="text" name="Titulo" id="Titulo" class="form-control" placeholder="Ingrese el nombre de su plantilla" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea class="js-summernote form-control contPlantilla" name="Contenido" id="saveToLocal" required></textarea>
                                                    </div>    
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- <div class="mt-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="autoSave" checked="checked">
                                                                <label class="custom-control-label" for="autoSave">Auto guardar cambios a la memoria local <span class="fw-300">(cada 3 segundos)</span></label>
                                                            </div>
                                                        </div>   -->
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <button class="btn btn-xs btn-info mt-3">Guardar Plantilla</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="updPl">
                            <div class="col-xl-12">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Editor <span class="fw-300"><i>HTML</i>&nbsp;&nbsp;&nbsp;&nbsp;<button title="Ocultar esta sección" class="btn btn-xs btn-primary hideSection" style="letter-spacing: 1px"> OCULTAR SECCION</button></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <!-- <div class="panel-tag">
                                                This is the default <code>summernote</code> example, with full toolbar buttons. We have also added a custom auto save script for localStorage which uses <code>onChange</code> and <code>onInit</code> hooks to load and save to <code>localStorage</code>
                                            </div> -->
                                            <form id="uppTempl">
                                                <div class="row text-center mb-2">
                                                    <div class="col-md-3"><input type="hidden" name="action" value="update_Template"></div>
                                                    <div class="col-md-6"><input type="hidden" name="idPlantilla" id="idPlantilla">
                                                        <label for="Titulo_">Nombre de la Plantilla HML</label>
                                                        <input type="text" name="Titulo" id="Titulo_" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea class="js-summernote form-control" name="Contenido" id="Contenido"></textarea>
                                                    </div>    
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- <div class="mt-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="autoSave" checked="checked">
                                                                <label class="custom-control-label" for="autoSave">Auto guardar cambios a la memoria local <span class="fw-300">(cada 3 segundos)</span></label>
                                                            </div>
                                                        </div>   -->
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <button class="btn btn-xs btn-info mt-3">Actualizar Plantilla</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-md-7">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Mis  <span class="fw-300"><i>Plantillas Email</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <button title="Agregar Plantilla Email" class="btn btn-xs btn-primary addplantilla">AGREGAR&nbsp;&nbsp;&nbsp;<i class="fal fa-code"></i>&nbsp;&nbsp;&nbsp;PLANTILLA</button>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <!-- datatable start -->
                                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">N&ordm;</th>
                                                        <th class="text-center">Nombre</th>
                                                        <th class="text-center">Contenido</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $Num        =  1;
                                                        $queryPl    =   mysqli_query($MySQLi,"SELECT * FROM Plantilla_Email ORDER BY Nombre ASC");
                                                        while ($dataP =   mysqli_fetch_assoc($queryPl)) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $Num; ?></td>
                                                        <td class="text-center"><?php echo $dataP['Nombre'] ?></td>
                                                        <td class="text-center">
                                                            <button title="Ver plantilla" id="<?php echo $dataP['id'] ?>" class="btn btn-sm btn-primary seePlant" data-toggle="modal" data-target="#updatePlantillaEmail"><i class="fal fa-eye"></i></button>&nbsp;&nbsp;
                                                            <button title="Editar plantilla" id="<?php echo $dataP['id'] ?>" class="btn btn-sm btn-info editPlanti"><i class="fal fa-edit"></i></button>&nbsp;&nbsp;
                                                            <button title="BorrarPlantilla" class="btn btn-sm btn-danger delPlantilla" id="<?php echo $dataP['id'] ?>"><i class="fal fa-trash-alt"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php $Num++;} ?>    
                                                </tbody>
                                                <!-- <tfoot>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">Pais</th>
                                                        <th class="text-center">Nombre</th>
                                                        <th class="text-center">Correo</th>
                                                        <th class="text-center">Telefono</th>
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                </tfoot> -->
                                            </table>
                                            <!-- datatable end -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div id="panel-1" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            <span class="fw-300" style="letter-spacing: 1px"><i>INDICACIONES</i></span>                                            
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="alert alert-danger" role="alert">
                                                <!-- <strong>Ciudado!</strong><br> -->                                                
                                                Para crear una plantilla Email, solo debe tomar en cuenta las palabras que se sustituyen:<br><br>
                                                (POR AHORA)<br>
                                                <span style="color: #000">
                                                {Cliente}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sustituye el nombre completo del Cliente<br>
                                                {Empresa}&nbsp;&nbsp;&nbsp;Sustituye el nombre completo de la empresa.
                                                {Web}&nbsp;&nbsp;&nbsp;Sustituye el sitio web de la empresa.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>


                    <!-- ========================================================================
                    ====================TERMINA CONTENIDO PRINCIPAL =============================
                    ========================================================================= -->
                    
                    <!-- Se activa solo en dispositivos mobiles -->
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
                    <?php include 'php/footer.php'; ?>
                </div>
            </div>
        </div>
        <?php
            include 'php/bottonMenu.php';
            include 'php/settingPage.php';
            include 'php/Modals/modal_addPlantillaSMS.php';
            include 'php/scripts.php';
            include 'php/Modals/modal_updatePlantillaEmail.php';
            //include 'php/Modals/modal_updateCliente.php';
            mysqli_close($MySQLi);
        ?>
    </body>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#uppTempl").submit(function(){
                $.ajax({
                    url: 'puerta_ajax.php',
                    type: 'POST',
                    data: $(uppTempl).serialize(),
                })
                .done(function(data) {
                    $(".respuesta").html(data);
                })
                return false;
            });
            $(document).on('click', '.editPlanti', function(event) {
                event.preventDefault();
                $("#updPl").removeClass('d-none');
                $("#editorPl").addClass('d-none');
                var idPlantilla = $(this).attr("id");
                $.ajax({
                    url: 'Config/getDataPlantilla_Email.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: idPlantilla},
                    success:function(data){
                        $("#idPlantilla").val(data.id);
                        $("#Titulo_").val(data.Nombre);
                        $("#Contenido").summernote('code', data.Contenido);
                    }
                })
                
            });
            $(document).on('click', '.delPlantilla', function(event) {
                event.preventDefault();
                var idPlantilla = $(this).attr("id");
                $.ajax({
                    url: 'puerta_ajax.php',
                    type: 'POST',
                    dataType: 'html',
                    data: "action=borrarPlantilla&id="+idPlantilla,
                })
                .done(function(data) {
                    $(".respuesta").html(data);
                })
                return false;
            });
            $(document).on('click', '.addplantilla', function(event) {
                event.preventDefault();
                $("#editorPl").removeClass('d-none');
                $("#updPl").addClass('d-none');
            });
            $(document).on('click', '.ocultarSection', function(event) {
                event.preventDefault();
               $("#editorPl").addClass('d-none');
            });
            $(document).on('click', '.hideSection', function(event) {
                event.preventDefault();
               $("#updPl").addClass('d-none');
            });
            $(document).on('click', '.seePlant', function(event) {
                event.preventDefault();
                var idPlantilla = $(this).attr("id");
                $.ajax({
                    url: 'Config/getDataPlantilla_Email.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: idPlantilla},
                    success:function(data){
                        $(".plMail").html(data.Contenido);
                    }
                })
            });
            $("#save_template").submit(function() {
                $.ajax({
                    url: 'puerta_ajax.php',
                    type: 'POST',
                    dataType: 'html',
                    data: $(save_template).serialize(),
                })
                .done(function(data) {
                    $(".respuesta").html(data);
                })
                return false;
            });
        });
    </script>
    <script>
        var autoSave = $('#autoSave');
        var interval;
        var timer = function() {
            interval = setInterval(function() {
                //start slide...
                if (autoSave.prop('checked'))
                    saveToLocal();

                clearInterval(interval);
            }, 3000);
        };

        //save
        var saveToLocal = function() {
            localStorage.setItem('summernoteData', $('#saveToLocal').summernote("code"));
            console.log("saved");
        }

        //delete 
        var removeFromLocal = function() {
            localStorage.removeItem("summernoteData");
            $('#saveToLocal').summernote('reset');
        }

        $(document).ready(function() {
            //init default
            $('.js-summernote').summernote({
                height: 200,
                tabsize: 2,
                placeholder: "Escriba aquí...",
                dialogsFade: true,
                toolbar: [
                    ['table'],
                    ['hr'],
                    ['style', ['style']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    //restore from localStorage
                    onInit: function(e) {
                        $('.js-summernote').summernote("code", localStorage.getItem("summernoteData"));
                    },
                    onChange: function(contents, $editable) {
                        clearInterval(interval);
                        timer();
                    }
                }
            });            
        });

    </script>
</html>