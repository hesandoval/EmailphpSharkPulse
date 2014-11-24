<?php
    //photograph, lat long, email,

    echo "Hello World";
    echo $_SERVER['REQUEST_METHOD'];
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        echo "The method is post";

        $users_information = Array(
            "DATE" => "",
            "TIME" => "",
            "USERS_EMAIL" => "",
            "SHARK_NAME" => "",
            "IMAGE_NAME" => "",
            "LATITUDE" => "",
            "LONGITUDE" => "",
            "NOTES" => "");
        $users_information["DATE"] = $_POST["DATE"];
        $users_information['TIME'] = $_POST['TIME'];
        $users_information['SHARK_NAME'] = $_POST["SPECIES"];
        $users_information['IMAGE_NAME'] = $_FILES['PHOTOGRAPH']['name'];
        $users_information['LATITUDE'] = $_POST["LATITUDE"];
        $users_information["LONGITUDE"] = $_POST["LONGITUDE"];
        $users_information["USERS_EMAIL"] = $_POST['EMAIL'];
        $users_information["NOTES"] = $_POST['NOTES'];
        if($_FILES['PHOTOGRAPH']['name'] && !$_FILES['PHOTOGRAPH']['error']){
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["PHOTOGRAPH"]["name"]);
            if (move_uploaded_file($_FILES["PHOTOGRAPH"]["tmp_name"], $target_file)) {
                $users_information['IMAGE_NAME'] = $target_dir . basename($_FILES["PHOTOGRAPH"]["name"]);
                echo "The file ". basename( $_FILES["PHOTOGRAPH"]["name"]). " has been uploaded.";
                echo $users_information["NOTES"];
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
       }//else{
//            //http_response_code(404);
//            echo "File is not being handled";
//            echo $users_information["PHOTOGRAPH"];
//            echo $users_information["PHOTOGRAPH"]["name"];
//            echo "Still in error debuging";
//        }



        $mysql_hostname = "54.67.32.82";
        $mysql_username = "baseline2user";
        $mysql_password = "baseline2pass";
        $mysql_db_name = "baseline2_wp";

        $mysql_connection = @mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_db_name);
        if(mysqli_connect_errno()){
            echo "Error";
        }

        $sql = "INSERT INTO `sharkpulse_temp` (id, date, time, users_email, species_name, latitude, longitude, img_name, status) VALUES ";
        $data = $data . "('', '".
            $users_information['DATE']."', '".
            $users_information['TIME']."', '".
            mysqli_real_escape_string($mysql_connection, $users_information['USERS_EMAIL'])."', '".
            mysqli_real_escape_string($mysql_connection, $users_information['SHARK_NAME'])."', '".
            $users_information['LATITUDE']."', '".
            $users_information['LONGITUDE']."', '".
            mysqli_real_escape_string($mysql_connection, $users_information['IMAGE_NAME'])."', '')";
        $sql = $sql . $data;
        if($result = @mysqli_query($mysql_connection, $sql))
        {
            echo "Completed!";
            http_response_code(200);
        }
        else{
            header("HTTP/1.0 404 Not Found");
        }



    }else{
        echo "\n The method is not post";
    }

?>