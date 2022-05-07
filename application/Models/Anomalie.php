<?php
class Anomalie{
    // Connexion
    private $connexion;

    // Propriétés

/**
 * Constructeur avec $db pour la connexion à la base de données
 *
 * @param $db
 */
    public function __construct($db){
        $this->connexion = $db;
    }

    public $valid = 1;

// Create
    /**
     * Créer une anomalie
     *
     * @return void
     */
    public function creerAnomalie()
    {
        // Ecriture de la requête SQL en y insérant le nom de la table
        // $sql = "INSERT INTO anomalie SET utilisateur_id=:utilisateur_id, entreprise_id=:entreprise_id, module_id=:module_id, 
        // releve_id=:releve_id, rappel_id=:rappel_id, date_anomalie=:date_anomalie, description=:description, probleme=:probleme, 
        // action_corrective=:action_corrective, observation=:observation, corrected=:corrected, archived=:archived, deleted=:deleted,
        // guid=:guid, client_last_updated=:client_last_updated, status=:valid";
        $sql = "INSERT INTO anomalie (entreprise_id, date_anomalie, description, probleme, action_corrective, observation, status) 
        VALUES (:entreprise_id, :date_anomalie, :description, :probleme, :action_corrective, :observation, :valid)"; // , :corrected, :archived, :deleted
        //  corrected, archived, deleted,
        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Ajout des données protégées
        // $query->bindParam(":utilisateur_id", $this->utilisateur_id);
        $query->bindParam(":entreprise_id", $this->entreprise_id);
        // $query->bindParam(":module_id", $this->module_id);
        // $query->bindParam(":releve_id", $this->releve_id);
        // $query->bindParam(":rappel_id", $this->rappel_id);
        $query->bindParam(":date_anomalie", $this->date_anomalie);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":probleme", $this->probleme);
        $query->bindParam(":action_corrective", $this->action_corrective);
        $query->bindParam(":observation", $this->observation);
        // $query->bindParam(":corrected", $this->corrected);
        // $query->bindParam(":archived", $this->archived);
        // $query->bindParam(":deleted", $this->deleted);
        // $query->bindParam(":guid", $this->guid);
        // $query->bindParam(":client_last_updated", $this->client_last_updated);
        $query->bindParam(":valid", $this->valid);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
    
        return false;
    }

    /**
     * Créer une descanomalie
     *
     * @return void
     */
    public function creerDescanomalie()
    {
        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO descanomalie SET id_typeanomalie=:id_typeanomalie, nomDescanomalie=:nomDescanomalie, 
        descriptionDescanomalie=:descriptionDescanomalie, criticite=:criticite, valid=:valid";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Ajout des données protégées
        $query->bindParam(":id_typeanomalie", $this->id_typeanomalie);
        $query->bindParam(":nomDescanomalie", $this->nomDescanomalie);
        $query->bindParam(":descriptionDescanomalie", $this->descriptionDescanomalie);
        $query->bindParam(":criticite", $this->criticite);
        $query->bindParam(":valid", $this->valid);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }


    /**
     * Créer une cranomalie
     *
     * @return void
     */
    public function creerCranomalie()
    {
        // id_commande
        $idCom = "SELECT id_commande from commande where commandeId = :code";
        $reqIdCom = $this->connexion->prepare($idCom);
        $reqIdCom->bindParam(":code", $this->commandeId);
        $reqIdCom->execute();
        foreach($reqIdCom as $data){
            $id_produitcmd = $data[0];
        }
        if (is_null($id_produitcmd))
        {
            // Récupération de l'article
            $idArt = "SELECT article from article where articleCode = :code";
            $reqIdArt = $this->connexion->prepare($idArt);
            $reqIdArt->bindParam(":code", $this->commandeId);
            $reqIdArt->execute();
            foreach($reqIdArt as $data){
                $id_art = $data[0];
            }
            // Récupération des id lnk en fonction de l'article
            $idCom = "SELECT id_lnkcommandearticle from lnkcommandearticle where id_article = :id";
            $reqIdLNK = $this->connexion->prepare($idCom);
            $reqIdLNK->bindParam(":id", $id_art);
            $reqIdLNK->execute();
            $i = 0;
            foreach($reqIdLNK as $data){
                $id_produitcmd[] = $data[$i];
                $i += 1;
            }
        }

        // id_descanomalie
        $idDesc = "SELECT max(id_descanomalie) from descanomalie";
        $reqId = $this->connexion->prepare($idDesc);
        $reqId->execute();
        foreach($reqId as $data){
            $id_desc = $data[0];
        }

        // id_anomalie
        $idAnomalie = "SELECT max(id_anomalie) from anomalie";
        $reqIdAnomalie = $this->connexion->prepare($idAnomalie);
        $reqIdAnomalie->execute();
        foreach($reqIdAnomalie as $data){
            $id_ano = $data[0];
        }

        if(!is_array($id_produitcmd))
        {
            // Ecriture de la requête SQL en y insérant le nom de la table
            $sql = "INSERT INTO cranomalie SET id_typeanomalie=:id_typeanomalie, id_descanomalie=:id_descanomalie, 
            id_produitcmd=:id_produitcmd, id_anomalie=:id_anomalie, valid=:valid";

            // Préparation de la requête
            $query = $this->connexion->prepare($sql);

            // Ajout des données protégées
            $query->bindParam(":id_typeanomalie", $this->id_typeanomalie);
            $query->bindParam(":id_descanomalie", $id_desc);
            $query->bindParam(":id_produitcmd", $id_produitcmd);
            $query->bindParam(":id_anomalie", $id_ano);
            $query->bindParam(":valid", $this->valid);

            // Exécution de la requête
            if($query->execute())
            {
                return true;
            }
        }
        else
        {
            foreach ($id_produitcmd as $id)
            {
                // Ecriture de la requête SQL en y insérant le nom de la table
                $sql = "INSERT INTO cranomalie SET id_typeanomalie=:id_typeanomalie, id_descanomalie=:id_descanomalie, 
                id_produitcmd=:id_produitcmd, id_anomalie=:id_anomalie, valid=:valid";

                // Préparation de la requête
                $query = $this->connexion->prepare($sql);

                // Ajout des données protégées
                $query->bindParam(":id_typeanomalie", $this->id_typeanomalie);
                $query->bindParam(":id_descanomalie", $id_desc);
                $query->bindParam(":id_produitcmd", $id);
                $query->bindParam(":id_anomalie", $id_ano);
                $query->bindParam(":valid", $this->valid);

                // Exécution de la requête
                if($query->execute())
                {
                    return true;
                }
            }
        }
        
        return false;
    }



}