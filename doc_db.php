
<?php

    $dsn  = 'mysql:host=localhost;dbname=doc_db';    
    $user = 'root';                                  
    $pass = '';                                        
 
    try{

        $conn =  new PDO($dsn,$user,$pass);
        $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){
        echo "<script> alert('Faild To Connect with Database')</script>";
    }

?>