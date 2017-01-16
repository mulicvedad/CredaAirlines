<?php

abstract class DBEntity
{
  abstract protected function saveToDb();
  abstract protected function updateDb();
  abstract protected function deleteFromDb();
}

 ?>
