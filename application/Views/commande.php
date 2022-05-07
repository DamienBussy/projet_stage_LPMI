<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Commande.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les produits
    $commande = new Commandes($db);
    $centre = new Commandes($db);

    $donnees = json_decode(file_get_contents("php://input"));

    // centre
    if(!empty($donnees->code && !empty($donnees->dateDebut) && !empty($donnees->dateFin))){
        $centre->code = $donnees->code;
        
        // On récupère le centre
        $centre->CentreID();

        // On vérifie si le centre existe
        if($centre->code != null){
            // On crée un tableau contenant le centre
            $centre_id = $centre->id;
            $prod = [
                "id" => $centre->id,
                "nom" => $centre->nom
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($prod);
            
        }
    
        // On vérifie qu'on a bien un id
        // // COMMANDE
        if(!empty($centre_id)){
            $commande->dateDebut = $donnees->dateDebut;
            $commande->dateFin = $donnees->dateFin;
            $commande->id = $centre_id;
            // On récupère le commande
            $commande->lireUn();

            $stmt = $commande->lireUn();

            // On vérifie si on a au moins 1 commande
            if($stmt->rowCount() > 0){
                // On initialise un tableau associatif
                $tableauCommandes = [];
                $tableauCommandes['commande'] = [];
                // On parcourt les commandes
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $commande_id[] = $id_commande;
                    $prod = [
                        "id_commande" => $id_commande,
                        "id_centre" => $id_centre,
                        "id_fournisseur" => $id_fournisseur,
                        "commandeId" => $commandeId,
                        "dateLivraison" => $dateLivraison,
                        "montantHT" => $montantHT,
                        "valid" => $valid
                    ];

                    $tableauCommandes['commande'][] = $prod;
                }
                // On envoie le code réponse 200 OK
                http_response_code(200);

                // On encode en json et on envoie
                echo json_encode($tableauCommandes);
            }
        }

        // LNKCOMMANDEARTICLE
        $lnkcommandearticle = new Commandes($db);
        if(!empty($centre_id)){
            foreach ($commande_id as $id)
            {
                $lnkcommandearticle->id = $id;
                // On récupère le commande
                $lnkcommandearticle->lireUnLnk();
                $stmt = $lnkcommandearticle->lireUnLnk();
        
                // On vérifie si on a au moins 1 commande
                if($stmt->rowCount() > 0){
                    // On initialise un tableau associatif
                    $tableaulnkcommandearticle = [];
                    $tableaulnkcommandearticle['lnkcommandearticle'] = [];
                    // On parcourt les commandes
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        $article_id[] = $id_article;
                        $prod = [
                            "id_article" => $id_article,
                            "quantiteCommandee" => $quantiteCommandee,
                            "prixAchatHT" => $prixAchatHT,
                            "uniteCommande" => $uniteCommande
                        ];
        
                        $tableaulnkcommandearticle['lnkcommandearticle'][] = $prod;
                    }
                    // On envoie le code réponse 200 OK
                    http_response_code(200);
                    // On encode en json et on envoie
                    echo json_encode($tableaulnkcommandearticle);
                }
            }
        }

        // ARTICLE
        $article = new Commandes($db);
        if(!empty($centre_id)){
            foreach ($article_id as $id)
            {
                $article->id = $id;
                // On récupère le commande
                $article->lireUnArticle();
                $stmt = $article->lireUnArticle();
        
                // On vérifie si on a au moins 1 commande
                if($stmt->rowCount() > 0){
                    // On initialise un tableau associatif
                    $tableauarticle = [];
                    $tableauarticle['article'] = [];
                    // On parcourt les commandes
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
        
                        $prod = [
                            "id_article" => $id_article,
                            "articleCode" => $articleCode,
                            "articleLibelle" => $articleLibelle,
                            "conditionStockageCode" => $conditionStockageCode,
                            "conditionStockageLibelle" => $conditionStockageLibelle
                        ];
                        $tableauarticle['article'][] = $prod;
                    }
                    // On envoie le code réponse 200 OK
                    http_response_code(200);
                    // On encode en json et on envoie
                    echo json_encode($tableauarticle);
                }
            }
        }      

        else{
            // 404 Not found
            http_response_code(404);
            
            echo json_encode(array("message" => "Le commande n'existe pas."));
        }
    }
}
