<?php  

    include "doc_db.php";

    $connect = mysqli_connect("localhost", "root", "", "doc_db");  

    if (!$connect) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    if(isset($_POST["submit"])){
        
        if(!empty($_POST["search"])){ 
            
           $query = str_replace(" ", "+", $_POST["search"]);  
           header("location:Search_freeText.php?search=" . $query); 
            
        }  
    }

 ?>  

 <!DOCTYPE html>  
 <html>  
      <head>  
          
           <title>2-IR_Free Text Query</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
          
      </head> 
     
      <body>  
          
           <br /><br />  
          
           <div class="container" style="width:700px;">  
               
               <h2 align="center">Free Text Query</h2><br />  
                
               <form method="post">  
                     <label>Enter Search Text</label>  
                     <input 
                            type="text" 
                            name="search"
                            class="form-control" 
                            autocomplete="off" 
                            placeholder="Exp : helwan university" 
                            value="<?php if(isset($_GET["search"])) echo $_GET["search"]; ?>" />  
                   
                     <br />  
                     <input type="submit" name="submit" class="btn btn-info" value="Search" />  
                </form>  

            <br /><br />  
                
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                     
                <?php
                         
                     if(isset($_GET["search"]))  
                     {  

                          $condition = '';  
                          $query = explode(" ", $_GET["search"]); 
                         
                          foreach($query as $text)  
                          {  
                               $condition .= "term LIKE '%".mysqli_real_escape_string($connect, $text)."%' OR ";  
                          }  
                         
                          $condition = substr($condition, 0, -4);  

                          $sql_query = "SELECT * FROM docs WHERE " . $condition;
                         
                            $words = 'query';
                            $words = explode(' ', $words);
                            $frequency = array();
                         
                            foreach($words as $word) {
                                
                                 $word = strtolower($word);
                                
                                 if(isset($frequency[$word]))
                                        $frequency[$word] += 1;
                                  else
                                        $frequency[$word] = 1;
                                
                            }
                         
                          $result = mysqli_query($connect, $sql_query);
                         
                          if(mysqli_num_rows($result) > 0)  
                          {  
                               while($row = mysqli_fetch_array($result))  
                               {  

                                    echo "<tr>"; 
                                    echo "<td>"."Doc : ".$row['doc_id']."</td>";
                                    echo "</tr>"; 
                               }  
                          }  
                          else  
                          {  
                               echo '<label>Data not Found</label>';  
                          }  
                     }  
                         
                     ?>  
                         
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  