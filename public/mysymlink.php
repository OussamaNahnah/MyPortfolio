<?php
$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/../storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink completed'.$_SERVER['DOCUMENT_ROOT'];