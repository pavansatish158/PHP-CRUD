<?php include('server.php');
   // errors displaying
           ini_set('display_errors', 1);
           ini_set('display_startup_errors', 1);
           error_reporting(E_ALL);
   
   // fetch the records to be updated
   if(isset($_GET['edit'])){
     $id=$_GET['edit'];
     $edit_state = true;  
     $rec=mysqli_query($db,"SELECT * FROM users WHERE id=$id");
     $record=mysqli_fetch_array($rec);
   
     $id=$record['id'];
     $name=$record['name'];
     $designation=$record['designation'];  
   }
   ?>
<html>
   <head>
      <meta charset="utf-8">
      <!-- meta-data -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="PHP-MySql">
      <meta name="author" content="Pavan Satish Kutha">
      <title>PHP-CRUD</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
      <!-- external style sheet -->
   </head>
   <body>
      <h2>
         <center>PHP-CRUD</center>
      </h2>
      <form action="" enctype="multipart/form-data" method="post" class="form">
         <h4>Add users here:</h4>
         <input type="hidden" name="id" value='<?php echo $id; ?>'>
         <div class="input-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $name; ?>" ><span class="error"> <?php echo $nameErr;?></span>
         </div>
         <div class="input-group">
            <label>Designation:</label>
            <input type="text" name="designation" value="<?php echo $designation; ?>" ><span class="error"><?php echo $desigErr;?></span>
         </div>
         <span class="error"><?php echo $sucsErr;?></span>            
         <div class="input-group">
            <?php if($edit_state == false): ?>
            <button type="submit" value="" name="save" class="btn">Save</button>
            <?php else: ?>
            <button type="submit" value="" name="update" class="btn">Update</button>
            <?php endif ?>
         </div>
      </form>
      <!-- displaying notification messages -->
      <?php if(isset($_SESSION['msg'])):?>
      <div class="alert  text-center" id="msg">
         <?php
            echo $_SESSION['msg'];
            // unset($_SESSION['msg']);
            ?>
      </div>
      <?php endif ?>
      <div class="container-fluid">
      <div class="row">
         <span class="error"><?php echo $resultErr;?></span>
         <form action="" method="post">
            <input type="text" name="valueToSearch" placeholder="search by id/name/desig"><span class="error"> <?php echo $searchErr;?></span>
            <input type="submit" name="search" value="Search">
         </form>
         <table>
            <caption>Users table</caption>
            <thead>
               <tr>
                  <th>
                     <a href="index.php?sorting=<?php echo $sort ?>&field=id">
                        Id
                  </th>
                  <th><a href="index.php?sorting=<?php echo $sort ?>&field=name">Name</th>
                  <th><a href="index.php?sorting=<?php echo $sort ?>&field=designation">Designation</th>
                  <th colspan="2"><a>Action</a></th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  while ($row = mysqli_fetch_array($sql)) 
                     { ?>
               <tr>
                  <td><?php echo $row['id'];?></td>
                  <td><?php echo $row['name'];?></td>
                  <td><?php echo $row['designation'];?></td>
                  <td><a class="edit-btn" href="index.php?edit=<?php echo $row['id'];?>">Edit</a></td>
                  <td><a class="del-btn" Onclick="return ConfirmDelete()"href="server.php?delete=<?php echo $row['id']; ?>">Delete</a></td>
               </tr>
               <?php } ?>   
            </tbody>
         </table>
      </div>
      <div class="page">
         <!-- pagination -->
         <?php
            $sql="SELECT * FROM users";
            $data= $db->query($sql);
            $records=$data->num_rows;
            $records_pages=$records/10;
            $records_pages=ceil($records_pages);
            $prev= $page-1;
            $next=$page+1;
            echo "<ul class='pagination'>";
            // first page 
            if ($prev >=5) {
               echo '<li><a href="?page=1">First</a></li>';
            }
            // previous button link
            if ($prev >=1) {
               echo '<li><a href="?page='.$prev.'">prev</a></li>';
            }
            
            if($records_pages >=2){
               for($i=1; $i<=$records_pages;$i++){
                  $active= $i == $page ?'class="active"' : '';
                  echo '<li><a href="?page='.$i.'"'.$active.'>'.$i.'</a></li>';
               }
            }
            // next button link
            if ($next <=$records_pages && $records_pages >=2) {
               echo '<li><a href="?page='.$next.'">next</a></li>';
            }
            if ($page !=$records_pages && $records_pages >=5) {
               echo '<li><a href="?page='.$records_pages.'">Last</a></li>';
            }
            echo "</ul>";
            ?>
      </div>
      <script type="text/javascript" src="./assets/js/script.js"></script>
   </body>
</html>