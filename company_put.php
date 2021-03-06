<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);

    // Validate.
    if ((int)$request->id < 1 || trim($request->characteristic) == '' || trim($request->characteristic_value) === '' || trim($request->characteristic_type) === '') {
        return http_response_code(400);
    }

    // Sanitize.
    $id    = mysqli_real_escape_string($con, (int)$request->id);
    $characteristic = mysqli_real_escape_string($con, trim($request->characteristic));
    $characteristic_value = mysqli_real_escape_string($con, trim($request->characteristic_value));
    $characteristic_type = mysqli_real_escape_string($con, trim($request->characteristic_type));

    // Update.
    $sql = "UPDATE `company` SET `characteristic`='$characteristic',`characteristic_value`='$characteristic_value', `characteristic_type`='$characteristic_type' WHERE `id` = '{$id}' LIMIT 1";

    if(mysqli_query($con, $sql))
    {
        http_response_code(204);
    }
    else
    {
        return http_response_code(422);
    }
}