<?php 
    session_start();
    include_once "config.php";
    
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $password = md5($password);

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
        //checks if user email is valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //checks if the email is already exists in the db
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'"); 
            if(mysqli_num_rows($sql) > 0) { //if email already exist
                echo "$email - email already exists";
            } else {
                 //check user upload file
                if(isset($_FILES['image'])) { //if file is uploaded
                    $img_name = $_FILES['image']['name']; //getting user uploaded img name
                    $tmp_name = $_FILES['image']['tmp_name']; //temporary name used to save file

                    // explode image and get last extension
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode); //user extension for uploaded file

                    $extensions = ['png','jpeg', 'jpg'];
                    if(in_array($img_ext, $extensions) === true) {
                        $time = time();

                        $new_img_name = $time.$img_name;
                        
                        if(move_uploaded_file($tmp_name, __DIR__."images/".$new_img_name)) {
                            // $status = "Active now";
                            $status = 1;
                            $random_id = rand(time(), 10000000);
                            
                            $sqlQuery = "INSERT INTO users (unique_id, fname, lname, email, password, img, status) 
                                VALUES ('$random_id', '$fname', '$lname', '$email', '$password', '$new_img_name', '$status')";
                            
                            try {
                                if(mysqli_query($conn, $sqlQuery)) {
                                    echo "saved to DB";
                                    $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($sql3) > 0) {
                                        $row = mysqli_fetch_assoc($sql3);
                                        $_SESSION['unique_id'] = $row['unique_id'];
                                        echo "success";
                                    } else {
                                        echo "could not select new record";
                                    }
                                } else {
                                    echo("Error description: " . mysqli_error($conn));
                                } 
                            } catch(Exception $e) {
                                echo 'Message: ' .$e->getMessage();
                            }
                        }
                    } else {
                        echo "Please select an image file -jpeg, jpg, png";
                    }
                } else {
                    echo "Please select an image file";
                }
            }
        } else {
            echo "$email - This is not valid";
        }
    } else {
        echo "All input fields are required";
    }
?>
