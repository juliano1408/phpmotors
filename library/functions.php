<?php 

function checkEmail($email) {
    $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $validEmail;
}

function checkPassword($password) {
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $password);
}

function buildNavigation($classifications) {

    $navigationList = "<ul>";
    $navigationList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";

    foreach ($classifications as $classification) {
        $navigationList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=" .urlencode($classification['classificationName']). "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }

    $navigationList .= "</ul>";

    return $navigationList;
}

function buildClassificationList($classifications) { 

    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>";

    foreach ($classifications as $classification) { 
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 

    $classificationList .= '</select>'; 

    return $classificationList; 
}

function buildVehiclesDisplay($vehicles) {

    $display_vehicles = '<ul id="inv-display">';

    foreach ($vehicles as $vehicle) {

        $vehiclePrice = number_format($vehicle['invPrice']);

        $link = "/phpmotors/vehicles/index.php?action=vehicle-view&invId=$vehicle[invId]";

        $display_vehicles .= '<li>';
        $display_vehicles .= "<a href='$link'><img src='http://localhost$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
        $display_vehicles .= "<h3>$vehicle[invMake] $vehicle[invModel]</h3>";
        $display_vehicles .= "<span>$$vehiclePrice</span>";
        $display_vehicles .= '</a></li>';
    }

    $display_vehicles .= '</ul>';

    return $display_vehicles;

}

function buildVehicleDisplay($vehicle) {

    $invPrice = number_format($vehicle['invPrice']);

    $display_vehicle = "<div class='vehicle-details'>";

    $display_vehicle .= "<div class='img'><img src='http://localhost/$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></div>";

    $display_vehicle .= "<div class='car-details'>";

    $display_vehicle .= "<h3>$vehicle[invMake] $vehicle[invModel]</h3>";

    $display_vehicle .= "<p>Price: <span>$$invPrice</span></p>";
    $display_vehicle .= "<p>Color: <span>$vehicle[invColor]</span></p>";
    $display_vehicle .= "<p>Stock: <span>$vehicle[invStock]</span></p>";
    
    $display_vehicle .= "<p class='desc'>$vehicle[invDescription]</p>";
    
    $display_vehicle .= "</div>";

    $display_vehicle .= "</div>";

    return $display_vehicle;

}

function makeThumbnailVehicle($vehicleThumbnails) {

    $thumbnails_display = "";

    if(!empty($vehicleThumbnails)) {

        $thumbnails_display .= "<div class='vehicle-thumbnails'>";

        foreach($vehicleThumbnails as $thumbnail) {

            $thumbnails_display .= "<img class='thumbnail' src='http://localhost/$thumbnail[imgPath]' alt='Image of $thumbnail[invMake] $thumbnail[invModel] on phpmotors.com'>";
   
        }

        $thumbnails_display .= "</div>";

    }

    return $thumbnails_display;

}



function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';

    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
        $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }

    $id .= '</ul>';

    return $id;
}

function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";

    foreach ($vehicles as $vehicle) {
        $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }

    $prodList .= '</select>';

    return $prodList;
}

function uploadFile($name) {

    global $image_dir, $image_dir_path;

    if (isset($_FILES[$name])) {
        
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }

        $source = $_FILES[$name]['tmp_name'];

        $target = $image_dir_path . '/' . $filename;

        move_uploaded_file($source, $target);

        processImage($image_dir_path, $filename);

        $filepath = $image_dir . '/' . $filename;

        return $filepath;
    }
}

function processImage($dir, $filename) {    
    $dir = $dir . '/';

    $image_path = $dir . $filename;
   
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    resizeImage($image_path, $image_path, 500, 500);
}

function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
        break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
        break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
        break;
        default:
        return;
   }
   
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    if ($width_ratio > 1 || $height_ratio > 1) {
   
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);
   
        $new_image = imagecreatetruecolor($new_width, $new_height);
   
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }
   
        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        }

        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;

        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        $image_to_file($new_image, $new_image_path);

        imagedestroy($new_image);

    } else {
        $image_to_file($old_image, $new_image_path);
    }

     imagedestroy($old_image);
}