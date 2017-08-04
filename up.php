<?php $content_dir = 'avatar/'; // dossier où sera déplacé le fichier
        $tmp_file = $_FILES['url']['tmp_name'];
       
        // on vérifie maintenant l’extension
        $type_file = $_FILES['url']['type'];
       
        // on fait un test de sécurité
        $name_file = $_FILES['url']['name'];
       
        // on copie le fichier dans le dossier de destination
		
       if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
                echo("Impossible de copier le fichier dans $content_dir");
        }
        echo "Le fichier a bien été uploadé";

       $avatar= 'avatar/'. $name_file;
	   ?>