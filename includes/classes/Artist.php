<?php
	class Artist {
    private $con;
		private $id;

		public function __construct() {
			$this->con = $con;
      $this->id = $id;
		}
    public function getName(){
      $artistQuery = mysqli_query($this->$con,"SELECT * FROM artists WHERE id = $artistId");
      $artist = mysqli_fetch_array($artistQuery);
    }
  }
