<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
$email=$_POST['admin'];
$email_tujuan=$_POST['Tujuan'];
$pesan=$_POST['Pesan'];
$kirim=mail ($email, $email_tujuan,$Pesan, "From: ".$email_anda."/nContent-Type: text/html;charset=iso-8859-1");
if ('$kirim') {
	$isi_pesan = str_replace ("\n","<br>",'$Pesan');
	echo ("Email telah dikirim ke <b>$email_tujuan</b> <br><br>");
	echo ("<b> Isi pesan : </b><br>$Pesan");
}else{
	echo ("Email gagal dikirim");
}
?>
</body>
</html>