<div id="subHeader">
    <div id="subHeaderLeft">
        <img src="<?=base_url()
?>template/img/photo_64.png" />
        <h1>Fotos</h1>
    </div>
    <div id="subHeaderRight">
    </div>
</div>
<div class="clr"></div>
<div id="content">
    <?php
    echo form_open_multipart('');
    echo form_upload(Array('name' => 'Filedata', 'id' => 'upload'));
    ?>
    <a href="javascript:$('#upload').uploadifyUpload();" class="button">Enviar foto(s)</a>
    <?
    echo form_close();
    ?>
    <div id="target"></div>
</div>
<script type="text/javascript" charset="utf-8">
    $(function(){
        $("#upload").uploadify({
            uploader:       '<?=base_url()?>includes/js/uploadify/uploadify.swf',
            script:         '<?=base_url()?>includes/js/uploadify/uploadify.php',
            cancelImg:      '<?=base_url()?>includes/js/uploadify/cancel.png',
            folder:         '/cetenco/images',
            buttonText:     'Selecionar',
            scriptAccess:   'always',
            multi:          true,
            'onError': function (a, b, c, d) {
                if (d.status == 404)
                    alert('Não foi possível encontrar o script de upload.');
                else if (d.type === "HTTP")
                    alert('error '+d.type+": "+d.status);
                else if (d.type ==="File Size")
                    alert(c.name+' '+d.type+' Limite: '+Math.round(d.sizeLimit/1024)+'KB');
                else
                    alert('Erro '+d.type+": "+d.text);
            },
            'onComplete': function (event, queueID, fileObj, response, data) {
                //Post response back to controller
                $.post('<?php echo site_url('administracao/fotos/salvar'); ?>',{filearray: response},function(info){
                    $("#target").append(info);  //Add response returned by controller
                });
            }
        });
    });
</script>