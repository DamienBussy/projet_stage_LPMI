<?php
$conn = new PDO("mysql:host=localhost;dbname=restaurant", "test", "test");


if (isset($_POST['codeFR']) && !empty($_POST['codeFR'])) {
    $codeparent = urlencode($_POST['codeFR']);
}

$parentid = $conn->prepare("SELECT id from Tabhierarchie where code = :codeparent");
$parentid->bindParam(':codeparent', $codeparent);
$parentid->execute();

foreach ($parentid as $id)
{
    if(is_array($id)){
        foreach($id as $data){
            if (empty($test)){
                $test = $data;
            }
        }
    }
}
// echo $test;

// Récupération du parent FR
$recupParentFR = $conn->prepare("SELECT id, parent_id, nom, code from Tabhierarchie where id = :id");
$recupParentFR->bindParam(':id', $test);
$recupParentFR->execute();
foreach ($recupParentFR as $data){
    $idSite = $data[1];
    ?><h2>POINT DE VENTE : </h2><?php
    echo 'ID : '.$data[0];
    ?><br><?php
    echo 'Parent ID : '.$data[1];
    ?><br><?php
    echo 'Nom : '.$data[2];
    ?><br><?php
    echo 'Code : '.$data[3];
    ?><br><?php
}

// Récupération du parent secteur
$recupParentSite = $conn->prepare("SELECT id, parent_id, nom, code from Tabhierarchie where id = :id");
$recupParentSite->bindParam(':id', $idSite);
$recupParentSite->execute();
foreach ($recupParentSite as $data){
    $idDivision = $data[1];
    ?><h2>SITE : </h2><?php
    echo 'ID : '.$data[0];
    ?><br><?php
    echo 'Parent ID : '.$data[1];
    ?><br><?php
    echo 'Nom : '.$data[2];
    ?><br><?php
    echo 'Code : '.$data[3];
    ?><br><?php
}

// // Récupération du parent Division
$recupParentSecteur = $conn->prepare("SELECT id, parent_id, nom, code from Tabhierarchie where id = :id");
$recupParentSecteur->bindParam(':id', $idDivision);
$recupParentSecteur->execute();
foreach ($recupParentSecteur as $data){
    $idSecteur = $data[1];
    ?><h2>SECTEUR : </h2><?php
    echo 'ID : '.$data[0];
    ?><br><?php
    echo 'Parent ID : '.$data[1];
    ?><br><?php
    echo 'Nom : '.$data[2];
    ?><br><?php
    echo 'Code : '.$data[3];
    ?><br><?php
}

// // Récupération du parent Segment
$recupParentDivision = $conn->prepare("SELECT id, parent_id, nom, code from Tabhierarchie where id = :id");
$recupParentDivision->bindParam(':id', $idSecteur);
$recupParentDivision->execute();
foreach ($recupParentDivision as $data){
    $idSegment = $data[1];
    ?><h2>DIVISION : </h2><?php
    echo 'ID : '.$data[0];
    ?><br><?php
    echo 'Parent ID : '.$data[1];
    ?><br><?php
    echo 'Nom : '.$data[2];
    ?><br><?php
    echo 'Code : '.$data[3];
    ?><br><?php
}


$recupParentSegment = $conn->prepare("SELECT id, parent_id, nom, code from Tabhierarchie where id = :id");
$recupParentSegment->bindParam(':id', $idSegment);
$recupParentSegment->execute();
foreach ($recupParentSegment as $data){
    ?><h2>SEGMENT : </h2><?php
    echo 'ID : '.$data[0];
    ?><br><?php
    echo 'Parent ID : '.$data[1];
    ?><br><?php
    echo 'Nom : '.$data[2];
    ?><br><?php
    echo 'Code : '.$data[3];
    ?><br><?php
}

?>
<br>
<form>
    <a href="form/form_centre.php"><input type="button" value="Retour"></a>
</form>