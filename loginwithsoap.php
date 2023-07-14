<?php  

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

$url = 'https://mail.hariffdp.com/service/soap';

$data = [
    "Header" => [
        "context" => [
            "_jsns" => "urn:zimbra",
            "userAgent" => ["name" => "curl", "version" => "8.8.15"],
        ],
    ],
    "Body" => [
        "AuthRequest" => [
            "_jsns" => "urn:zimbraAccount",
            "account" => ["_content" => $username, "by" => "name"],
            "password" => $password,
        ],
    ],
];


$encodedData = json_encode($data);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type:application/json'
));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);
$result = curl_exec($curl);
curl_close($curl);
$mark   = 'AUTH_FAILED';

if (str_contains($result, $mark)) {
    return false;
	die;
}
return true;

?>

<html>
<head>
<title>TEST LOGIN ZIMBRA</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="body_bg">
<div <div align="center">

<h3>TEST LOGIN ZIMBRA</h3>
    <form id="login-form" method="post" action="loginwithsoap.php" >
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
