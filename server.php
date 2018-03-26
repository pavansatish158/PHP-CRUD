<?php
  // errors displaying
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

	session_start();
	// initialize variables
	$name="";
	$designation="";
	$id= 0;
	$edit_state= false; 

	// intializing error variables
    $nameErr="";
    $desigErr="";
    $searchErr="";
    $sucsErr="";
    $resultErr="";

	$field = 'id';
	$sort = 'ASC';  
	$row_cnt="";              
	// connect to database
	$db= mysqli_connect('localhost','root','root','CRUD');


	// on click save button
	if(isset($_POST['save'])){
		$name=$_POST['name'];
		$designation=$_POST['designation'];
		$id=$_POST['id'];
		$_SESSION['msg']="";
		if (!isset($name) || trim($name) == '') {
			$nameErr="Name be must filled!";
		}	
		if(!isset($designation)|| trim($designation) == ''){
			$desigErr="designation must be filled!";
		}
		else{	
			$query="INSERT INTO users (name,designation) VALUES('$name','$designation')";
			mysqli_query($db,$query);
		    $_SESSION['msg'] ="<p style='color:green;'>Data saved successfully!</p>";
			header('location: index.php');     /*redirect to index.php after inserting values*/

		}
}
	// updating records
		if (isset($_POST['update'])) {
			$name= mysqli_real_escape_string($db,$_POST['name']);
			$designation= mysqli_real_escape_string($db,$_POST['designation']);
			$id= mysqli_real_escape_string($db,$_POST['id']);
			$_SESSION['msg'] ="";
			if (!isset($name) || trim($name) == '') {
				$nameErr="Name cannot be blank!";
			}	
			elseif(!isset($designation)|| trim($designation) == ''){
				$desigErr="designation cannot be blank!";			
			}
			else{
			mysqli_query($db,"UPDATE users SET name='$name',designation='$designation' WHERE id=$id");
			$_SESSION['msg']= "<p style='color:blue;'>Data updated successfully!</p>";
			header('location: index.php');
			}

		}
		 // deleting records
		if(isset($_GET['delete'])){
			$id=$_GET['delete'];
			mysqli_query($db,"DELETE FROM users WHERE id=$id");
			$_SESSION['msg']="<p class='text-danger'>data is deleted!</p>";
			header('location:index.php');
		}

	// retrieving and displaying input values
	$results=mysqli_query($db,	"SELECT * FROM users");

		// sorting
	   if(isset($_GET['field']) && isset($_GET['sorting']))
	   {

	      if($_GET['field']=='id') { 
	        if($_GET['sorting']=='DESC') {
	        	$desc_state=true;
	         $field = "id";
	          $sort = 'ASC';
	        }else{
	        	$desc_state=false;
	         $field = "id";
	         $sort = 'DESC';
	        }
	      }
	      if($_GET['field']=='name') { 
	        if($_GET['sorting']=='DESC') {
	         $field = "name";
	          $sort = 'ASC';
	        }else{
	         $field = "name";
	         $sort = 'DESC';
	        }
	      }
	      if($_GET['field']=='designation') { 
	        if($_GET['sorting']=='DESC') {
	         $field = "designation";
	          $sort = 'ASC';
	        }else{
	         $field = "designation";
	         $sort = 'DESC';
	        }
	      }
	   }


		//number of records display on page  
	if (isset($_GET['page'])) {
		$page=$_GET['page'];
	}
	else{
		$page=1;
	}
	if($page == '' || $page ==1){
		$page1=0;
	}else{
		$page1=($page*10)-10;
	}


$query="SELECT id,name,designation FROM users ORDER BY $field $sort  LIMIT ".$page1.",10";
        $sql=mysqli_query($db,$query);

   // search and filter results
if(isset($_POST['search']))
{
		$_SESSION['msg'] ="";
		$valueToSearch = $_POST['valueToSearch'];
	 if(!isset($valueToSearch) || trim($valueToSearch) == '') {
 		$searchErr="Input keywords to search!";
 	}
 	else{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `users` WHERE CONCAT(`id`, `name`, `designation`) LIKE '%".$valueToSearch."%'";
    $sql = filterTable($query);
    $row_cnt = $sql->num_rows;
    if ($row_cnt==0) {
    	$resultErr= "<p style='color: red; margin-left:530px; font-weight: bold;'>NO results found</p>";
    }
    else{
    	$resultErr= "<p style='color: black; margin-left:530px; font-weight: bold;'>Number of rows found:".$row_cnt;"</p>";
    }
    
	}
}



// function to connect and execute the query
function filterTable($query)
{
    // $connect = mysqli_connect("localhost", "root", "", "CRUD");
    $db= mysqli_connect('localhost','root','root','CRUD');
    $filter_Result = mysqli_query($db, $query);
    return $filter_Result;
}

         // mysqli_close($conn);
?>