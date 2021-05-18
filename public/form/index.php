<?php
require '../connect.php';
require '../mail.php';

if (!empty($_SESSION['logged_user'])){
     $userin = $_SESSION['logged_user'];
}
else {
    header("Location: ../ooops.html");
}
$err = array();
 if(isset($_POST['send'])){
     $patinfo = $_POST;
     unset($_POST);
     unset($err);
     
     foreach ($patinfo as $key => $v) {
          if ($key == 'pday' ){
                if($patinfo[$key]  > 0 and $patinfo[$key]  <=31 ){
                }
                     else {
                         $err[] = "Invalid birthday day";
                         break;
                     }
            }
            if ($key == 'pmounth') {
                if($patinfo[$key]  > 0 and $patinfo[$key]  <=12 ){
                 }
                 else {
                      $err[] = "Invalid birthday mounth";
                      break;
                     }
             }
            if ($key == 'pyear') {
                 if($patinfo[$key] > 1900 and $patinfo[$key]  <= 2022  and strlen($patinfo[$key]) == 4){
                 }
                 else {
                     $err[] = "Invalid birthday years";
                     break;
                }
             }
         
             if ($patinfo[$key] == "" or $patinfo[$key] == " " or strlen($patinfo[$key]) < 3){
                 if ($key == 'conrul1' or $key == 'conrul2' or $key == 'pday' or $key == 'pmounth' or $key == 'send') {
                     continue;
                 }
                 if ($key =='ppage'){continue;}
                 else {
                    $err[] = "Пожалуйста,  заполните все поля на странице.";
                    $patinfo[$key]=='';
                    break;
                 }
             }

            if ($patinfo['conrul1']=='1' and $patinfo['conrul2'] =='1') {

                }
             else {
                $err[]='Примите пользовательское соглашение и наши правила';
                 break;
             }
            }

    $fil = array ();
       
            if(!empty($_FILES)) {
                if($_FILES['pfiles']['name']==''){
            $err[]='Пожалуйста приложите к анкете фото';
            }
           
            else {
                 for ($i=0;$i  < sizeof($_FILES['pfiles']);$i++){
                    $name=$_FILES['pfiles']['name'][$i];
                    $tmp=$_FILES['pfiles']['tmp_name'][$i];
                    $size=$_FILES['pfiles']['size'][$i];
                    $type=$_FILES['pfiles']['type'][$i];
                    $distantion='../patients/'.$name;
    
                    if($size > 1500000) { 
                    $err[] = "Максимальна велечина одного файла 1.5МБ";
                        break;
                    }
                    if ($type == 'image/png' or $type == 'image/jpg' or $type == "image/jpeg" ){
                         if (empty($err)){
                           move_uploaded_file($tmp,$distantion);
                           array_push($fil,$distantion);
                        }
                    
                    } 
                }
            }
        }
     
        
     
        if (empty($err)){
          
            sendmessp($patinfo,$fil,$userin);
            
            header('Location: ../index.php?specify=token_confirmed');
        }
     }
   
     




?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<link rel="icon" href="../icons/logo1-восстановлено.png">
	<link rel="stylesheet" href='../frames/smoke-pure.css'>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="index.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<title>Axilium</title>
    
</head>
<body id="bg">

	<!-- HEADER -->
	<header class="sticky-top">

		<nav class="navbar navbar-expand-lg navbar-light" id="menu">
			
			<!-- LOGO -->
			<a href="../index.php" onclick="return up()" class="logo-header mostion"><img class="axilium-logo" src="../icons/logo1-восстановлено.png" alt="logo" width="70" height="45"></a>
			
			<!-- COLLAPSE BTN -->
			<div class="navbar_container">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Togglenavigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>

			<!-- NAVIGATION -->
			<div class="collapse navbar-collapse" id="navbarSupportedContent">

				<ul class="navbar-nav mr-auto">

			        <li class="nav-item active">
						<a href="../index.php"  class="nav-link">Home</a>
					</li>

				</ul>

				<!-- ADD BTN -->			
				<div class="extra-nav" >

				

					<span class="spacer"></span>

					
				</div> <!-- /ADD BTN -->

				<!-- AVTORIZATION PROFILE -->
				<div class="dropdown open" tabindex="0">
				
				<button class="btn btn-secondary dropdown-toggle avtorization" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<a class="menu-item menu-green user-name" href="#">
						<img class="avatar" src="../<?php echo $userin['profile_photo']; ?>">
						<span><?php  echo $userin['name']." ".$userin['surname'];?></span>
					</a>
				</button>
				
				<div class="dropdown-menu avtorization" aria-labelledby="dropdownMenuButton" tabindex="-1">
					<a class="item" href="<?php echo "../profiles.php?id=".$userin['id']; ?>">
						<i class="fa fa-cogs"></i>
						<span>My Profile</span>
					</a>
					<a class="item" href="../logout.php">
						<i class="fa fa-sign-out"></i>
						<span>Logout</span>
					</a>
				</div>
			
			</div> <!-- /AVTORIZATION PROFILE -->

				<!-- LOGIN FORM -->
				
				
			</div> <!-- /navbarSupportedContent -->		

		</nav>
		
	</header> <!-- /HEADER -->
	<!-- BABY -->
	<section class="probootstrap-section">
		
		<div class="container self">
            <?php
            if(!empty($err)){
                echo "<font style='color:red'>".$err[0]."</font>";
            }
            
            ?>
			<form class="simple_form new_notification" id="new_notification" novalidate="novalidate" action="" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
				<h3 class="with-line">Your data</h3>
				
				<div class="box with-padding with-margin">
					
					<div class="wrapper string required notification_notifier_name">
						
						<div class="label">
							<label class="string required" for="notification_notifier_name">First and last name</label>
						</div>
						
						<div class="input">
							<input class="string required" type="text" value="<?php echo $patinfo['pname'] ?>" name="pname" id="notification_notifier_name" required>
						</div>

					</div>
					
					<div class="wrapper tel optional notification_notifier_phone">
						
						<div class="label">
							<label class="tel optional" for="notification_notifier_phone">Phone number</label>
						</div>
						
						<div class="input">
							<input class="string tel optional" type="tel" value="<?php echo $patinfo['pphone'] ?>" name="pphone" id="notification_notifier_phone" required>
						</div>

					</div>
					
					<div class="wrapper email optional notification_notifier_email">
						
						<div class="label">
							<label class="email optional" for="notification_notifier_email">Email address</label>
						</div>

						<div class="input">
							<input class="string email optional" type="email" value="<?php echo $patinfo['pmail'] ?>" name="pmail" id="notification_notifier_email" required >
						</div>

					</div>

				</div>
				<div class="box with-padding with-margin">
					
					<div class="wrapper date optional notification_birthday">
						
						<div class="label">
							<label class="date optional" for="optional notification_birthday">Date of birth</label>
						</div>
						
						<input id="txtDay" type="text" placeholder="DD"  name='pday' maxlength="2" value="<?php echo $patinfo['pday'] ?>" required />
						<input id="txtMonth" type="text" placeholder="MM" name='pmounth' maxlenght="2" value="<?php echo $patinfo['pmounth'] ?>" required/>
						<input id="txtYear" type="text" placeholder="YYYY" name='pyear' maxlenght="4" <?php echo $patinfo['pyear']; ?>required />

					</div>

					<div class="wrapper string optional notification_pesel">
						
						<div class="label">
							<label class="string optional" for="notification_pesel">Passport number</label>
						</div>
						
						<div class="input">
							<input class="string optional" type="text" name="ppesel" value="<?php echo $patinfo['ppesel'] ?>" id="notification_pesel" required>
						</div>

					</div>

					<div class="wrapper string optional notification_city">
						
						<div class="label">
							<label class="string optional" for="notification_city">Address</label>
						</div>

						<div class="input">
							<input class="string optional" type="text" name="pcity" value="<?php echo $patinfo['pcity'] ?>" id="notification_city" required>
						</div>

					</div>
					
				</div>
				
				<h3 class="with-line">Collection information</h3>
				
				<div class="box with-padding with-margin">
					
					<div class="wrapper text optional notification_need_type">
						
						<div class="label">
							<label class="text optional" for="notification_need_type">What do you need money for?</label>
						</div>
						
						<div class="input">
							<textarea class="text optional" maxlength="155" name="ptext" id="notification_need_type" required><?php echo $patinfo['ptext']; ?></textarea>
						</div>

					</div>

					<div class="wrapper string required notification_amount currency">
						
						<div class="label">
							<label class="string required" for="notification_amount">How much do you need?</label>
						</div>
						
						<div class="input ua">
							<input class="string required" type="text" name="pprice" value="<?php echo $patinfo['pprice']; ?>" id="notification_amount" required>
						</div>

					</div>
                    <div class="wrapper string required notification_files">
						
												Upload photo about your project/collect (necessarily).
						
						
						<div class="input ua">
							<input class="string required" type="file" name="pfiles[]" id="notification_files" accept='image/*' multiple="" required>
						</div>

					</div>
					<div class="wrapper text required notification_description">
						
						<div class="label">
							<label class="text required" for="notification_description">Description
								<span>
									<small>Give the story about your ptoject/collect</small>
								</span>
							</label>
						</div>
						
						<div class="input">
							<textarea class="text required" name="pstory" value="" id="notification_description" required><?php echo $patinfo['pstory']; ?></textarea>
						</div>

					</div>

					<div class="wrapper url optional notification_facebook_url">
						
						<div class="label">
							<label class="url optional" for="notification_facebook_url">Facebook page</label>
						</div>
						
						<div class="input">
							<input class="string url optional" type="url" value="<?php echo $patinfo['ppage'] ?>" name="ppage" id="notification_facebook_url">
						</div>

					</div>

				</div>

				<div class="approvals">

					<h3 class="with-line">Consent</h3>

					<div class="box with-padding with-margin justify-text">
						
						<div class="without-labels">
							
							<div class="wrapper boolean optional notification_siepomaga_terms">
								
								<div class="input">									
									<input class="boolean optional" type="checkbox" value="1" name="conrul1" id="notification_siepomaga_terms" required>
									<label class="checkbox" for="notification_siepomaga_terms">
										I accept <a class="remote-modal" href="#">rules Axilium</a>
									</label>
								</div>

							</div>

							<div class="wrapper boolean optional notification_needy_data_proceeding">
								
								<div class="input">
									<input class="boolean optional" type="checkbox" value="1" name="conrul2" id="notification_needy_data_proceeding" required> 
									<label class="checkbox">										
										<span>I agree to the processing of personal data about my health by the Axilium Foundation for the purposes specified in 
											<a class="remote-modal" href="#">Axilium privacy policy</a>
										</span>
									</label>
								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="text-center">
					<button class="sp-button green with-icon" name='send'>
						<span class="icon">
							<i class="fa fa-check"></i>
						</span>
						<span class="text">Send</span>
					</button>
					<div class="sp-privacy-policy">Інформацію про обробку персональних даних можна знайти в
						<a class="remote-modal" href="#">політиці конфіденційності Axilium</a>
					</div>
				</div>

			</form>

		</div> <!-- /container -->

	</section> <!-- /BABY -->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->	
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<!-- ANIMATION -->
	<link rel="stylesheet" href="animate.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script>
		new WOW().init();
	</script>
	<script>
		document.getElementById('sign').onclick = function() {
			document.getElementById('sign').classList.add('active');
			document.getElementById('sign_in').classList.remove('active');
		};

		document.getElementById('sign_in').onclick = function() {
			document.getElementById('sign').classList.remove('active');
			document.getElementById('sign_in').classList.add('active');
		};
	</script>
<script src="../frames/smoke-pure.js"></script>
	<script src="script.js"></script>

</body>
</html>

<!-- ВІДДІЛЕННЯ МІЖ БЛОКАМИ -->
<!-- 	<section class="bg-default">
	<div class="container">
		<div class="divider"></div>
	</div>

	.divider {
	display: block;
	width: 100%;
	height: 1px;
	background: #c7c7c7;
}
</section> -->