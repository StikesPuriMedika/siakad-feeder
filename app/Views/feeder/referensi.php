<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/feeder/referensi/show");
	$("body").on("click","a[name^='ambildata_']",function(){
		var action = $(this).attr("data-src");
		var name = $(this).attr("name");
		$.ajax({
			url: action,
			dataType: 'json',
			beforeSend:function(){
				$("a[name='"+name+"']").prop("disabled",true);
				$("a[name='"+name+"']").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("a[name='"+name+"']").prop("disabled",false);
				$("a[name='"+name+"']").html("Ambil data");	
			},
			success: function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/feeder/referensi/show");
				}else{
					toastr.error(ret.messages);
				}
			},
			error:function(xhr,ajaxOptions,thrownError){
				alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
			}		 
		})
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
