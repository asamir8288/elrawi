<?php

function load_editor($element, $value = '') {

    $CI = get_instance();
    $CI->ckeditor->basePath = base_url() . 'application/plugins/ckeditor/';
    $CI->ckeditor->ToolbarSet = 'Advanced';
    $ckeconfig = array(
        'width' => "700px",
        'height' => '400px',    
        'enterMode' => 'ENTER_BR',
        'filebrowserBrowseUrl' => base_url() . 'ckfinder/ckfinder.html',
        'filebrowserImageBrowseUrl' => base_url() . 'ckfinder/ckfinder.html?type=Images',
        'filebrowserFlashBrowseUrl' => base_url() . 'ckfinder/ckfinder.html?type=Flash',
        'filebrowserUploadUrl' => base_url() . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        'filebrowserImageUploadUrl' => base_url() . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        'filebrowserFlashUploadUrl' => base_url() . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    );

    return $CI->ckeditor->editor($element, $value, $ckeconfig);
}

function load_file_finder($path) {
    ?>
<script type="text/javascript" src="<?php echo base_url() ?>ckfinder/ckfinder.js"></script>
    <script type="text/javascript">

        function BrowseServer()
        {
            // You can use the "CKFinder" class to render CKFinder in a page:
            var finder = new CKFinder();
            finder.basePath = site_url('ckfinder');	// The path for the installation of CKFinder (default = "/ckfinder/").
            finder.selectActionFunction = SetFileField;
            finder.popup();

            // It can also be done in a single line, calling the "static"
            // Popup( basePath, width, height, selectFunction ) function:
            // CKFinder.Popup( '../../', null, null, SetFileField ) ;
            //
            // The "Popup" function can also accept an object as the only argument.
            // CKFinder.Popup( { BasePath : '../../', selectActionFunction : SetFileField } ) ;
        }

        // This is a sample function which is called when a file is selected in CKFinder.
        function SetFileField( fileUrl )
        {
            document.getElementById( '<?php echo $path ?>' ).value = fileUrl;
                        
            var path=fileUrl;
                        
            path_array=path.split("/");
                        
            var img=path_array[path_array.length-1];
                        
            path_array[path_array.length-2]="_thumbs";
            path_array[path_array.length-1]="Images";
            path_array[path_array.length]=img;
                        
            var thumb_path="";
            for (var i = 0; i < path_array.length; i++)
            {
                if(i>0)
                    thumb_path+="/"+path_array[i];
                            
            }
            $('#img_thumb').css("background-image", "url('"+thumb_path+"')");
            $('#img_thumb').addClass("thumb_div");
        }

    </script>
    <?php
}

function page_thumb($path) {

    $exploded = explode("/", $path);


    $img = $exploded[count($exploded) - 1];
    //$img_folder=$exploded[count($exploded)-2];

    $exploded[count($exploded) - 2] = "_thumbs";
    $exploded[count($exploded) - 1] = "Images";
    $exploded[count($exploded)] = "$img";

    return implode("/", $exploded);
}
?>
