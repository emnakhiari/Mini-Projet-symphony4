<?php
namespace App\Entity;
class dureeSearch
{
 /**
 * @var int|null 
 */ 
 private $minDuree;
 /**
 * @var int|null 
 */
 private $maxDuree;
 
 public function getMinDuree(): ?int
 {
 return $this->minDuree;
 }
 public function setMinDuree(int $minDuree): self
 { $this->minDuree = $minDuree;
 return $this;
 }
 public function getMaxDuree(): ?int
 {
 return $this->maxDuree;
 }
 public function setMaxDuree(int $maxDuree): self
 {
 $this->maxDuree = $maxDuree;
 return $this;
 }
}