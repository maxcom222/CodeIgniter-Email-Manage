<head>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <style type="text/css">
        .imageThumb {
            max-width: 100px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }
        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove:hover {
            background: white;
            color: black;
        }

        .remove_exist {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove_exist:hover {
            background: white;
            color: black;
        }

        /* Center the loader */
        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 80px;
            height: 80px;
            border: 14px solid #93c6ef;
            border-radius: 50%;
            border-top: 14px solid #3498db;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
<div id="loader" style="display: none"></div>
<div class="content-wrapper">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $page_name;?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
                <input type="hidden" id="page_name" value="<?php echo strtolower($page_name);?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="to" class="col-sm-2 control-label">To:</label>

                        <div class="col-sm-10">
                            <input class="form-control" id="to" placeholder="" value="<?php
                            if(strtolower($page_name) == "reply")
                            {
                                if ($user_name != $mail_info->fromAddress)
                                    echo $mail_info->fromAddress;
                                else
                                    echo "";
                            }else{
                                echo "";
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">Subject:</label>

                        <div class="col-sm-10">
                            <input class="form-control" id="subject" placeholder="" value="<?php echo (strtolower($page_name)=="reply"?"Re : ":"").$mail_info->subject;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <!--                            <textarea id="editor1" name="editor1" rows="10" cols="80">-->
                        <!--                                This is my textarea to be replaced with CKEditor.-->
                        <!--                            </textarea>-->
                        <div class="col-sm-10 col-sm-offset-2">
                            <div class="summernote col-sm-12">
                                <?php echo $mail_content;?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <div class="field" align="left" id = "filefield">
                                <div class="file btn btn-file btn-default" id = "fileBt" style="position: relative;  overflow: hidden;">
                                    <i class="fa fa-paperclip"></i> Attachment
                                    <input type="file" id="files" style="position: absolute; opacity: 0;  right: 0;  top: 0;" name="mediafile[]" multiple accept=".*"/>
                                    <input type="hidden" id = 'uploadfilename' value = ''>
                                </div>
                                <div class="file-field" id="fileViewDiv">
                                    <?php
                                    $exist_ids = '';
                                    $exist_names = '';
                                    foreach($mail_attachment as $attach)
                                    {
                                        if ($exist_ids == '')
                                        {
                                            $exist_ids .= $attach->filePath;
                                            $exist_names .= $attach->name;
                                        }else{
                                            $exist_ids .= "#@#" . $attach->filePath;
                                            $exist_names .= "#@#" . $attach->name;
                                        }
                                    ?>
                                        <span id="<?php echo $attach->filePath?>" name="<?php echo $attach->name;?>" class="pip">
                                            <img class="imageThumb" src="<?php echo base_url()?>assets/images/download.png" width="100px" height="100px"
                                                 title="<?php echo $attach->name?>">
                                            <br/>
                                            <span class="remove_exist">Remove</span>
                                            <span class="text">
                                                <center><?php echo (strlen($attach->name)>15)?substr($attach->name, 0, 12).'..':$attach->name; ?></center>
                                            </span>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                    <input style="display: none" id="disp_temp">
                                </div>
                                <input type="hidden" id="exist_ids" value="<?php echo $exist_ids;?>" />
                                <input type="hidden" id="exist_names" value="<?php echo $exist_names;?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-sm-12 text-right">
                        <button type="button" id="btnSend" class="btn btn-primary" onclick="sendMail()"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </section>
</div>
<!--<script src="--><?php //echo base_url();?><!--assets/bower_components/ckeditor/ckeditor.js"></script>-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script type="text/javascript">
    var fileObject = {};

    jQuery(document).ready(function(){
        // CKEDITOR.replace('editor1')
        $('.summernote').summernote({
            height: 230,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
        if ($('#page_name').val() == 'reply')
        {
            var markupStr = $('.summernote').summernote('code');
            markupStr = replaceAll(markupStr, '<p>', '<p>&gt;');
            markupStr += "<BR>";
            $('.summernote').summernote('code', markupStr);
            console.log(markupStr);
        }
        $(".remove_exist").click(function () {
            var pId = this.parentNode.id;
            var pName = this.parentNode.name;
            var keytemp = ($("#" + pId).find("img")).attr('title');
            $(this).parent(".pip").remove();
            var exist_ids = $('#exist_ids').val();
            var new_ids = exist_ids.replace(pId, '');
            $('#exist_ids').val(new_ids);
            var exist_names = $('#exist_names').val();
            var new_names = exist_names.replace(pName, '');
            $('#exist_names').val(new_names);
        });
        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function(e) {
                var files = e.target.files;
                var filesLength = files.length;
                var oversizefile = null;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var arrayName = f.name;
                    arrayName = arrayName.replace(".", "_");

                    if(f.size/1024/1024 > 5)
                    {
                        if(oversizefile) oversizefile = oversizefile + ', ' + f.name;
                        else oversizefile = f.name;
                        continue;
                    }

                    else if(Object.keys(fileObject).length < 10) {
                        var keyflag = true;
                        $.each( fileObject, function( key, value) {
                            if(key == arrayName)keyflag = false;
                        });

                        if(keyflag) {
                            fileObject[arrayName] = f;
                            var fileReader = new FileReader();
                            fileReader.file_name = f.name;
                            fileReader.arrayName = arrayName;
                            fileReader.onload = (function (e) {
                                var file = e.target;
                                var file_name = file.file_name;
                                var src = '/assets/images/download.png';
                                if(file_name.search('.gif') > 0 || file_name.search('.jpg') > 0 ||
                                    file_name.search('.jpeg') > 0 || file_name.search('.png') > 0) src = e.target.result;
                                var mediaName = file.mediaName;

                                if(file_name.length > 15)
                                {
                                    file_name = file_name.substring(0,12) + '...';
                                }
                                $("<span id='" + mediaName + "' class=\"pip\">" +
                                    "<img class=\"imageThumb\" src=\"" + src + "\" width=\"100px\" height=\"100px\" title=\"" + file.arrayName + "\"/>" +
                                    "<br/><span class=\"remove\">Remove</span>" +
                                    "<span class=\"text\"><center>" + file_name + "</center></span>" +
                                    "</span>").insertAfter("#disp_temp");
                                $(".remove").click(function () {
                                    var pId = this.parentNode.id;
                                    var keytemp = ($("#" + pId).find("img")).attr('title');
                                    delete fileObject[keytemp];
                                    $(this).parent(".pip").remove();
                                });
                            });
                            fileReader.readAsDataURL(f);
                        }
                    }
                    else {
                        break;
                    }
                }
                if(oversizefile)
                {
                    alert('File size exceeded(more 5Mbyte). \nFileName: ' + oversizefile);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find, 'g'), replace);
    }
    function sendMail(){
        $('#loader').fadeIn(1000);
        $('#btnSend').attr('disabled', true);
        $('#to').attr('disabled', true);
        $('#subject').attr('disabled', true);
        $('.summernote').attr('disabled', true);
        $('.filefield').attr('disabled', true);
        $('.summernote').summernote('disable');

        var subject = $('#subject').val();
        var to = $('#to').val();
        var markupStr = $('.summernote').summernote('code');
        let data = new FormData();
        if(Object.keys(fileObject).length > 0) {
            var num = 0;
            $.each(fileObject, function (key, value) {
                data.append(value.name, value);
                num++;
            });
        }
        data.append('to', to);
        data.append('subject', subject);
        data.append('message', markupStr);
        data.append('exist_ids', $('#exist_ids').val());
        data.append('exist_names', $('#exist_names').val());
        $.ajax({
            url: '<?php echo base_url();?>email/sendmail',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                $('#loader').fadeOut(1000);
                $('#btnSend').removeAttr('disabled');
                $('#to').removeAttr('disabled');
                $('#subject').removeAttr('disabled');
                $('.summernote').removeAttr('disabled');
                $('#filefield').removeAttr('disabled');
                $('.summernote').summernote('enable');
                if (response == "yes")
                    location.href = "<?php echo base_url() ?>email/folderListing?boxname=Sent";
                else
                    alert(response);
            }
        });
    }
</script>