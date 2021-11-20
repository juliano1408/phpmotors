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

        $link = "/phpmotors/vehicles/index.php?action=vehicle-view&invId=$vehicle[invId]";

        $vehiclePrice = number_format($vehicle['invPrice']);

        $display_vehicles .= '<li>';
        $display_vehicles .= "<a href='$link'><img src='http://localhost/phpmotors$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
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

    $display_vehicle .= "<div class='img'><img src='http://localhost/phpmotors$vehicle[invImage]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></div>";

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