<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);


    // Validate.
    if(trim($request->contact) === '' || trim($request->contact_type) === '')
    {
        return http_response_code(400);
    }

    // Sanitize.
    $contact = mysqli_real_escape_string($con, trim($request->contact));
    $contact_type = mysqli_real_escape_string($con, trim($request->contact_type));


    // Create.
    $sql = "INSERT INTO `contacts`(`id`,`contact`, `contact_type`) VALUES (null,'{$contact}','{$contact_type}')";

    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $policy = [
            'contact' => $contact,
            'contact_type' => $contact_type,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($policy);
    }
    else
    {
        http_response_code(422);
    }
}