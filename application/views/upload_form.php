<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url() ?>res/uploadify.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="<?php echo site_url() ?>res/jquery.uploadify-3.1.min.js"></script>
  <title></title>
</head>
<body>

    <div class="uploadify-queue" id="file-queue"></div>
    <input type="file" name="userfile" id="upload_btn" />

    <script type='text/javascript' >
    $(function() {
     $('#upload_btn').uploadify({
      'debug'   : false,

      'swf'   : '<?php echo site_url() ?>res/uploadify.swf',
      'uploader'  : '<?php echo site_url('uploadtest/uploadify')?>',
      'cancelImage' : '<?php echo site_url() ?>res/uploadify-cancel.png',
      'queueID'  : 'file-queue',
      'buttonClass'  : 'button',
      'buttonText' : "Upload Files",
      'multi'   : true,
      'auto'   : true,

      'fileTypeExts' : '*.jpg; *.png; *.gif; *.PNG; *.JPG; *.GIF;',
      'fileTypeDesc' : 'Image Files',

      'formData'  : {'sessdata' : '<?php echo $this->session->get_encrypted_sessdata()?>'},
      'method'  : 'post',
      'fileObjName' : 'userfile',

      'queueSizeLimit': 40,
      'simUploadLimit': 2,
      'sizeLimit'  : 10240000
        });
     });
    </script>

</body>
</html>