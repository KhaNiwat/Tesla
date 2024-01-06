<?php

    session_start();
    require_once '../config/db.php';
    

    if(isset($_POST['signup'])){

        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $urole = 'user';
        
        if(empty($firstname)){
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            echo "name";
            header("location: ../signup.php"); //เปลี่ยนหน้าไป to ...
        }else if(empty($lastname)){
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            echo "lastname";
            header("location: ../signup.php"); 

        }else if(empty($email)){
            $_SESSION['error'] = 'กรุณากรอกอีเมล์';
            echo "email";
            header("location: ../signup.php"); 
        
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = 'รูปแบบอีเมล์ไม่ถูกต้อง';
            echo "email invalid";
            header("location: ../signup.php");

        }else if(empty($password)){
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            echo "password";
            header("location: ../signup.php"); 

        }else if(strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5){
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวตั้งแต่ 5-20 ตัวอักษรอย่างต่ำ';
            
            header("location: ../signup.php"); 
        }else if(empty($c_password)){
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            echo "cpassword";
            header("location: ../signup.php"); 
        }else if($password != $c_password){
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            echo "not match";
            header("location: ../signup.php"); 
        }else{
            echo "ผ่านจ้า";
            try{
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
                
                if($row['email'] == $email){
                    $_SESSION['warning'] = "มีอีเมล์นี้อยู่ในระบบแล้ว <a href='signin.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: ../signup.php"); 
                }else if (!isset($_SESSION['error'])){
                    echo "ไม่มี error";
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(firstname,lastname,email,password,role) 
                    VALUE(:firstname,:lastname,:email,:password,:role)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":role", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อย <a href='signin.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: ../signup.php");
                }else{
                    
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: ../signup.php");
                }

            }catch(PDOException $e){
                echo "มีerror";
                echo $e->getMessage();
            }
        }
    }

?>