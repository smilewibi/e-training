<?php require_once('../Connections/Server_HTC.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "pengajar,adm";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$namafolder="guru/img/guru/guru"; //tempat menyimpan file
$con=include("../Connections/Server_HTC.php");
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$jenis_gambar=$_FILES['nama_file']['type'];
	$nama_depan=$_POST['Nma_dpn'];
	$nama_belakang=$_POST['Nma_blkng'];
	$tgl_lhr=$_POST['Tgl_lhr'];
	$tmpt_lhr=$_POST['Tmpt_lhr'];
	$jengkel=$_POST['Jengkel'];
	$email=$_POST['Email'];
	$pss=md5($_POST['Pss']);
	$akses=$_POST['Akses'];
	$no_hp=$_POST['No_hp'];
	$alamat=$_POST['Alamat'];
	$keahlian=$_POST['Kompetensi_inti'];
	$dasar=$_POST['Kompetensi_dsr'];
	$id_guru=$_POST['Id_guru'];
	$gambar = $namafolder . basename($_FILES['nama_file']['name']);
	if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/png")
    {
  if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $gambar)) {
            echo "Gambar berhasil dikirim ".$gambar;
  $sql="UPDATE guru SET Id_guru='$id_guru', Nma_dpn='$nama_depan', Nma_blkng='$nama_belakang', Tgl_lhr='$tgl_lhr', Tmpt_lhr='$tmpt_lhr', Jengkel='$jengkel', Email='$email', Pss='$pss', Akses='$akses', No_hp='$no_hp', Alamat='$alamat', Kompetensi_inti='$keahlian', Kompetensi_dsr='$dasar', Foto='$gambar' WHERE Id_guru='$id_guru'";
  $Result1 = mysql_query($sql, $Server_HTC) or die(mysql_error());
    }
	}

  mysql_select_db($database_Server_HTC, $Server_HTC);

  $updateGoTo = "admsch.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['Id_guru'])) {
  $colname_Recordset1 = $_GET['Id_guru'];
}
mysql_select_db($database_Server_HTC, $Server_HTC);
$query_Recordset1 = sprintf("SELECT * FROM guru WHERE Id_guru = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $Server_HTC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$maxRows_Recordset2 = 7;
$pageNum_Recordset2 = 0;
if (isset($_GET['pageNum_Recordset2'])) {
  $pageNum_Recordset2 = $_GET['pageNum_Recordset2'];
}
$startRow_Recordset2 = $pageNum_Recordset2 * $maxRows_Recordset2;

mysql_select_db($database_Server_HTC, $Server_HTC);
$query_Recordset2 = "SELECT Id_materi,materi.Id_guru,materi.Judul_Materi,Tgl,Video,guru.Id_guru,Nma_dpn,Nma_blkng,Foto FROM `materi`,`guru` WHERE materi.Id_guru=guru.Id_guru ORDER BY `Id_materi` DESC";
$query_limit_Recordset2 = sprintf("%s LIMIT %d, %d", $query_Recordset2, $startRow_Recordset2, $maxRows_Recordset2);
$Recordset2 = mysql_query($query_limit_Recordset2, $Server_HTC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);

if (isset($_GET['totalRows_Recordset2'])) {
  $totalRows_Recordset2 = $_GET['totalRows_Recordset2'];
} else {
  $all_Recordset2 = mysql_query($query_Recordset2);
  $totalRows_Recordset2 = mysql_num_rows($all_Recordset2);
}
$totalPages_Recordset2 = ceil($totalRows_Recordset2/$maxRows_Recordset2)-1;

$queryString_Recordset2 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset2") == false && 
        stristr($param, "totalRows_Recordset2") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset2 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset2 = sprintf("&totalRows_Recordset2=%d%s", $totalRows_Recordset2, $queryString_Recordset2);

$user=$_SESSION['MM_Username'];
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
                        <a href="admsch.php">Profile</a>
                    </li>
                    <li class="active">
                        <a href="dsiswa.php">Data Siswa</a>
                    </li>
                    <li class="active">
                        <a href="eduguru.php">E-Training</a>
                    </li>
                    <li class="active">
                        <a href="logoutgru.php">Log Out</a>
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
<br><br><br><br><br><br>
  <div id="primary">
  <h5><?php echo ($_SESSION['MM_Username']);?></h5>
    <div id="News">
      <div id="picture"><img src="<?php echo $row_Recordset1['Foto']; ?>";></div>
      <p>
      
      </p>
      <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">Id_guru:</td>
            <td><?php echo $row_Recordset1['Id_guru']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Nama Depan :</td>
            <td><input type="text" name="Nma_dpn" value="<?php echo htmlentities($row_Recordset1['Nma_dpn'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Nama Belakang :</td>
            <td><input type="text" name="Nma_blkng" value="<?php echo htmlentities($row_Recordset1['Nma_blkng'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Tanggal Lahir :</td>
            <td><input type="text" name="Tgl_lhr" value="<?php echo htmlentities($row_Recordset1['Tgl_lhr'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Tempat Lahir :</td>
            <td><input type="text" name="Tmpt_lhr" value="<?php echo htmlentities($row_Recordset1['Tmpt_lhr'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Jenis Kelamin :</td>
            <td><select name="Jengkel">
              <option value="Laki-laki" <?php if (!(strcmp("Laki-laki", htmlentities($row_Recordset1['Jengkel'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>>Laki-laki</option>
              <option value="Perempuan" <?php if (!(strcmp("Perempuan", htmlentities($row_Recordset1['Jengkel'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>>Perempuan</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">E-mail:</td>
            <td><input type="text" name="Email" value="<?php echo htmlentities($row_Recordset1['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Password :</td>
            <td><input name="Pss" type="password" id="Pss" value="<?php echo htmlentities($row_Recordset1['Pss'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Nomor Hp :</td>
            <td><input type="text" name="No_hp" value="<?php echo htmlentities($row_Recordset1['No_hp'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right" valign="top">Alamat:</td>
            <td><textarea name="Alamat" cols="50" rows="5"><?php echo htmlentities($row_Recordset1['Alamat'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Kompetensi inti:</td>
            <td><input type="text" name="Kompetensi_inti" value="<?php echo htmlentities($row_Recordset1['Kompetensi_inti'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Kompetensi dasar:</td>
            <td><input type="text" name="Kompetensi_dsr" value="<?php echo htmlentities($row_Recordset1['Kompetensi_dsr'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Foto:</td>
            <td><input name="nama_file" type="file" value="<?php echo htmlentities($row_Recordset1['Foto'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" onClick="MM_validateForm('Pss','','R','Foto','','R');return document.MM_returnValue" value="Update"></td>
          </tr>
        </table>
        <input type="hidden" name="Akses" value="<?php echo htmlentities($row_Recordset1['Akses'], ENT_COMPAT, 'utf-8'); ?>">
        <input type="hidden" name="MM_update" value="form1">
        <input type="hidden" name="Id_guru" value="<?php echo $row_Recordset1['Id_guru']; ?>">
      </form>
      <p>&nbsp;</p>
    </div>
  </div>
  <div id="secondary">
    <div id="panel1">
      <h3>Semua Daftar Putar</h3>
      <center>
      <?php do { ?>
      <div id="Guest">
          <div id="avatar">
            <img src="<?php echo $row_Recordset2['Foto']; ?>">
          </div>
            <a href="eduguru2.php?id=<?php echo $row_Recordset2['Id_materi']; ?>"><h5><?php echo $row_Recordset2['Judul_Materi']; ?> - <?php echo $row_Recordset2['Nma_dpn']; ?> <?php echo $row_Recordset2['Nma_blkng']; ?></h5><?php echo $row_Recordset2['Tgl']; ?></a>
      </div>
     <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
	  <center>
        <table border="0">
          <tr>
            <td><?php if ($pageNum_Recordset2 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, 0, $queryString_Recordset2); ?>"><img src="First.gif"></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_Recordset2 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, max(0, $pageNum_Recordset2 - 1), $queryString_Recordset2); ?>"><img src="Previous.gif"></a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_Recordset2 < $totalPages_Recordset2) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, min($totalPages_Recordset2, $pageNum_Recordset2 + 1), $queryString_Recordset2); ?>"><img src="Next.gif"></a>
                <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_Recordset2 < $totalPages_Recordset2) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset2=%d%s", $currentPage, $totalPages_Recordset2, $queryString_Recordset2); ?>"><img src="Last.gif"></a>
                <?php } // Show if not last page ?></td>
          </tr>
        </table>
      </center>
    </div>
    <div id="event"><br>
      <br>
      <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/HtcMojokerto" data-widget-id="540165141942108160">Tweet oleh @HtcMojokerto</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
    <div id="event"><br>
      <br>
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
</div>
<div id="copyright">Copyright &copy; 2014 - All Rights Reserved - House of Training Centre</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
