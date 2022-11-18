<?php
include_once("../../lib/Session.Class.php");
Session::init();

if(!Session::sessionUser()){
	header("Location: index.php");
}else{

include_once("../../lib/Access.Class.php");
$access = new Access();

$idProfile = $_SESSION["sessionUser"]->ID_profiles;
$searchAccess = $access->searchAccess($idProfile);
?>

<nav>
	<ul class="nav">
		<?php
		if(in_array(1, $searchAccess)){
		?>
			<li><a href="home.php">Menús</a></li>
		<?php
		}
		?>
	</ul>
</nav>

<?php
$access = null;
} //Fin de else
?>