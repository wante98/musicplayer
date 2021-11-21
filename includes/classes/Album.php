<?php
	class Album {
    private $con;
		private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;

		public function __construct($con,$id) {
			$this->con = $con;
      $this->id = $id;
      $query = mysqli_query($this->$con,"SELECT * FROM albums WHERE id = 'this->id'");
      $album = mysqli_fetch_array($query);
      $this->title = $album['title'];
      $this->artistId = $album['artistId'];
      $this->genre = $album['genre'];
      $this->artworkPath = $album['artworkPath'];
    }
    public function getTitle(){
      return $this -> title;
    }
    public function getArtist(){
      return new Artist($this->con, $this->artistId);
    }
    public function getGenre(){
      return new $this -> genre;
    }
    public function getArtworkPath(){
      $query = mysqli_query($this->$con,"SELECT artworkPath FROM albums WHERE id = 'this->id'");
      $album = mysqli_fetch_array($query);
      return $album['title'];
    }
  }
