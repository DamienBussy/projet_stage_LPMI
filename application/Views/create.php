<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Commandes</title></head>
<body>
    <form action="../../api/create.php" method="post">
        <h3>Commande : </h3>
        <label for="code_centre">code_centre : </label> <input type="text" name="code_centre" />
        <br>
        <label for="code_fournisseur">code_fournisseur : </label> <input type="text" name="code_fournisseur" />
        <br>
        <label for="commandeId">commandeId : </label> <input type="text" name="commandeId" />
        <br>
        <label for="dateLivraison">dateLivraison : </label><input type="date" id="dateLivraison" name="dateLivraison">
        <br>
        <label for="montantHT">montantHT : </label><input type="text" name="montantHT">
        <br>
        <br>
        <h3>Article : </h3>
        <label for="article">Sélectionner un article : </label><br />
        <select name="article" id="article" value="articleLibelle">
        <option value="" selected="selected">Sélectionner un article</option>
            <?php
                try
                {
                        $bdd = new PDO('mysql:host=localhost;dbname=restaurant', 'test', 'test');
                }
                catch(Exception $e)
                {
                            die('Erreur : '.$e->getMessage());
                }
                
                
                $reponse = $bdd->query('SELECT articleLibelle FROM article');
                
                while ($donnees = $reponse->fetch())
                {
                ?>
                        <option value="<?= $donnees['articleLibelle']; ?>"> <?php echo $donnees['articleLibelle']; ?></option>
                        
                <?php
                // if (isset($_POST['article']) && !empty($_POST['article'])) {
                //     $selectArticle = urlencode($_POST['article']);
                // }
                // $select = $donnees['articleLibelle'];
                }
                ?>
                <input id="articleHidden" name="articleHidden" type="hidden" value="<?php $donnees['articleLibelle']; ?>">
                <?php
                $reponse->closeCursor();
                // $recupDataArticle = $bdd->prepare('SELECT id_famille, articleCode, conditionStockageCode, conditionStockageLibelle from article where articleCode=:articleCode');
                // $recupDataArticle->bindParam(':articleCode', $selectArticle);
                // $recupDataArticle->execute();
                // $i = 0;
                // $articleData = array();
                // foreach($recupDataArticle as $data){
                //     $articleData[] = $data[$i];
                //     $i += 1;
                // }
                
            ?>
        </select>
        <br>
        <h3>Détails : </h3>
        <label for="quantiteCommandee">quantiteCommandee : </label> <input type="text" name="quantiteCommandee" />
        <br>
        <label for="prixAchatHT">prixAchatHT : </label> <input type="text" name="prixAchatHT" />
        <br>
        <label for="uniteCommande">uniteCommande : </label> <input type="text" name="uniteCommande" />
        <br>
        <br>
        <input type="submit" value="Créer" />
    </form>
</body>
</html>