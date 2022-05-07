<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Commande & Date</title></head>
<body>
    <form action="../../api/lireAnomalie.php" method="post">
        <h3>Anomalie :</h3>
        <br>
        <label for="commandeId">commandeId : </label><input type="text" name="commandeId">
        <br>
        <input type="submit" value="Rechercher" />
    </form>
</body>
</html>