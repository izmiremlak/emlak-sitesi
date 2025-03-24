            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Bildirim Şablonları</h4>

                        </div>
                    </div>



<form action="" method="POST" id="SelectForm">
<input type="hidden" name="action" value="" id="action_hidden">
<div class="row">


                        <div class="col-lg-12 col-md-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="btn-toolbar" role="toolbar">

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default m-t-20">
                                <div class="panel-body">



                                        <table class="table table-hover mails datatable">
										<thead>
										<tr>
										<th style="display:none">Seç</th>
										<th>Bildirim</th>
										<th>Konu</th>
										<th>Kontroller</th>

										</tr>
										</thead>

										<tbody>
										<?php
										$sorgu		= $db->query("SELECT * FROM mail_sablonlar_19541956 WHERE dil='".$dil."' ORDER BY id ASC LIMIT 0,500");
										while($row	= $sorgu->fetch(PDO::FETCH_OBJ)){
										?>
										<tr>

										<td class="mail-select" style="display:none">
										<div class="checkbox checkbox-primary">
										<input id="checkbox<?=$row->id;?>" type="checkbox" name="id[]" value="<?=$row->id;?>">
										<label for="checkbox<?=$row->id;?>"></label>
										</div>
                                         </td>

										 <td><?=$row->adi;?></td>
										 <td><?=($row->konu == '') ? $row->konu2 : $row->konu;?></td>
										 <td>

										 <button type="button" class="btn btn-info waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=mail_sablon_duzenle&id=<?=$row->id;?>';"> <i class="fa fa-edit"></i> Düzenle</button>

										 </td>


										</tr>
										<?
										}
										?>
										</tbody>

                                        </table>



                                </div>
                            </div>
                        </div>
                    </div>





                </div>
            </div>

        </div>

    </div>



    <script>
        var resizefunc = [];
    </script>
	<script src="assets/js/admin.min.js"></script>
	<link href="assets/plugins/notifications/notification.css" rel="stylesheet">
    <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">
	<link href="assets/vendor/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="assets/vendor/sweetalert/dist/sweetalert.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function() {
	$('.datatable').dataTable();
	});


	function TumuSil() {
	$("#action_hidden").val("sil");
	       swal({
            title: "Seçilenleri Sil",
            text: "Bu işlemi gerçekten yapmak istiyor musunuz ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Evet, Hemen!",
            closeOnConfirm: false
        }, function(){
         //  swal("Deleted!", "İşlem Başarıyla Gerçekleşti.", "success");
			$("#SelectForm").submit();
        });
	}

	</script>
