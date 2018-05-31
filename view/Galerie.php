<div id="container-usual">


<?php
    echo"<h2> $message</h2>"


?>

    <button id="myBtn">Bild hinzufügen</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">

            <!-- MODAL CONTENT -->

            <span class="close">&times;</span>
            <div class="upload">
                <form class="form-horizontal" enctype="multipart/form-data" action="/file/upload" method="POST">
                    <div class="datei-select">
                        <div class="fehlermeldung">
                            <?php
                            if (isset ( $message )) {
                                echo "<h3>$message</h3>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <input type="file" name="userfile" id="exampleInputFile">
                        </div>

                    </div>
                    <div>
                        <div class="links">
					<textarea name="beschreibung" class="textfeld" rows="4" cols="50"
                              maxlength="200" placeholder="Deine Beschreibung"></textarea>
                        </div>
                        <div class="rechts">
                            <input name="public" type="checkbox" value="true"> public
                        </div>
                        <div >
                            <input type ="hidden" name="galerieName" type="checkbox" value="<?php echo $message;?>"> public
                        </div>



                    </div>
                    <!--
                <div class="freigabe">

                        <div class="form-group">
                            <input type="text" class="form-control" id="freigabe"
                                placeholder="Freigabe fuer-> Work in Progress">
                        </div>
                        <button type="submit" class="btn btn-default">Bestaetigen</button>

                </div>

                 -->
                    <div>
                        <div class="upload">
                            <button type="submit" class="btn btn-default" value="Send File">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- MODAL CONTENT -->
        </div>

    </div>
    <?php

    require_once '../controller/FileController.php';
    require_once '../repository/fileRepository.php';
    require_once '../repository/galerieRepository.php';
    $gRepo = new GalerieRepository();
    $FileCon = new FileController ();
    $fileRepo = new FileRepository();

    $result= $fileRepo->getImageByGalerieId($gRepo->getGalerieIdByName($message));

    //WENN RESULT LEER IST
    if (false) {
        echo "<h3>$message</h3>";
    }


    foreach ( $result as $row ) {

        $endName = $FileCon->dateiname($row->id, $row->dateiname);

        echo "  <div>

                <img src='/files/$endName'>

                </div>";

    }
    ?>






<script>


    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>