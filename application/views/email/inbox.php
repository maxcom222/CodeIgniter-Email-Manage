<style>
    table.dataTable thead tr {
        background-color: #3c8dbc;
    }
    th, td { white-space: nowrap; }

    tr { height: 30px; }

    [style*="--aspect-ratio"] > :first-child {
        background-color: white;
        width: 100%;
    }
    [style*="--aspect-ratio"] > img {
        height: auto;
    }
    @supports (--custom:property) {
        [style*="--aspect-ratio"] {
            position: relative;
        }
        [style*="--aspect-ratio"]::before {
            content: "";
            display: block;
            padding-bottom: calc(100% / (var(--aspect-ratio)));
        }
        [style*="--aspect-ratio"] > :first-child {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
        }
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
<link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class = "col-md-12">
                <div class="box">
                    <div class="box-header">
<!--                        <h3 class="box-title">Inbox</h3>-->
                        <a href="<?php base_url()?>compose" class="btn btn-app">
                            <i class="fa fa-envelope"></i> New
                        </a>
                        <a href="#" disabled="" id="btnreply" class="btn btn-app">
                            <i class="fa fa-mail-reply"></i> Reply
                        </a>
                        <a href="#" disabled="" class="btn btn-app" id="btnforward">
                            <i class="fa fa-mail-forward"></i> Forward
                        </a>
                        <a class="btn btn-app">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="height:430px;">

                        <div class="table-responsive no-padding">
                            <table id="example2" class="table table-hover table-bordered datatable" style="height:330px;display:block;">
                                <thead>
                                    <tr>
                                        <th width="3%" class="mailbox-star text-center"><i class="fa fa-star text-yellow"></i></th>
                                        <th width="50%">Subject</th>
                                        <th width="15%">From</th>
                                        <th width="15%">Date</th>
                                        <th width="10%">Size</th>
                                        <th width="7%" class="text-center">Attach</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($records))
                                {
                                    foreach($records as $record)
                                    {
                                        $style = "font-weight:normal";
                                        $star = " fa-star-o";
                                        if (intval($record['seen']) == 0)
                                        {
                                            $style = "font-weight:bold";
                                            $star = " fa-star";
                                        }
                                        ?>
                                        <tr class="tr_" id="tr_<?php echo $record['uid'] ?>" style="<?php echo $style; ?>">
                                            <td class="mailbox-star text-center"><a href="javascript:mail_view(<?php echo $record['uid'] ?>);"><i id="tr_star_<?php echo $record['uid'] ?>" class="fa <?php echo $star; ?> text-yellow"></i></a></td>
                                            <td onclick="mail_view(<?php echo $record['uid'] ?>)" style="cursor: pointer"><?php echo $record['subject'] ?></td>
                                            <td><?php echo $record['from'] ?></td>
                                            <td><?php echo $record['date'] ?></td>
                                            <td><?php echo $record['size'] ?></td>
                                            <td class="text-center">
                                                <?php if ($record['attachment'] == 1){ ?>
                                                    <i class="fa fa-paperclip"></i>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>

                        </div><!-- /.box-body -->
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
        <div class="box box-primary" id="preview" style="display: none;background-color: white">
            <div id="loader" style="display: none"></div>
            <div class = "row">
                <div class = "col-md-12">
                    <div class="info-box bg-gray">
                        <span class="info-box-icon"><i class="fa fa-user-circle-o"></i></span>
                        <div class="info-box-content">
                            <span class="product-description text-bold" id="subject">Mentions</span><br>
                            <span class="col-md-1" style="min-width: 100px;">From: </span><span class="product-description col-md-9 text-left text-bold" id="from"></span><br>
                            <span class="col-md-1" style="min-width: 100px;">To: </span><span class="product-description col-md-9 text-left text-bold" id="to"></span><br>
                            <span class="col-md-1" style="min-width: 100px;">Date: </span><span class="product-description col-md-9 text-left text-bold" id="date"></span><br>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class = "col-md-8">
                    <div style="--aspect-ratio: 5/1; margin-top: -13px;" id="view_container">
                        <iframe
                                id = "mail_view"
                                src="<?php echo base_url();?>email/getContent?mail_id=0&mailbox=INBOX"
                                width="1600"
                                height="900"
                                frameborder="0"
                        >
                        </iframe>
                    </div>
                </div>
                <div class = "col-md-4">
                    <div class="info-box bg-gray-light" id="attach_container" style="border-width: 0px;">
                        <div class="info-box-content" id="attach_panel" style="margin-left: 0px; margin-top: -13px;">

                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var datatable = $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false,
            "rowHeight": 'auto'
        });
        datatable.column( '3:visible' )
            .order( 'desc' )
            .draw();
    });
    function mail_view(mail_id){
        $('#btnreply').attr('href', '<?php echo base_url();?>email/reply?mail_id='+mail_id+'&boxname=INBOX');
        $('#btnreply').removeAttr('disabled');
        $('#btnforward').attr('href', '<?php echo base_url();?>email/forward?mail_id='+mail_id+'&boxname=INBOX');
        $('#btnforward').removeAttr('disabled');
        $('.tr_').css('background-color', 'white');
        $('#tr_'+mail_id).css('background-color', '#93c6ef');
        $('#tr_'+mail_id).css('font-weight', 'normal');
        $('#tr_star_'+mail_id).attr('class', 'fa fa-star-o text-yellow');
        $('#loader').fadeIn(1000);
        $("#mail_view").attr("src", "<?php echo base_url();?>email/getContent?mail_id="+mail_id+"&mail_box=INBOX");
        $.ajax({
            type: "get",
            url: "<?php echo base_url();?>email/getHeaderInfo",
            data: {
                mail_id: mail_id,
                mail_box: "INBOX"
            },
            success: function(response) {
                var data = JSON.parse(response);
                var from = data.fromAddress;
                var subject = data.subject;
                var date = data.date;
                var to = data.toString;
                $('#from').html(from);
                $('#subject').html(subject);
                $('#to').html(to);
                $('#date').html(date);
            }
        });
        $('#preview').css('display', 'block');
        $('#attach_container').height($('#view_container').height());
        $.ajax({
            type: "get",
            url: "<?php echo base_url();?>email/getAttachment",
            data: {
                mail_id: mail_id,
                mail_box: "INBOX"
            },
            success: function(response) {
                if (response == "No")
                {
                    $('#loader').fadeOut(1000);
                    return;
                }
                var data = JSON.parse(response);
                var html = '';
                for (var one in data)
                {
                    console.log(data[one]);
                    html += "<br><span class='info-box-text'><a href='<?php echo base_url()?>/email/download?filename=" + data[one].filePath + "'><i class='fa fa-download'></i>&nbsp;&nbsp;" + data[one].name + "</a></span>";
                }
                $('#attach_panel').html(html);
                $('#loader').fadeOut(1000);
            }
        });

    }

    function showPage() {
        document.getElementById("loader").style.display = "none";
    }
</script>
