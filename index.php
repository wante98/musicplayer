<?php include ("includes/includedFiles.php"); ?>

<h1 class="pageHeadingBig">為你精選</h1>

<div class="gridViewContainer">
	<?php
		$albumQuery = mysqli_query($con,"select * from albums order by rand() Limit 10");
		while($row = mysqli_fetch_array($albumQuery)){
			//echo $row['title']."<br>";
			echo "<div class='gridViewItem'>";
			echo "<a href='album.php?id=" .$row['id']. "'>";
			echo "<img src='".$row['artworkPath']."'>";
			echo "<div class='gridViewInfo'>".$row['title']."</div>";
			echo "</div>";
			//echo "Wayne Yu";

		}
	?>
</div>
