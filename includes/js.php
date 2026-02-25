<script src="assets/js/vendors.bundle.js"></script>
<script src="assets/js/app.bundle.js"></script>
<!-- <script src="assets/js/theme.js"></script> -->
<script src="assets/js/bootstrap-show-password.js"></script>
<script src="assets/js/formplugins/inputmask/inputmask.bundle.js"></script>
<script src="assets/js/datagrid/datatables/datatables.bundle.js"></script>
<script src="assets/js/formplugins/select2/select2.bundle.js"></script>
<script src="assets/plugins/blueimp-file-upload/js/jquery.fileupload.js"></script>
<script src="assets/plugins/blueimp-file-upload/js/jquery.fileupload-process.js"></script>
<script src="assets/plugins/blueimp-file-upload/js/jquery.fileupload-image.js"></script>
<script src="assets/plugins/blueimp-file-upload/js/jquery.fileupload-audio.js"></script>
<script src="assets/plugins/blueimp-file-upload/js/jquery.fileupload-video.js"></script>
<script src="assets/plugins/blueimp-file-upload/js/jquery.fileupload-validate.js"></script>
<script src="assets/plugins/blueimp-file-upload/js/jquery.fileupload-ui.js"></script>
<script src="assets/js/notifications/sweetalert2/sweetalert2.bundle.js"></script>
<script src="assets/js/sweetalert2@10.js"></script>
<script src="assets/js/formplugins/dropzone/dropzone.js"></script>
<script src="assets/switchery/js/switchery.js"></script>
<script src="assets/js/formplugins/summernote/summernote.js"></script>

<script src="assets/plugins/blueimp-file-upload/js/jquery.iframe-transport.js"></script>
<script><?php
  if (isset($_SESSION['idUser'])) { ?>
    function refrescar(){
      var idUser = "<?php echo $idUser ?>";
      $.ajax({
        url: 'includes/consultas.php',
        type: 'POST',
        dataType: 'html',
        data: {funcionRefrescar: idUser},
        success:function(data){
          console.log(data)
        }
      })
    }<?php
  }?>
  //setInterval(function(){ refrescar();},1000);
  setInterval(function(){ refrescar();},1740000);
</script>