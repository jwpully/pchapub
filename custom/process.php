<?PHP

/* This program uses convention over configuration.  It will have certain expectations, listed below.  
captcha will always equal 3 and form element will always be named "captcha" */

include '../configuration.php';
$conFile = new JConfig();

$host = $conFile->host;
$user = $conFile->user;
$password = $conFile->password;
$db = $conFile->db;
$dbprefix = $conFile->dbprefix;
$site_email = $conFile->mailfrom;

// Create connection
$con = new mysqli($host, $user, $password, $db);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 

$error = 0;

if($_POST['captcha'] == 3){

/* Begin contact form */

    if($_POST['form_id'] == 'contact'){
	$error = 0;
	if(strlen($_POST['name']) < 1) { $error = $error + 1; }
	if(strlen($_POST['subject']) < 1) { $error = $error + 1; }
	if(strlen($_POST['email']) < 1) { $error = $error + 1; }
	if(strlen($_POST['message']) < 1) { $error = $error + 1; }

	if($error == 0){
	        $name = 'Name: ' . mysqli_real_escape_string($con,$_POST['name']);
        	$email = 'Email: ' . mysqli_real_escape_string($con,$_POST['email']);
        	$message = 'Message: ' . mysqli_real_escape_string($con,$_POST['message']);

        	$body = $name."<br /><br />".$email."<br /><br />".$message;

	        $sql = "
        	INSERT INTO ".$db.".".$dbprefix."corejoomla_messages (asset_id, asset_name, subject, description, params, created)
        	VALUES(
                	1                
                	, 'contact.form'
                	, '".mysqli_real_escape_string($con,$_POST['subject'])."'
                	, '".$body."'
                	, '{\"template\":\"wm-mail-basic.tpl\",\"placeholders\":{}\"}}'
                	, NOW()
	        )
	        ";
	        $message_id = 0;
	        if ($con->query($sql) === TRUE) {
	            $message_id = mysqli_insert_id($con);
	        } 


	        $sql = "INSERT INTO ".$db.".".$dbprefix."corejoomla_messagequeue (status, to_addr, html, message_id, params, created)";
	        $sql .= " VALUES(0, '".$site_email."', 1, ".$message_id.", '{}', NOW());";

	        $con->query($sql);
	}
        $con->close();


    }

/* End contact form */
/* Begin alterations form */
    if($_POST['form_id'] == 'alter'){
        # POST VALUES

        $firstname = mysqli_real_escape_string($con,$_POST['firstname']);
        $lastname = mysqli_real_escape_string($con,$_POST['lastname']);
        $email = mysqli_real_escape_string($con,$_POST['email']);
	$address = mysqli_real_escape_string($con,$_POST['address']);
        if(mysqli_real_escape_string($con,$_POST['fence'])){ $fence = 1; } else{ $fence = 0; }
        if(mysqli_real_escape_string($con,$_POST['shed'])){ $shed = 1; } else{ $shed = 0; }
        if(mysqli_real_escape_string($con,$_POST['pool'])){ $pool = 1; } else{ $pool = 0; }
        if(mysqli_real_escape_string($con,$_POST['room'])){ $room = 1; } else{ $room = 0; }
        if(mysqli_real_escape_string($con,$_POST['driveway'])){ $driveway = 1; } else{ $driveway = 0; }
        if(mysqli_real_escape_string($con,$_POST['garage'])){ $garage = 1; } else{ $garage = 0; }
        if(mysqli_real_escape_string($con,$_POST['deck'])){ $deck = 1; } else{ $deck = 0; }
        if(mysqli_real_escape_string($con,$_POST['other'])){ $other = 1; } else{ $other = 0; }

        $structureother = mysqli_real_escape_string($con,$_POST['structureother']);
        $builder = mysqli_real_escape_string($con,$_POST['builder']);
        $contractor = mysqli_real_escape_string($con,$_POST['contractor']);
        $size = mysqli_real_escape_string($con,$_POST['size']);
        $roof = mysqli_real_escape_string($con,$_POST['roof']);
        $cost = mysqli_real_escape_string($con,$_POST['cost']);
        $completion = mysqli_real_escape_string($con,$_POST['completion']);
        $description = mysqli_real_escape_string($con,$_POST['description']);
     	if(strlen($_POST['firstname']) < 1) { $error = $error + 1; }
	if(strlen($_POST['lastname']) < 1) { $error = $error + 1; }
	if(strlen($_POST['email']) < 1) { $error = $error + 1; }
	if(strlen($_POST['address']) < 1) { $error = $error + 1; }
	if(strlen($_POST['builder']) < 1) { $error = $error + 1; }
	if(strlen($_POST['size']) < 1) { $error = $error + 1; }
	if(strlen($_POST['cost']) < 1) { $error = $error + 1; }
	if(strlen($_POST['completion']) < 1) { $error = $error + 1; }
	if(strlen($_POST['description']) < 1) { $error = $error + 1; }
	if($fence == 0 && $shed == 0 && $pool == 0 && $room == 0 && $driveway == 0 && $garage == 0 && $deck == 0 && $other == 0) { $error = $error + 1; }

	if($error == 0){
		$file1 = 'No Attachment';
		$file2 = 'No Attachment';
		$file3 = 'No Attachment';

		if(isset($_POST['submit'])){
		        $target_dir = "../uploads/";
			if($_FILES["file1"]["name"]){
			        $file1 = basename($_FILES["file1"]["name"]);
			        $file1Type = pathinfo($file1,PATHINFO_EXTENSION);
	       		        $file1 = basename($file1, $file1Type).uniqid().".".$file1Type;
				move_uploaded_file($_FILES["file1"]["tmp_name"], $target_dir.$file1);
			}

	                if($_FILES["file2"]["name"]){
		                $file2 = basename($_FILES["file2"]["name"]);
	        	        $file2Type = pathinfo($file2,PATHINFO_EXTENSION);
	                	$file2 = basename($file2, $file2Type).uniqid().".".$file2Type;
				move_uploaded_file($_FILES["file2"]["tmp_name"], $target_dir.$file2);
			}

	                if($_FILES["file3"]["name"]){
       		                $file3 = basename($_FILES["file3"]["name"]);
       	        	        $file3Type = pathinfo($file3,PATHINFO_EXTENSION);
       	               		$file3 = basename($file3, $file3Type).uniqid().".".$file3Type;
				move_uploaded_file($_FILES["file3"]["tmp_name"], $target_dir.$file3);
			}
	        }


		$db_lite = new SQLite3('/home4/ab8236/mydjango/db.sqlite3.bkup17') or die('Unable to open database');
	        $result = $db_lite->query("SELECT * FROM cb_gen_account_num_vw WHERE prefix = '".$address."'") or die('Query failed');
	        while ($row = $result->fetchArray())
	        {

	          $account_id = $row['id'];
	          $property_id = $row['property_id'];
	        }

	        $db_lite->query("INSERT INTO cb_alterations (description
                                                     , status
                                                     , account_id
                                                     , property_id
                                                     , builder
                                                     , completion
                                                     , cost
                                                     , deck
                                                     , driveway
                                                     , email
                                                     , fence
                                                     , file1
                                                     , file2
                                                     , file3
                                                     , garage
                                                     , other
                                                     , pool
                                                     , roof
                                                     , room
                                                     , shed
                                                     , size
                                                     , structureother
                                                     , requested, waiver) VALUES(
                                                     '{$description}'
                                                     , 'Pending'
                                                     , {$account_id}
                                                     , {$property_id}
                                                     , '{$builder}'
                                                     , '{$completion}'
                                                     , '{$cost}'
                                                     , '{$deck}'
                                                     , '{$driveway}'
                                                     , '{$email}'
                                                     , '{$fence}'
                                                     , '{$file1}'
                                                     , '{$file2}'
                                                     , '{$file3}'
                                                     , '{$garage}'
                                                     , '{$other}'
                                                     , '{$pool}'
                                                     , '{$roof}'
                                                     , '{$room}'
                                                     , '{$shed}'
                                                     , '{$size}'
                                                     , '{$structureother}'
                                                     , CURRENT_DATE, '0'
                                                     )") or die('Query failed');


                $body = "first name == ".$firstname."<br />";
                $body .= "last name == ".$lastname."<br />";
                $body .= "email == ".$email."<br />";
                $body .= "address == ".$address."<br />";
                if($fence == 1){
                    $body .= "fence == Yes<br />";
                }
                if($shed == 1){
                    $body .= "shed == Yes<br />";
                }
                if($pool == 1){
                    $body .= "pool == Yes<br />";
                }
                if($room == 1){
                    $body .= "room == Yes<br />";
                }
                if($driveway == 1){
                    $body .= "driveway == Yes<br />";
                }
                if($garage == 1){
                    $body .= "garage == Yes<br />";
                }
                if($deck == 1){
                    $body .= "deck == Yes<br />";
                }
                if($other == 1){
                    $body .= "other == Yes<br />";
                    $body .= "structure other == ".$structureother."<br />";
                }

                $body .= "builder == ".$builder."<br />";
                $body .= "contractor == ".$contractor."<br />";
                $body .= "size == ".$size."<br />";
                $body .= "roof == ".$roof."<br />";
                $body .= "cost == ".$cost."<br />";
                $body .= "completion == ".$completion."<br />";
                $body .= "description == ".$description."<br />";
                if($file1 != 'No Attachment'){
                    $body .= "file1 == http://linexxa.com/pchatest2/uploads/".$file1."<br />";
                }
                if($file2 != 'No Attachment'){
                    $body .= "file2 == http://linexxa.com/pchatest2/uploads/".$file2."<br />";
                }
                if($file3 != 'No Attachment'){
                    $body .= "file3 == http://linexxa.com/pchatest2/uploads/".$file3."<br />";
                }

                        $sql = "
                        INSERT INTO ".$db.".".$dbprefix."corejoomla_messages (asset_id, asset_name, subject, description, params, created)
                        VALUES(
                                2
                                , 'alteration.form'
                                , 'New Alteration Request Submission'
                                , '".$body."'
                                , '{\"template\":\"wm-mail-basic.tpl\",\"placeholders\":{}\"}}'
                                , NOW()
                        )
                        ";
                        $message_id = 0;
                        if ($con->query($sql) === TRUE) {
                            $message_id = mysqli_insert_id($con);
                        }

                        $sql = "INSERT INTO ".$db.".".$dbprefix."corejoomla_messagequeue (status, to_addr, html, message_id, params, created)";
                        $sql .= " VALUES(0, '".$site_email."', 1, ".$message_id.", '{}', NOW());";

                        $con->query($sql);

                        $con->close();

	}
    }
/* End Alterations form */
/* Begin join the mail list form */
    if($_POST['form_id'] == 'join'){
	$error = 0;
	if(strlen($_POST['name']) < 1) { $error = $error + 1; }
	if(strlen($_POST['email']) < 1) { $error = $error + 1; }
	if(strlen($_POST['address']) < 1) { $error = $error + 1; }

	if($error == 0){
	        $name = 'Name: ' . mysqli_real_escape_string($con,$_POST['name']);
	        $email = 'Email: ' . mysqli_real_escape_string($con,$_POST['email']);
	        $address = 'Address: ' . mysqli_real_escape_string($con,$_POST['address']);

	        $body = $name."<br /><br />".$email."<br /><br />".$address;

	        $sql = "
	        INSERT INTO ".$db.".".$dbprefix."corejoomla_messages (asset_id, asset_name, subject, description, params, created)
	        VALUES(
	                2
	                , 'maillist.form'
	                , 'New Mail List Submission'
	                , '".$body."'
	                , '{\"template\":\"wm-mail-basic.tpl\",\"placeholders\":{}\"}}'
	                , NOW()
	        )
	        ";
	        $message_id = 0;
	        if ($con->query($sql) === TRUE) {
	            $message_id = mysqli_insert_id($con);
	        } 

	        $sql = "INSERT INTO ".$db.".".$dbprefix."corejoomla_messagequeue (status, to_addr, html, message_id, params, created)";
	        $sql .= " VALUES(0, '".$site_email."', 1, ".$message_id.", '{}', NOW());";

	        $con->query($sql);
	}
        $con->close();

    }
/* End join the mailing list form */

	if($error == 0){
		header( 'Location: '. $_POST['redirect']);
	} else {
		header( 'Location: '. $_POST['error_redirect']);
	}

} 
else { header( 'Location: '. $_POST['error_redirect']); }


