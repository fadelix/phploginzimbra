<?php  
// PHP Login page Using Zimbra mail account
// mfadly.n@gmail.com
// siabah.com

if (isset($_POST['userid']) and isset($_POST['userpass'])){
	
  $username = $_POST['userid'];
  $password = $_POST['userpass'];
  if (zimbraLogin($username,$password)){
    echo "<b>LOGIN ZIMBRA VALID";
      }else{
    echo "<b><font color=red>LOGIN ZIMBRA TIDAK VALID</font>";
      }
  }

function zimbraLogin($username, $password)

	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_COOKIE, 'ZM_TEST=true');
		curl_setopt($ch, CURLOPT_REFERER, "https://yourzimbra.com/"); //Set your zimbra mail server here
		curl_setopt($ch, CURLOPT_URL, "https://yourzimbra.com/"); //Set your zimbra mail server here
		curl_setopt($ch, CURLOPT_VERBOSE, 0); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Disable curl validating SSL cert - needed for self-signed
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_FAILONERROR, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0); // Allow auto redirect page
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return value into a variable
		curl_setopt($ch, CURLOPT_TIMEOUT, 0); // Setting waktu timeout 0
		curl_setopt($ch, CURLOPT_HEADER, 1); // Set header
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "loginOp=login&username=$username&password=$password&client=preferred");
		$result = curl_exec($ch);
		curl_close($ch);		
		$values = explode("
",$result);

		foreach($values as $key => $value)

		{

			list($start,$good) = array_pad(explode(':', $value),2,null);
			// Baca header Location, kondisi ini untuk mengecek redirect page setelah login valid
			if($start == "Location")
			{
				// Valid jika exist
				// header($values[$key]);
				return true;
				die;
			}
		}
		// Tidak valid 
		return false;
	}	
?>

<html>
<head>
<title>TEST LOGIN ZIMBRA</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="body_bg">
<div <div align="center">

<h3>TEST LOGIN ZIMBRA</h3>
    <form id="login-form" method="post" action="loginzimbra.php" >
        <table border="0.5" >
            <tr>
                <td><label for="userid">User Name</label></td>
                <td><input type="text" name="userid" id="userid"></td>
            </tr>
            <tr>
                <td><label for="userpass">Password</label></td>
                <td><input type="password" name="userpass" id="userpass"></input></td>
            </tr>
			
            <tr>
                <td><input type="submit" value="Submit" />
                <td><input type="reset" value="Reset"/>
            </tr>
        </table>
    </form>
		</div>
</body>
</html>
