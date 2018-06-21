<div id="container-usual">


<?php
    $_SESSION['activeGalerie'] = $message[0]->name;
    $_SESSION['activeGalerieId']= $message[0]->id;
    echo"<h2> ".$message[0]->name."</h2>";
    echo"<h3> ".$message[0]->beschreibung."</h3>";

?>
    <button id="myBtn2">galerie bearbeiten</button>

    <!-- The Modal -->
    <div id="myModal2" class="modal">

        <!-- Modal content -->
        <div class="modal-content">

            <!-- MODAL CONTENT -->

            <span class="close2">&times;</span>
            <div class="update">


                <div class="profil-daten row">

                    <div class="form-group">
                        <label for="galeriename" class="col-sm-5 control-label">Galeriename: </label>
                        <label for="galeriename" class="col-sm-3 control-label"><?php echo $message[0]->name; ?></label>
                    </div>
                    <div class="form-group">
                        <label for="beschreibung" class="col-sm-5 control-label">beschreibung: </label>
                        <label for="beschreibung" class="col-sm-3 control-label"><?php echo $message[0]->beschreibung; ?></label>
                    </div>

                <form class="form-horizontal" enctype="multipart/form-data" action="/file/updateGalerie/<?php echo $message[0]->id; ?>" method="POST">

                            <div class="form-group">
                                <label for="galerieName" class="col-sm-5 control-label">galeriename</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="galerieName"
                                           id="galerieName" placeholder="GalerieName"

                                </div>
                                <input type="hidden" value="<?php $message[0]->name?>" id="galerieNameOld" name="galerieNameOld">

                            </div>
                    <div class="form-group">
                        <label for="beschreibung" class="col-sm-5 control-label">beschreibung</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="beschreibung"
                                   id="beschreibung" placeholder="beschreibung"

                        </div>
                        <input type="hidden" value="<?php $message[0]->beschreibung?>" id="beschreibungOld" name="beschreibungOld">

                    </div>
                    <input type="submit">
                </form>
                </div>

                    </div>

            </div>
            <!-- MODAL CONTENT -->
        </div>
</div>

</div>






    <button id="myBtn">Bild hinzufügen</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">

            <!-- MODAL CONTENT -->

            <span class="close">&times;</span>


            <!-- Modal content -->
            <div class="modal-content">
                <span  class="close">&times;</span>




            <div class="upload">
                <form class="form-horizontal" enctype="multipart/form-data" action="/file/upload" method="POST">
                    <div class="datei-select">
                        <div class="fehlermeldung">


                        </div>
                        <div class="form-group">
                            <input type="file" name="userfile" accept="image/*" id="exampleInputFile">
                        </div>

                    </div>
                    <div>
                        <div class="links">
					<textarea name="beschreibung" class="textfeld" rows="4" cols="50"
                              maxlength="200" placeholder="Deine Beschreibung"></textarea>
                        </div>

                        <div >
                            <input type ="hidden" name="galerieName" type="checkbox" value="<?php echo $message[0]->name;?>">
                        </div>

                    </div>

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

    </div>

    <a  href="/file/deleteGalerie">galerie löschen(achtung sofort)</a>



    <div id="myModal3" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span  onclick='closeModal()' class="close">&times;</span>


            <img class='modalImg' id="img" src=''>

            <form method="POST" action="/file/delete">
                <input id='loeschenId' name='id' type="hidden" value="">
                <button type="submit">löschen</button>

            </form>





            <form method="POST" action="/file/changeImage">
                <h2>name</h2>
                <input type="text" name="titel">
                <h2>beschreibung</h2>
                <input type="text" name='beschreibung'>

                <input id='speichernId' name="id" type="hidden" value="">
                <button type="submit">speichern</button>
            </form>


        </div>

    </div>










    <?php

    require_once '../controller/FileController.php';
    require_once '../repository/fileRepository.php';
    require_once '../repository/galerieRepository.php';
    $gRepo = new GalerieRepository();
    $FileCon = new FileController ();
    $fileRepo = new FileRepository();
    $result= $fileRepo->getImageByGalerieId($message[0]->id);

    //WENN RESULT LEER IST
    if (false) {
        echo "<h3>$message</h3>";
    }
    echo "<div>";
    foreach ( $result as $row ) {

        $endName = $FileCon->dateiname($row->id, $row->name);

        echo "  
                
                <a id='$endName' onclick='openModal(\"$endName\")'><img src='/thumbnails/$endName'></a>
                

    <!-- MODAL CONTENT -->

                
"
                ;

    }
    echo "</div>"
    ?>






<script>

    function openModal(name){
        var modal3 = document.getElementById('myModal3');
        document.getElementById('loeschenId').value=name;
        document.getElementById('speichernId').value=name;
        document.getElementById("img").src="/files/"+name+"";
        modal3.style.display = "block";
    }
    function closeModal(){
        var modal3 = document.getElementById("myModal3");
        modal3.style.display = "none";

    }


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
    //---------------------------------------------------------



    //__________2es modal von galerie bearbeiten
    // Get the modal
    var modal2 = document.getElementById('myModal2');

    // Get the button that opens the modal
    var btn2 = document.getElementById("myBtn2");

    // Get the <span> element that closes the modal
    var span2 = document.getElementsByClassName("close2")[0];

    // When the user clicks on the button, open the modal
    btn2.onclick = function() {
        modal2.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span2.onclick = function() {
        modal2.style.display = "none";
    }
    //----------------------------------------------------------------






    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
        var modal3 = document.getElementById("myModal3");
        if (event.target == modal3) {
            modal3.style.display = "none";
        }

    }



</script>