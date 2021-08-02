<?php
    require('Tools.php');
    
    try {
        
        $id_jurisdiccion = $_POST['id_jurisdiccion'];
        $query_u = $connect->prepare("SELECT id_unidad, nombre_unidad FROM unidades WHERE id_jurisdiccion = '$id_jurisdiccion' ORDER BY nombre_unidad ASC");
        $query_u->setFetchMode(PDO::FETCH_ASSOC);
        $query_u->execute();

        $html = "<option value='0'>Seleccione una opcion</option>";

        while($row_u = $query_u->fetch()){

            $html.= "<option value='".$row_u['id_unidad']."'>".$row_u['nombre_unidad']."</option>";

        }

    } catch (PDOException $error) {
        
        echo 'Error: '.$error->getMessage();
    }

    echo $html;
?>