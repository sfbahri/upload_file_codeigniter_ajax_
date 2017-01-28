<?php 
  
  function nama_function_model_insert($data,$nama_file_gambar){

      $sql = "INSERT into album (judul_album,gbr_album) VALUES ('$data[judul_album_add]','$nama_file_gambar')";
      return $this->db->query($sql); 
    }
    
    function nama_function_model_update($data,$nama_file_gambar){
      $sql = "UPDATE album SET      judul_album  = '$data[jdl_album_edit]',
                                    gbr_album   = '$nama_file_gambar'
                              WHERE id_album    = '$data[id_album_edit]'";

      return $this->db->query($sql); 
    }

?>
