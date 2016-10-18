<?php 
	
	require("../../config.php");
	require("functions.php");
	
	//kui on juba sisse loginud siis suunan data lehele
	if (isset($_SESSION["userId"])){
		
			//suunan sisselogimise lehele
			header("Location: data.php");
	}
	
	//echo hash("sha512", "b");
	
	
	//GET ja POSTi muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//echo strlen("äö");
	
	// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupFirstNameError = "";
	$signupLastNameError = "";
	$signupEmail = "";
	$signupGender = "";
	
	// on üldse olemas selline muutja
	if( isset( $_POST["signupEmail"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			// siia jõuan siis kui parool oli olemas - isset
			// parool ei olnud tühi -empty
			
			// kas parooli pikkus on väiksem kui 8 
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
			
			}
			
		}
		
	if(isset($_POST["eesnimi"]))
	{
		if(empty($_POST["eesnimi"])) 
		{
			$signupFirstNameError = "See väli on kohustuslik";
		}
	}
	if(isset($_POST["perekonnanimi"]))
	{
		if(empty($_POST["perekonnanimi"]))
		{
			$signupLastNameError = "See väli on kohustuslik";
		}
	}
	}
	
	
	
	// GENDER
	if( isset( $_POST["signupGender"] ) ){
		
		if(!empty( $_POST["signupGender"] ) ){
		
			$signupGender = $_POST["signupGender"];
			
		}
		
	} 
	
	// peab olema email ja parool
	// ühtegi errorit
	
	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
		) {
		
		// salvestame ab'i
		echo "Salvestan... <br>";
		
		echo "email: ".$signupEmail."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "password hashed: ".$password."<br>";
		
		
		//echo $serverUsername;
		
		// KASUTAN FUNKTSIOONi
		signUp($signupEmail, $password);
		

	}
	
	$error ="";
	if ( isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])
	) {
		$error = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
		
		
	}
?>
<!DOCTYPE html>
<body style="background-color:aquamarine;">
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body>
	<h1>Logi sisse</h1>
		<form method="POST"> 
			<p style="color:red;"><?=$error;?></p>
			
			<input name="loginEmail" placeholder="E-post" type="Email">
			<br><br>
			<input name="loginPassword" placeholder="Parool" type="password">
			<br><br>
			<input type="submit" value="Logi sisse">
			
		</form>
		
	<h1>Loo kasutaja</h1>
		<form method="POST">
			<input name="signupEmail" placeholder="E-post" type="text" value="<?=$signupEmail;?>" />
			<?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input type="password" placeholder="Parool" name="signupPassword" /> 
			<?php echo $signupPasswordError; ?>
			<br><br>
			
			<input name="eesnimi" placeholder="Eesnimi" type="name" />
			<?php echo $signupFirstNameError; ?>
			<br><br>
			
			<input name="perekonnanimi" placeholder="Perekonnanimi" type="surname" />
			<?php echo $signupLastNameError; ?>
			
<h3>Sugu</h3>
			<?php if($signupGender == "Mees") { ?>
			<input type="radio" name="signupGender" value="Mees" checked> Mees<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Mees"> Mees<br>
		<?php } ?>
		
		<?php if($signupGender == "Naine") { ?>
			<input type="radio" name="signupGender" value="Naine" checked> Naine<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Naine"> Naine<br>
		<?php } ?>
		
		<?php if($signupGender == "Muu") { ?>
			<input type="radio" name="signupGender" value="Muu" checked> Muu<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Muu"> Muu<br>
		<?php } ?>
			
			<br><br>
			
			<input type="submit" value="Loo kasutaja">
		</form>	
</body>
</html>
