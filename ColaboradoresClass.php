<?php
    require('Tools.php');

    try {
        
        $id_unidad = $_POST['id_unidad'];
        $query_c = $connect->prepare("SELECT id_colaborador,nombre_empleado,puesto_empleado FROM colaboradores WHERE id_unidad = '$id_unidad' ORDER BY nombre_empleado ASC");
        $query_c->setFetchMode(PDO::FETCH_ASSOC);
        $query_c->execute();

        echo "<table class='table table-striped'>
                <thead>
                    <tr class='bg-primary text-light'>
                        <th style='width: 5px'>#</th>
                        <th>Responsable</th>
                        <th>Puesto</th>
                        <th>Folio</th>
                        <th>CURP</th>
                        <th>INE</th>
                    </tr>
                </thead>";
                while($row_c = $query_c->fetch()) {
                    echo "<tr>";
                    echo "<td>" . $row_c['id_colaborador'] . "</td>";
                    echo "<td>" . $row_c['nombre_empleado'] . "</td>";
                    echo "<td>" . $row_c['puesto_empleado'] . "</td>";
                    echo "<td>" . $row_c['id_colaborador'] . "</td>";
                    echo "<td>" . $row_c['id_colaborador'] . "</td>";
                    echo "<td>" . $row_c['id_colaborador'] . "</td>";
                    echo "</tr>";   

                }
        echo "</table>";

    } catch (PDOException $error) {
        
        echo 'Error: '.$error->getMessage();
    }

?>