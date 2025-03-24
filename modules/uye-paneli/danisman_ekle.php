<?php
if($hesap->turu != 1){
header("Location:uye-paneli");
die();
}

$danisman_limit		= $hesap->danisman_limit;
$paketi				= $db->query("SELECT * FROM upaketler_19541956 WHERE acid=".$hesap->id." AND durum=1 AND btarih>NOW()");
if($paketi->rowCount()>0){
$paketi				=  $paketi->fetch(PDO::FETCH_OBJ);
$danisman_limit		+= ($paketi->danisman_limit == 0) ? 9999 : $paketi->danisman_limit;
$danisman_limit		-= $db->query("SELECT id FROM hesaplar WHERE site_id_555=999 AND kid=".$paketi->acid." AND pid=".$paketi->id)->rowCount();
}

?><div class="headerbg" <?=($gayarlar->belgeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->belgeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX494");?></h1>
<div class="sayfayolu">
<span><?=dil("TX495");?></span>
</div>
</div>

</div><div class="headerwhite"></div>
</div>


<div id="wrapper">

<div class="uyepanel">

<div class="sidebar">
<? include THEME_DIR."inc/uyepanel_sidebar.php"; ?>
</div>

<div class="content">

<div class="uyedetay">
<div class="uyeolgirisyap">
<h4 class="uyepaneltitle"><?=dil("TX494");?></h4>

<div class="alert-info"><?=dil("TX656");?></div>

<? if($danisman_limit<1){ ?>
<?=dil("TX662");?>
<? }else{ ?>

<form action="ajax.php?p=danisman_ekle" method="POST" id="DanismanEkleForm" enctype="multipart/form-data">
<table width="100%" border="0">

<tr>
<td><?=dil("TX363");?></td>
<td>

<input type="file" name="avatar" id="avatar" style="display:none;" />
<div class="uyeavatar">
<a title="Foto Yükle" class="avatarguncelle" href="javascript:void(0);" onclick="$('#avatar').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
<img  src="https://www.turkiyeemlaksitesi.com.tr/uploads/default-avatar.png" id="avatar_image" /><br>
<span style="    font-size: 13px;    color: #777;"><?=dil("TX654");?></span>
</div>

</td>
</tr>


  <tr>
    <td><?=dil("TX126");?> <span style="color:red">*</span></td>
    <td><input name="adsoyad" type="text"></td>
  </tr>
  
  
  <tr>
    <td><?=dil("TX127");?> <span style="color:red">*</span></td>
    <td><input name="email" type="text"></td>
  </tr>
  
  <tr>
    <td><?=dil("TX128");?> <?=($gayarlar->sms_aktivasyon==1) ? '<span style="color:red">*</span>' : '';?></td>
    <td><input name="telefon" id="gsm" type="text"></td>
  </tr>
  
  <tr>
    <td><?=dil("TX390");?></td>
    <td><input name="sabit_telefon" type="text" id="telefon" value="<?php echo $hesap->sabit_telefon;?>"></td>
  </tr>
  
  <tr>
    <td><?=dil("TX129");?> <span style="color:red">*</span></td>
    <td><input name="parola" type="password"></td>
    </tr>
    <tr>
    <td><?=dil("TX130");?> <span style="color:red">*</span></td>
    <td><input name="parola_tekrar" type="password"></td>
    </tr>
	
  <tr>
    <td colspan="2">
    <span  style="margin-bottom:10px;    float: left;"><strong><?=dil("TX644");?></strong></span><div class="clear"></div>
    <textarea style="width:100%;" name="hakkinda" class="thetinymce" id="hakkinda" placeholder="<?=dil("TX429");?>"><?=$snc->hakkinda;?></textarea>
    </td>
  </tr>


	
	<tr style="font-size:13px;display:none">
       <td colspan="2">
       <h5 style="margin-bottom:7px;"><strong><?=dil("TX398");?></strong></h5>
       <input id="telefond_check" class="checkbox-custom" name="telefond" value="1" type="checkbox" style="width:100px;">
	   <label for="telefond_check" class="checkbox-custom-label"><span class="checktext"><?=dil("TX386");?></span></label>
       <div class="clear" style="margin-bottom:5px;"></div>
	   
	   <input id="sabittelefond_check" class="checkbox-custom" name="sabittelefond" value="1" type="checkbox" style="width:100px;">
	   <label for="sabittelefond_check" class="checkbox-custom-label"><span class="checktext"><?=dil("TX387");?></span></label>
       <div class="clear" style="margin-bottom:5px;"></div>
	   
	   <input id="epostad_check" class="checkbox-custom" name="epostad" value="1" type="checkbox" style="width:100px;">
	   <label for="epostad_check" class="checkbox-custom-label"><span class="checktext"><?=dil("TX388");?></span></label>
       <div class="clear" style="margin-bottom:5px;"></div>
	   
	   <input id="avatard_check" class="checkbox-custom" name="avatard" value="1" type="checkbox" style="width:100px;">
	   <label for="avatard_check" class="checkbox-custom-label"><span class="checktext"><?=dil("TX389");?></span></label>
       <div class="clear" style="margin-bottom:5px;"></div>
	   
       <h5 style="margin-bottom:7px;margin-top:10px;"><strong><?=dil("TX399");?></strong></h5>
        <input checked id="checkbox-6" class="checkbox-custom" name="mail_izin" value="1" type="checkbox" style="width:100px;">
	   <label for="checkbox-6" class="checkbox-custom-label"><span class="checktext"><?=dil("TX251");?></span></label>
       <div class="clear" style="margin-bottom:5px;"></div>
       <input checked id="checkbox-7" class="checkbox-custom" name="sms_izin" value="1" type="checkbox" style="width:100px;">
	   <label for="checkbox-7" class="checkbox-custom-label"><span class="checktext"><?=dil("TX252");?></span></label>
       </td>
     </tr>
  

 <tr>
    <td style="border:none" colspan="2">

	<div id="DanismanEkleForm_output" style="display:none"></div>

	<a href="javascript:;" id="ButtonSubmit" onclick="ButtonSubmit();" class="btn"><i class="fa fa-user-plus" aria-hidden="true"></i> <?=dil("TX496");?></a>

	</td>
  </tr>
  </table>
</form>
<script src="<?=THEME_DIR;?>tinymce/tinymce.min.js"></script>
<script type="application/x-javascript">
tinymce.init({
	selector:"#hakkinda",
    height: 200,
	menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools'
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image',
  toolbar2: 'print preview media | forecolor backcolor emoticons',
  });
</script>
<script type="text/javascript">
function ButtonSubmit(){
var stbutton = $("#ButtonSubmit");
var stonc 	 = stbutton.attr("onclick");
var stinn  	 = stbutton.html();
stbutton.removeAttr("onclick");
stbutton.html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
$('#hakkinda').html(tinymce.get('hakkinda').getContent());
$("#DanismanEkleForm_output").fadeOut(400);
$("#DanismanEkleForm").ajaxForm({
target: '#DanismanEkleForm_output',
complete:function(){
$("#DanismanEkleForm_output").fadeIn(400);
stbutton.attr("onclick",stonc);
stbutton.html(stinn);
}
}).submit();
}
</script>
<?}?>

</div>


<div id="TamamDiv" style="display:none">

<!-- TAMAM MESAJ -->
<div style="margin-bottom:70px;text-align:center;" id="BasvrTamam">
<i style="font-size:80px;color:green;" class="fa fa-check"></i>
<h2 style="color:green;font-weight:bold;"><?=dil("TX497");?></h2>
<!--br/>
<h4>---</h4-->
</div>
<!-- TAMAM MESAJ -->

</div>



</div>
</div>
</div>

<div class="clear"></div>
</div>
</div>