<?php
require_once '../lib/Repository.php';
class GalerieRepository extends Repository
    {
        protected $tableName = 'galerie';

        function createGalerie($name, $benutzer_id, $beschreibung, $datum, $thumbnail){
            $query = "INSERT INTO $this->tableName ( name, benutzer_id, beschreibung, datum, thumbnail) VALUES (?, ?, ?, ?, ?)";

            $statement = ConnectionHandler::getConnection ()->prepare ( $query );
            $statement->bind_param ( 'sisis', $name, $benutzer_id, $beschreibung, $datum, $thumbnail);

            if (! $statement->execute ()) {
                throw new Exception ( $statement->error );
            }

        }
    public function getGalerieIdByName($galerieName){



            // MACHEN DASS NUR SOLCHE MIT DEM ANGEMELDETENE USER RAUS GESUCHT WERDEN.

            $query = "select id from `galerie` where name = ?";


        $statement = ConnectionHandler::getConnection ()->prepare ( $query );

        $statement->bind_param ( 's', $galerieName);
        var_dump(($query));
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
    }
?>