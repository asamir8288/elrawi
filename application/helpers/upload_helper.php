<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @param <string> $folder_name folder name or path from codeigniter base folder
 * @param array $allowed_types array of strings that represents the allowed extensions to upload e.g 'gif','png','pdf'
 * @param <string> $max_size maximum size in kilobytes
 * @return $data["error_flag"] true if upload failed, false if upload succeeded
 * @return $data["upload_data"] array of uploaded file data
 * @return $data["errors"] array of errors occured
 */
function upload_file($folder_name, array $allowed_types, $max_size) {
    $CI = & get_instance();

    $config['upload_path'] = './files/' . $folder_name . '/';
    $config['allowed_types'] = implode("|", $allowed_types);
    $config['max_size'] = $max_size;
    $config['encrypt_name'] = TRUE;    
    $CI->load->library('upload', $config);

    if (!$CI->upload->do_upload()) {
        $error = array('errors' => $CI->upload->display_errors(), 'error_flag' => true);
        return $error;
    } else {
        $data = array('upload_data' => $CI->upload->data(), 'error_flag' => false);
        return $data;
    }
}

function check_directory($dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            return TRUE;
        } else {
            chmod($dir, 0777);
            return TRUE;
        }
    } else {
        mkdir($dir, 0777);
        return TRUE;
    }
}

/* End of file upload_helper.php */
/* Location: ./system/application/helpers/upload_helper.php */

function resize_image(&$uploaded_image, $max_file_size=100, $max_img_width=500, $max_img_height=500) {
    $width = $uploaded_image["upload_data"]["image_width"];
    $height = $uploaded_image["upload_data"]["image_height"];
    $file_size = $uploaded_image["upload_data"]["file_size"];

    if ($width > $max_img_width || $height > $max_img_height || $file_size > $max_file_size) {
        switch ($uploaded_image["upload_data"]["image_type"]) {

            case "jpeg":
                $img = imagecreatefromjpeg($uploaded_image["upload_data"]["full_path"]);
                break;
            case "png":
                $img = imagecreatefrompng($uploaded_image["upload_data"]["full_path"]);
                break;
            default:
                $img = imagecreatefromgif($uploaded_image["upload_data"]["full_path"]);
                break;
        }

        $new_diminsions = get_image_sizes($uploaded_image["upload_data"]["full_path"], $max_img_width, $max_img_height);

        $tn = imagecreatetruecolor($new_diminsions[0], $new_diminsions[1]);

        imagecopyresampled($tn, $img, 0, 0, 0, 0, $new_diminsions[0], $new_diminsions[1], $width, $height);

        imagejpeg($tn, $uploaded_image["upload_data"]["file_path"] . $uploaded_image["upload_data"]["raw_name"] . ".jpeg", 85);

        if ($uploaded_image["upload_data"]["image_type"] != 'jpeg') {
            @unlink($uploaded_image["upload_data"]["full_path"]);
        }
        $uploaded_image["upload_data"]["full_path"] = $uploaded_image["upload_data"]["file_path"] . $uploaded_image["upload_data"]["raw_name"] . ".jpeg";

        $uploaded_image["upload_data"]["file_name"] = $uploaded_image["upload_data"]["raw_name"] . ".jpeg";
    }
}

function image_dimensions($height, $max_img_height, &$modheight, $width, $max_img_width, &$modwidth) {
    if ($height > $max_img_height) {
        $modheight = $max_img_height;

        $modwidth = ($modheight / $height) * $width;
    } elseif ($width > $max_img_width) {
        $modwidth = $max_img_width;

        $modheight = ($modwidth / $width) * $height;
    } else {
        $modheight = $max_img_height;
        $modwidth = $max_img_width;
    }

    if ($width > $max_img_width || $height > $max_img_height) {
        image_dimensions($modheight, $max_img_height, $modheight, $modwidth, $max_img_width, $modwidth);
    }
}


function get_image_sizes($sourceImageFilePath, $maxResizeWidth, $maxResizeHeight) {

    // Get width and height of original image
    $size = getimagesize($sourceImageFilePath);
    if ($size === FALSE)
        return FALSE; // Error
    $origWidth = $size[0];
    $origHeight = $size[1];

    // Change dimensions to fit maximum width and height
    $resizedWidth = $origWidth;
    $resizedHeight = $origHeight;
    if ($resizedWidth > $maxResizeWidth) {
        $aspectRatio = $maxResizeWidth / $resizedWidth;
        $resizedWidth = round($aspectRatio * $resizedWidth);
        $resizedHeight = round($aspectRatio * $resizedHeight);
    }
    if ($resizedHeight > $maxResizeHeight) {
        $aspectRatio = $maxResizeHeight / $resizedHeight;
        $resizedWidth = round($aspectRatio * $resizedWidth);
        $resizedHeight = round($aspectRatio * $resizedHeight);
    }

    // Return an array with the original and resized dimensions
    return array($resizedWidth, $resizedHeight);
}
