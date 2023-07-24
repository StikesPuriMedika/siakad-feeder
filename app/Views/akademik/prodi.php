<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="row no-print">
	<div class="col-12">
	  <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
	  <a href="#modalku" data-toggle="modal" title="Tambah Prodi" data-src="<?php echo base_url();?>/akademik/prodi/tambah" class="btn btn-success float-right modalButton"><i class="far fa-credit-card"></i> Tambah data</a>
	  <a href="#" name="getprodipddikti" data-src="<?php echo base_url();?>/akademik/prodi/getprodipddikti" class="btn btn-primary float-right" style="margin-right: 5px;">
		<i class="fas fa-download"></i> Ambil dari PDDIKTI
	  </a>
	</div>
</div>
<br>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/prodi/listdata");
	$("a[name='getprodipddikti']").on("click",function(){
		var action = $(this).attr("data-src");
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		$.get(action, function( data ) {		  
			if(data.success == true){
			   toastr.success(data.messages);
			    $("#resultcontent").load("<?php echo base_url();?>/akademik/prodi/listdata");
			}else{
				toastr.error(data.messages);
			}
			$("a[name='getprodipddikti']").html("<i class='fas fa-download'></i> Ambil dari PDDIKTI").removeClass("disabled");
		},'json')
		return false;
	})
	$("body").on("click","a[name='hapus']",function(){
		var action = $(this).attr("data-src");
		var id_prodi = $(this).attr("id_prodi");
		var dString = "id_prodi="+id_prodi;
		if(confirm("yakin data ini akan dihapus?")){
			$.ajax({
				type:'post',
				dataType:'json',
				url:action,
				data:dString,
				success:function(ret){
					if(ret.success == true){
					   toastr.success(ret.messages);
						$("#resultcontent").load("<?php echo base_url();?>/akademik/prodi/listdata");
					}else{
						toastr.error(ret.messages);
					}
				}
			})
		}
		return false;
	})
	$("body").on("submit","#form_tambah,#form_ubah",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#modalku").modal("hide");
					$("#resultcontent").load("<?php echo base_url();?>/akademik/prodi/listdata");
				}else{
					if(ret.error_feeder==true){
						toastr.error(ret.messages);
					}else{
						toastr.error('Data isian tidak valid');
					}
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
							element.closest("input.form-control")
							.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : '').find('.invalid-feedback').remove();
						element.after(value);
					})
				}
			}
		})
		return false;
	})
	$("body").on("click","input,select,textarea",function(){
		var element = $(this);
			element.closest("input.form-control")
			.removeClass('is-invalid').find('.invalid-feedback').remove();
			element.after(value="");
	})
})
</script>
<?php
echo $this->endSection();
?>
