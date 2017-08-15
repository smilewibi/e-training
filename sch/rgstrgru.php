<?php require_once('../Connections/Server_HTC.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_Server_HTC, $Server_HTC);
$query_Recordset1 = "SELECT * FROM guru";
$Recordset1 = mysql_query($query_Recordset1, $Server_HTC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$namafolder="guru/img/guru/guru"; //tempat menyimpan file
$con=include("../Connections/Server_HTC.php");
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$jenis_gambar=$_FILES['nama_file']['type'];
	$nama_depan=$_POST['Nma_dpn'];
	$id_guru=$_POST['Id_guru'];
	$Nma_blkng=$_POST['Nma_blkng'];
	$Tgl_lhr=$_POST['Tgl_lhr'];
	$Tmpt_lhr=$_POST['Tmpt_lhr'];
	$Jengkel=$_POST['Jengkel'];
	$Email=$_POST['Email'];
	$Pss=$_POST['Pss'];
	$Akses=$_POST['Akses'];
	$No_hp=$_POST['No_hp'];
	$Alamat=$_POST['Alamat'];
	$Kompetensi_inti=$_POST['Kompetensi_inti'];
	$Kompetensi_dsr=$_POST['Kompetensi_dsr'];
	$Judul_materi=$_POST['Judul_materi'];
	$encript=md5($Pss);
	$gambar = $namafolder . basename($_FILES['nama_file']['name']); 
    if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/png")
    {
  if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $gambar)) {
            echo "Gambar berhasil dikirim ".$gambar;
            $sql="INSERT INTO `guru` (`Id_guru`, `Nma_dpn`, `Nma_blkng`, `Tgl_lhr`,`Tmpt_lhr`, `Jengkel`, `Email`, `Pss`, `Akses`, `No_hp`, `Alamat`, `Kompetensi_inti`, `Kompetensi_dsr`, `Judul_materi`, `Foto`) VALUES ('$id_guru','$nama_depan','$Nma_blkng','$Tgl_lhr','$Tmpt_lhr','$Jengkel','$Email','$encript','$Akses','$No_hp','$Alamat','$Kompetensi_inti','$Kompetensi_dsr','$Judul_materi','$gambar')";
			 $res=mysql_query($sql) or die (mysql_error());
		}
	}

  mysql_select_db($database_Server_HTC, $Server_HTC);

	  $insertGoTo = "rgstrskssrgu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="../images/demo/htc ico.ico"/>
<title>House of Training Center</title>
<link rel="stylesheet" href="datepicker/reset.css" type="text/css">
<link rel="stylesheet" href="datepicker/default.css" type="text/css">
<link href="../styles/boilerplate.css" rel="stylesheet" type="text/css">
<link href="../styles/css.css" rel="stylesheet" type="text/css">
<link href="../styles/bootstrap.css" rel="stylesheet">
<link href="../styles/bootstrap-responsive.css" rel="stylesheet">
<!-- 
To learn more about the conditional comments around the html tags at the top of the file:
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
* insert the link to your js here
* remove the link below to the html5shiv
* add the "no-js" class to the html tags at the top
* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 
-->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    <style>
        .navbar .popover {
            width: 400px;
            -webkit-border-top-left-radius: 0px;
            -webkit-border-bottom-left-radius: 0px;
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
            overflow: hidden;
        }

        .navbar .popover-content {
            text-align: center;
        }

        .navbar .popover-content img {
            height: 212px;
            max-width: 250px;
        }

        .navbar .dropdown-menu {
            -webkit-border-top-right-radius: 0px;
            -webkit-border-bottom-right-radius: 0px;
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;

            -webkit-box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
        }

        .navbar .dropdown-menu > li > a:hover {
            background-image: none;
            color: white;
            background-color: rgb(0, 129, 194);
            background-color: rgba(0, 129, 194, 0.5);
        }

        .navbar .dropdown-menu > li > a.maintainHover {
            color: white;
            background-color: #0081C2;
        }
    </style>

    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
    </script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="merk">HTC Training Centre</div>
          <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active">
                        <a href="../index.php">Home Page</a>
                    </li>
                    <li class="active">
                        <a href="../franchise.php">Franchise</a>
                    </li>
                    <li class="active">
                        <a href="../education.php">Hot Info</a>
                    </li>
                    <li class="active">
                        <a href="../contact.php">Contact Us</a>
                    </li>
                    <li class="active">
                        <a href="../loginsch.php">E-Training</a>
                    </li>
                    <li class="active">
                        <a href="../event/index.php">HTC Event</a>
                    </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
    <script src="../styles/jquery.menu-aim.js" type="text/javascript"></script>
    <script src="../styles/bootstrap.min.js" type="text/javascript"></script>
  <div id="main">
  <br><br><br><br>
      <h2>Register Tutor</h2>
      <h7>Do best for others</h7>
      <br><br>
      <center>
    <form method="post" enctype="multipart/form-data" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">Nama Depan:</td>
          <td><input name="Nma_dpn" type="text" id="Nma_dpn" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Nama Belakang:</td>
          <td><input name="Nma_blkng" type="text" id="Nma_blkng" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Tanggal Lahir:</td>
          <td><input name="Tgl_lhr" type="text" id="datepicker-example1" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Tempat Lahir:</td>
          <td><input name="Tmpt_lhr" type="text" id="Tmpt_lhr" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Jenis Kelamin:</td>
          <td><select name="Jengkel">
            <option value="Laki-laki" <?php if (!(strcmp("Laki-laki", ""))) {echo "SELECTED";} ?>>Laki-Laki</option>
            <option value="Perempuan" <?php if (!(strcmp("Perempuan", ""))) {echo "SELECTED";} ?>>Perempuan</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">E-mail:</td>
          <td><input name="Email" type="text" id="Email" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Password:</td>
          <td><input name="Pss" type="password" id="Pss" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Nomor Hp:</td>
          <td><input name="No_hp" type="text" id="No_hp" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Alamat:</td>
          <td><textarea name="Alamat" cols="50" rows="5" id="Alamat"></textarea></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Kompetensi Keahlian:</td>
          <td><input name="Kompetensi_inti" type="text" id="Kompetensi_inti" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Kompetensi Dasar:</td>
          <td><input name="Kompetensi_dsr" type="text" id="Kompetensi_dsr" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Foto:</td>
          <td><input name="nama_file" type="file" id="nama_file" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" onClick="MM_validateForm('Nma_dpn','','R','Nma_blkng','','R','Tgl_lhr','','R','Tmpt_lhr','','R','Email','','RisEmail','Pss','','R','No_hp','','RisNum','Alamat','','R','Kompetensi_inti','','R','Kompetensi_dsr','','R','Foto','','R');return document.MM_returnValue" value="Daftar"></td>
        </tr>
      </table>
      <input name="Judul_materi" type="hidden" id="Judul_materi" value="" size="32">
      <input type="hidden" name="Id_guru" value="">
      <input type="hidden" name="Akses" value="pengajar">
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    </center>
    <script type="text/javascript" src="datepicker/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="datepicker/zebra_datepicker.js"></script>
    <script type="text/javascript" src="datepicker/core.js"></script>
    <p>&nbsp;</p>
</div>
<div id="footer">
  <div id="try"><a class="twitter-timeline" data-dnt="true" href="https://twitter.com/HtcMojokerto" data-widget-id="540165141942108160">Tweet oleh @HtcMojokerto</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
<div id="tweet">
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <div class="fb-page" data-href="https://www.facebook.com/pages/The-House-of-Training-Centre/703358933092439?ref=hl" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/The-House-of-Training-Centre/703358933092439?ref=hl"><a href="https://https://www.facebook.com/pages/The-House-of-Training-Centre/703358933092439?ref=hl">The House or Training Centre</a></blockquote></div></div>
    </div>
    <div id="tweet">
   <h1>HTC Event</h1>
  <center>
        <a href="../event/index.php"><img src="../images/demo/utk web.png"></a>
    </center></div>
  <div id="tweet">
   <h1>Try It</h1>
   <a href="#"><center><img src="../images/demo/elerning.jpg"></center></a></div>
</div>
</div>
  <div id="copyright">Copyright &copy; 2014 - All Rights Reserved - House of Training Centre</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
