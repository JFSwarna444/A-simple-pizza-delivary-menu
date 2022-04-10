<?php


		

	//can see output in searchber link//
	
	// if(isset($_GET['submit'])){
	// 	echo $_GET['email'];  
	// 	echo $_GET['Title'];
	// 	echo $_GET['ingredients'];
	// }



//can't see output in searchber link//

// if(isset($_POST['submit'])){
// 		echo $_POST['email'];
// 		echo $_POST['Title'];
// 		echo $_POST['ingredients'];
//  	}




 	//cross site scripting attacks(JavaScripts)
	
	// if(isset($_POST['submit'])){
	// 	echo htmlspecialchars($_POST['email']);
	// 	echo htmlspecialchars($_POST['Title']);
	// 	echo htmlspecialchars($_POST['ingredients']);
 // 	}




	///form validation///

	// if(isset($_POST['submit'])){

	// 	//check email
	// 	if(empty($_POST['email'])){
	// 		echo "an email is required <br />";
	// 	}
	// 	else{
	// 		echo htmlspecialchars($_POST['email']);
	// 	}


		//check Title
	// 	if(empty($_POST['Title'])){
	// 		echo "a Title is required <br />";
	// 	}
	// 	else{
	// 		echo htmlspecialchars($_POST['Title']);
	// 	}


	// 	//check ingredients
	// 	if(empty($_POST['ingredients'])){
	// 		echo "at least ingredients is required <br />";
	// 	}
	// 	else{
	// 		echo htmlspecialchars($_POST['ingredients']);
	// 	}
	// }   

	//end of POST check
	
	
		

		include('config/db_connect.php');

		$Title =$email = $ingredients = '';
		$errors = array('email'=>'','Title'=>'','ingredients'=>'');

	///Filters & More Validation///
	if(isset($_POST['submit'])){


		if(empty($_POST['email'])){
			$errors['email']= "An email is required <br />";
		}else{
			$email =$_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email']= 'email must be a valid email address';
			}
		}

			//check Title
		if(empty($_POST['Title'])){
			$errors['Title']= "a Title is required <br />";
		}
		else{
			$Title =$_POST['Title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $Title)){
				$errors['Title'] ='Title must be letters and spaces only';
			}
		}


		//check ingredients
		if(empty($_POST['ingredients'])){
			$errors['ingredients'] = "at least ingredients is required <br />";
		}
		else{
			$ingredients =$_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors['ingredients']= 'ingredients must be comma seperated list';
			}
		}


		if(array_filter($errors)){
			//echo 'errors in the form';
		}
		else{
			

			$email = mysqli_real_escape_string($conn, $_POST['email']);
		 	$Title = mysqli_real_escape_string($conn, $_POST['Title']);
		 	$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);


		 	//create sql
		 	$sql = "INSERT INTO pizzas(Title,email,ingredients)VALUES('$Title','$email','$ingredients')";



		 	//save to db and check//
		 	if(mysqli_query($conn, $sql)){
		 		//success
		 	header ('Location: index.php');
		 	}
		 	else{
		 		//error
		 		echo 'query error: '.mysqli_error($conn);
		 	}

		 	//echo 'from is valid';
			
		}




		 }

		
	

?>









<!DOCTYPE html>
<html>


	<?php include('templates/header.php'); ?>
	
	<section class="container grey-text">
		<h4 class="center">Add a Pizza</h4>
		<form class="white" action="<?php echo$_SERVER['PHP_SELF'] ?>" method="POST">
			<lebel>Your email:</lebel>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email )?>" >
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<lebel>Pizza Title:</lebel>
			<input type="text" name="Title" value="<?php echo htmlspecialchars($Title )?>">
			<div class="red-text"><?php echo $errors['Title']; ?></div>
			<lebel>Ingredients (comma separated):</lebel>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients )?>">
			<div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<div class="center">
				<input type="submit"  name="submit" value="submit" class="btn brand z-depth-0">
			</div>
		</from>
	</section>

	<?php include("templates/footer.php"); ?>



</body>
</html>