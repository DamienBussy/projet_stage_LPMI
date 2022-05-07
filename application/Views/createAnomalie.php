<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Commande & Date</title></head>
<body>
    <form action="../../api/creerAnomalie.php" method="post">
        <h3>Anomalie :</h3>
        <br>
        <label for="commandeId">commandeId : </label><input type="text" name="commandeId">
        <br>
        <label for="date_anomalie">date_anomalie : </label><input type="date" id="date_anomalie" name="date_anomalie">
        <br>
        <label for="probleme">probleme : </label> <input type="text" name="probleme" />
        <br>
        <label for="observation">observation : </label> <input type="text" name="observation" />
        <br>
        <label for="action_corrective">action_corrective : </label> <input type="text" name="action_corrective" />
        <br>
        <label for="entreprise_id">entreprise_id : </label> <input type="text" name="entreprise_id" />
        <br>
        <!-- <label for="corrected">corrected : </label> <input type="text" name="corrected" />
        <br>
        <label for="archived">archived : </label> <input type="text" name="archived" />
        <br>
        <label for="deleted">deleted : </label> <input type="text" name="deleted" />
        <br> -->
        <h3>Description de l'anomalie :</h3>
        <br>
        <label for="nomDescription">nomDescription : </label> <input type="text" name="nomDescription" />
        <br>
        <label for="description">description : </label> <input type="text" name="description" />
        <br>
        <label for="criticite">criticite : </label> <input type="text" name="criticite" />
        <br>
        <label for="id_typeanomalie">id_typeanomalie : </label> <input type="text" name="id_typeanomalie" />
        <br>
        <input type="submit" value="Créer" />
    </form>
</body>
</html>