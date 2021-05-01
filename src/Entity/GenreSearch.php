<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
class GenreSearch
{
 /**
 * @ORM\ManyToOne(targetEntity="App\Entity\Genre")
 */
 private $Genre;
 public function getGenre(): ?Genre
 {
 return $this->Genre;
 }
 public function setGenre(?Genre $Genre): self
 {
 $this->Genre = $Genre;
 return $this;
 }
}
