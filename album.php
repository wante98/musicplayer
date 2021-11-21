<?php include("includes/header.php");

if(isset($_GET['id'])){
  $albumId = $_GET['id'];
}else{
  header("Location: index.php");
}
$album = new Album($con, $albumId);
$artist = new Artist($con,$album['artist']);
echo $album->getTitle();
echo $artist->getArtist();

//$album = mysqli_fetch_array($albumQuery);
//$album = mysqli_fetch_array($albumQuery);
//echo $album['title'];

// $artistId =$album['artist'];
// $artistQuery = mysqli_query($con,"SELECT * FROM artists WHERE id = $artistId");
// $artist = mysqli_fetch_array($artistQuery);
// echo $album['title']."<br>";
// echo $artist['name'];

?>
<?php include("includes/footer.php"); ?>
