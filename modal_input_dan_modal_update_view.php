<script>
$(document).ready(function () {
//base url 
var base_url = '<?php echo base_url();?>';

//format datatable
    $('.dataTables-example').DataTable();

    $("#btnsave_album").click(function(){  

    var form_data = new FormData($('#form_save_album')[0]);
    swal({
    title: "Simpan Gambar Album?",
    text: "Jika ya, silahkan klik button 'OK'",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
    },
    function(){
    setTimeout(function(){
      $.ajax({
        url         : base_url + 'nama_controller/nama_function_insert', 
        type        : "POST",
        dataType    : 'json',
        mimeType    : 'multipart/form-data',
        data        : form_data,
        contentType : false,
        cache       : false,
        processData : false,
        success     : function(data)
        {
            if(data == true){
                swal({
                  title: "OK",
                  text: "Gambar album berhasil disimpan",
                  timer: 2000,
                  type: "success",
                  showConfirmButton: false
                },
                function(){
                    location.reload(true);
                 });
                    //swal("Good job!", "You clicked the button!", "success")
                    //window.location.href= base_url + 'adm/identitas';
             }
        }
     });
    }, 500);
    });   
    });

});
</script>
<div class="col-lg-12" style="padding:0px">
<div class="panel panel-default" style="padding:0px">
<div class="panel-heading clearfix">
	<h3 class="panel-title">Album</h3>
	<ul class="panel-tool-options"> 
		<li><a href="javascript:void(0)"><button class="btn btn-primary" data-toggle="modal" data-target="#album_add"><i class="fa fa-plus"></i> Tambah Album</button></a></li>
	</ul>
</div>
<div class="panel-body">
	<div>
	<!-- <div class="table-responsive"> -->	
		<table class="table table-striped table-bordered table-hover dataTables-example" >
			<thead>
				<tr>
					<th>Gambar Album</th>
					<th>Judul Album</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($data as $r) {
				$path_gbr_album = $r['gbr_album'];

				//$ext = pathinfo($path_gbr_album, PATHINFO_EXTENSION);
				$ext = end(explode('.', $path_gbr_album));
				$filename =  substr($path_gbr_album, 0, strrpos($path_gbr_album, "."));
				$image_name = $filename.'_thumb'.'.'.$ext;

				
				
				?>

				<tr class="gradeX">
					<td align="center"><img src="<?php echo base_url('assets/gambar/'.$image_name.'');?>" class="avatar img-circle"></td>
					<td><?php echo $r['jdl_album'];?></td>
					<td>	<button class="btn btn-blue" data-toggle="modal" data-target="#album_add_edit_<?php echo $r['id_album'];?>" title='edit'><i class="fa fa-edit"></i></button> 
							<button class="btn btn-danger" onclick="functionHapusAlbum(<?php echo $r['id_album'];?>)" title='hapus'><i class="fa fa-remove"></i></button>
					</td>
				</tr>

				<!--start : Modal Input-->

				<div id="album_add_edit_<?php echo $r['id_album'];?>" class="modal fade" tabindex="-1" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title">Edit Album</h4>
				      </div>
				      <form method=POST enctype='multipart/form-data' id="form_album_edit<?php echo $r['id_album'];?>">
				      <div class="modal-body">
				        
				                <div class='form-group'>
				                <label for='emailaddress'>Judul Album</label>
				                <input type='text' class='form-control' name='jdl_album_edit' id='jdl_album_edit<?php echo $r['id_album'];?>' value="<?php echo $r['jdl_album'];?>">
				                <input type='hidden' class='form-control' name='id_album_edit' value="<?php echo $r['id_album'];?>">
				                </div>
				                <div class='form-group'>
				                <label for='emailaddress'>Gambar Album</label><br>
				                <!-- ini nama file aslinya -->
				                <input type='hidden' class='form-control' name='gbr_album_edit' value="<?php echo $r['gbr_album'];?>" >
				                <!-- ini nama file aslinya -->

				                <img src="<?php echo base_url('assets/gambar/'.$image_name.'');?>" width="200" height="200">
				                </div>
				                <div class='form-group'>
				                <label for='emailaddress'>Ganti Gambar Album</label>
				                <input type='file' name='gbr_album_edit2' >
				                </div>
				              
				            </form>
				      <div class="modal-footer">
				      	<!-- id="btn_edit_album<?php echo $r['id_album'];?>"-->
				        	<button type="button" class="btn btn-success"  onclick="functionEditAlbum(<?php echo $r['id_album'];?>)"><i class="fa fa-refresh"></i> Perbarui</button>
				        	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
				      </div>
				    	</div>
				   </div>
				</div>
		
				<!--end :  Modal EDIT-->

				<script type="text/javascript">
				var idalbum = <?php echo $r['id_album'];?>;
				var base_url = '<?php echo base_url();?>';
				var jdl_album = $("#jdl_album_edit"+idalbum).val();
			
				function functionEditAlbum(id){

					var form_data = new FormData($('#form_album_edit'+id)[0]);

				        swal({
				                  title: "Update Gambar Album?",
				                  text: "Jika ya, silahkan klik button 'OK'",
				                  type: "info",
				                  showCancelButton: true,
				                  closeOnConfirm: false,
				                  showLoaderOnConfirm: true,
				                    },
				                  function(){
				                  setTimeout(function(){

				                 	$.ajax({
							          url       			: base_url + 'nama_controller/nama_function_update', 
							          type      			: "POST",
							          dataType  			: 'json',
							          mimeType  			: 'multipart/form-data',
							          data      			: form_data,
							          contentType     	: false,
							          cache           	: false,
							          processData     	: false,
							          success     		: function(data)
							          {

							          	if(data == true){
						                      swal({
						                        title: "OK",
						                        text: "Gambar album berhasil disimpan",
						                        timer: 500,
						                        type: "success",
						                        showConfirmButton: false
						                      },
						                      function(){
						                          location.reload(true);
						                       });
						                      //swal("Good job!", "You clicked the button!", "success")
						                      //window.location.href= base_url + 'adm/identitas';
						                    }
							                  
							          }
							        });
				                   
				                  }, 500);
				                });
			   	
			   }



			   function functionHapusAlbum(id_album){
			   	swal({
				                  title: "Hapus Gambar Album?",
				                  text: "Jika ya, silahkan klik button 'OK'",
				                  type: "info",
				                  showCancelButton: true,
				                  closeOnConfirm: false,
				                  showLoaderOnConfirm: true,
				                    },
				                  function(){
				                  setTimeout(function(){

				                 	$.ajax({
							          url       			: base_url + 'adm/album_hapus', 
							          type      			: "POST",
							          dataType  			: 'json',
							          data      			: {id_album:id_album},
							          success     		: function(data)
							          {

							          	if(data == true){
						                      swal({
						                        title: "OK",
						                        text: "Gambar album berhasil dihapus",
						                        timer: 500,
						                        type: "success",
						                        showConfirmButton: false
						                      },
						                      function(){
						                          location.reload(true);
						                       });
						                    }
							                  
							          }
							        });
				                   
				                  }, 500);
				                });
			   }


				</script>
					
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</div>
</div>


<!--Modal Album Tambah -->

<div id="album_add" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Album</h4>
      </div>
      <form method=POST enctype='multipart/form-data' id="form_save_album">
      <div class="modal-body">
        
      
                <div class='form-group'>
                <label for='emailaddress'>Judul Album</label>
                <input type='text' class='form-control' name='judul_album_add'>
                </div>
               
                <div class='form-group'>
                <label for='emailaddress'>Foto Album</label>
                <input type='file' name='files_gambar_album' >
                </div>
              
            </form>

      
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnsave_album"><i class="fa fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
      </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End Basic Modal-->
