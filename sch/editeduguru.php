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

$namafolder="guru/video/"; //tempat menyimpan file
$con=include("../Connections/Server_HTC.php");
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	$jenis_video=$_FILES['nama_file']['name'];
	$id_guru=$_POST['Id_guru'];
	$judul_materi=$_POST['Judul_Materi'];
	$tgl=$_POST['Tgl'];
	$keahlian=$_POST['Kompetensi_inti'];
	$dasar=$_POST['Kompetensi_dsr'];
	$materi=$_POST['Materi'];
	$id_materi=$_POST['Id_materi'];
	$video=$namafolder . basename($_FILES['nama_file']['name']);
	if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $video)) {
			echo "Video berhasil dikirim ".$video;
  $sql="UPDATE materi SET Id_guru='$id_guru', Judul_Materi='$judul_materi', Tgl='$tgl', Video='$video', Kompetensi_inti='$keahlian', Kompetensi_dsr='$dasar', Materi='$materi' WHERE Id_materi='$id_materi'";

  mysql_select_db($database_Server_HTC, $Server_HTC);
  $Result1 = mysql_query($sql, $Server_HTC) or die(mysql_error());

  $updateGoTo = "eduguru.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}
$user=$_SESSION['MM_Username'];
mysql_select_db($database_Server_HTC, $Server_HTC);
$query_Recordset1 = "SELECT Id_guru, Nma_dpn, Nma_blkng, Tgl_lhr, Tmpt_lhr, Jengkel, Email, No_hp, Alamat, Kompetensi_inti, Kompetensi_dsr, Judul_materi, Foto FROM guru WHERE Email='$user'";
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

$colname_Recordset3 = "-1";
if (isset($_GET['Id_materi'])) {
  $colname_Recordset3 = $_GET['Id_materi'];
}
mysql_select_db($database_Server_HTC, $Server_HTC);
$query_Recordset3 = sprintf("SELECT * FROM materi WHERE Id_materi = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $Server_HTC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$queryString_Recordset3 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset3") == false && 
        stristr($param, "totalRows_Recordset3") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset3 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset3 = sprintf("&totalRows_Recordset3=%d%s", $totalRows_Recordset3, $queryString_Recordset3);
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
      <form method="post" name="form2" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">Id_materi:</td>
            <td><?php echo $row_Recordset3['Id_materi']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Judul Materi:</td>
            <td><input type="text" name="Judul_Materi" value="<?php echo htmlentities($row_Recordset3['Judul_Materi'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Video:</td>
            <td><input type="file" name="nama_file" value="<?php echo htmlentities($row_Recordset3['Video'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Kompetensi Keahlian:</td>
            <td><input type="text" name="Kompetensi_inti" value="<?php echo htmlentities($row_Recordset3['Kompetensi_inti'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Kompetensi Dasar:</td>
            <td><input type="text" name="Kompetensi_dsr" value="<?php echo htmlentities($row_Recordset3['Kompetensi_dsr'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">Materi:</td>
            <td><textarea name="Materi" cols="5" rows=""><?php echo $row_Recordset3['Materi']; ?></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input type="submit" value="Update"></td>
          </tr>
        </table>
        <input type="hidden" name="Id_guru" value="<?php echo htmlentities($row_Recordset3['Id_guru'], ENT_COMPAT, 'utf-8'); ?>">
        <input type="hidden" name="Tgl" value="<?php include('waktu1.php'); ?>">
        <input type="hidden" name="MM_update" value="form2">
        <input type="hidden" name="Id_materi" value="<?php echo $row_Recordset3['Id_materi']; ?>">
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
     </center>
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

mysql_free_result($Recordset3);
?>