<?php
require_once '../lib/Repository.php';
class GalerieRepository extends Repository
    {
        protected $tableName = 'galerie';

        function createGalerie($name, $benutzer_id, $beschreibung, $datum, $thumbnail){
            $query = "INSERT INTO $this->tableName ( name, benutzer_id, beschreibung, datum, thumbnail) VALUES (?, ?, ?, ?, ?)";

            $statement = ConnectionHandler::getConnection ()->prepare ( $query );
            $statement->bind_param ( 'sisis', htmlspecialchars ($name), $benutzer_id, htmlspecialchars ($beschreibung), $datum, htmlspecialchars ($thumbnail));

            if (! $statement->execute ()) {
                throw new Exception ( $statement->error );
            }

        }
    public function getGalerieIdByName($galerieName){



            // MACHEN DASS NUR SOLCHE MIT DEM ANGEMELDETENE USER RAUS GESUCHT WERDEN.

        $query = "select id from `galerie` where name = ?";


        $statement = ConnectionHandler::getConnection ()->prepare ( $query );

        $statement->bind_param ( 's', $galerieName);
        $statement->execute();
        $result= $statement->get_result ();

        if (! $result) {
            throw new Exception ( $statement->error );
        }

        // Ersten Datensatz aus dem Resultat holen
        $rows = array ();
        while ( $row = $result->fetch_object () ) {
            $rows [] = $row;
        }

        // Datenbankressourcen wieder freigeben
        $result->close ();

        // Den gefundenen Datensatz zurückgeben

        return $rows;



    }
    public function deleteById($id)
    {
        $query = "DELETE FROM galerie WHERE id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        if (!$statement->execute()) {
            throw new Exception ($statement->error);
        }
    }
    public function myGalerie() {
        $query = "select * from $this->tableName where benutzer_id = ?";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'i', $_SESSION ['id'] );
        // Das Statement absetzen
        $statement->execute ();

        // Resultat der Abfrage holen
        $result = $statement->get_result ();
        if (! $result) {
            throw new Exception ( $statement->error );
        }

        // Ersten Datensatz aus dem Resultat holen
        $rows = array ();
        while ( $row = $result->fetch_object () ) {
            $rows [] = $row;
        }

        // Datenbankressourcen wieder freigeben
        $result->close ();

        // Den gefundenen Datensatz zurückgeben
        return $rows;
    }
    public function getGalerieById($id){
        $query = "select * from `galerie` where id = ?";
        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'i', $id );
        $statement->execute ();
        $result = $statement->get_result ();
        if (! $result) {
            throw new Exception ( $statement->error );
        }

        // Ersten Datensatz aus dem Resultat holen

        $rows = array ();
        while ( $row = $result->fetch_object () ) {
            $rows [] = $row;
        }


        // Datenbankressourcen wieder freigeben

        $result->close ();

        // Den gefundenen Datensatz zurückgeben
        return $rows;


    }
    public function updateGalerie($name,$beschreibung, $id){
        $query = "UPDATE `galerie` SET name = ?, beschreibung = ? WHERE id = ?";
        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'ssi', htmlspecialchars ($name), htmlspecialchars ($beschreibung), $id );

        if (! $statement->execute ()) {
            throw new Exception ( $statement->error );
        }
    }

    }
?>