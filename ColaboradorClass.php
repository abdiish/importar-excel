<?php
    require('Tools.php');

    try {
        
        $id_unidad = $_POST['id_unidad'];
        $query_c = $connect->prepare("SELECT id_colaborador, nombre_empleado FROM colaboradores WHERE id_unidad = '$id_unidad' ORDER BY nombre_empleado ASC");
        $query_c->setFetchMode(PDO::FETCH_ASSOC);
        $query_c->execute();

        $html = "<option value='0'>Seleccione una opcion</option>";

        while($row_u = $query_c->fetch()){
            
            $html.= "<option value='".$row_u['id_colaborador']."'>".$row_u['nombre_empleado']."</option>";
            
        }

    } catch (PDOException $error) {
        
        echo 'Error: '.$error->getMessage();
    }

    echo $html;
?>