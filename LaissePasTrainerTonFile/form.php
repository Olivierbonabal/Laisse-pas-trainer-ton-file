<?php

// Soumission du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0)
    {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];

        // Extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Sélectionner un format fichier valide.");

        // 1Mo maximum
        $maxFileSize = 1000000;
        if($filesize > $maxFileSize) die("Error: La taille du fichier supérieure à la limite autorisée.");

        // Vérification MIME
        if(in_array($filetype, $allowed))
        {
           if(file_exists("upload/" . $_FILES["photo"]["name"]))
           {
                echo $_FILES["photo"]["name"] . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" . $_FILES["photo"]["name"]);
                echo "Fichier téléchargé avec succès.";
            } 
        } else{
            echo "Error: Problème de téléchargement de votre fichier"; 
        }
    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Laisse pas trainer ton fils</title>
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input type="hidden" name="sendFile" value="1" />
        <input type="file" multiple="multiple" name="fichier[]" />
        <?php
        if (isset($errors['file'])) {
            foreach ($errors['file'] as $err) {
                echo "<p class='error'>" . $err . "</p>";
            }
        }
        ?>
        <br />
        <button class="btn btn-success btn-xs" type="submit">Envoyer</button>
        <p><i>1 MO Maximum! jpg, png ou gif seulement.</i></p>
    </form>


    <form action="" method="POST">
        <input type="hidden" name="idDelete" />
        <button type="submit" class="btn btn-danger btnn btn-xs" role="button">Supprimer</button>
  
    </form>
    </div>

</body>

</html>