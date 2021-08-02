<?php

include ('../vendor/autoload.php');
include ('../inc/Tools.php');

if ($_FILES["import_excel"]["name"] != '') {

    $allowed_extension = array('xls', 'csv', 'xlsx');
    $file_array = explode(".", $_FILES["import_excel"]["name"]);
    $file_extension = end($file_array);

    if (in_array($file_extension, $allowed_extension)) {

        class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

            public function readCell($column, $row, $worksheetName = '') {
        
                if ($row > 7) {
                    if (in_array($column,range('C7','G7'))) {
                        
                        return true;
                    }
                }
                return false;
            }
        }

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $file_name = time() . '.' . $file_extension;
        move_uploaded_file($_FILES["import_excel"]["tmp_name"], $file_name);
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
        $reader    = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
        $reader->setReadFilter( new MyReadFilter());
        $spreadsheet = $reader->load($file_name);
        unlink($file_name); 
        $sheetCount =  $spreadsheet->getSheetCount();


        for ($idx = 0; $idx < $sheetCount; $idx++) { 
            
            $spreadsheet->getSheet($idx);
            $dataArray = $spreadsheet->getActiveSheet()->toArray();

            switch ($idx) {

                case 0: $dataArray = $spreadsheet->setActiveSheetIndex(0)->toArray();

                    foreach ($dataArray as $row) {

                        try {
                            
                            $insertData = array(
                                ':fecha_receta'     =>  $row[2],
                                ':folio_incorrecto' =>  $row[3],
                                ':folio_correcto'   =>  $row[4],
                                ':id_surtido'       =>  $row[5],
                                ':motivo'           =>  $row[6]
                            );
                            
                            if (isset($row[2]) || isset($row[3]) || isset($row[4]) || isset($row[5]) || isset($row[6])) {
                                
                                $query = "
                                INSERT INTO folio_correcciones
                                (fecha_receta, folio_incorrecto, folio_correcto, id_surtido, motivo)
                                VALUES(:fecha_receta, :folio_incorrecto, :folio_correcto, :id_surtido, :motivo)
                                ";

                                $statement = $connect->prepare($query);
                                $statement->bindParam(':fecha_receta',$row[2],PDO::PARAM_STR,10);
                                $statement->bindParam(':folio_incorrecto',$row[3],PDO::PARAM_STR,15);
                                $statement->bindParam(':folio_correcto',$row[4],PDO::PARAM_STR,15);
                                $statement->bindParam(':id_surtido',$row[5], PDO::PARAM_STR,20);
                                $statement->bindParam(':motivo',$row[6],PDO::PARAM_STR,150);
                                $statement->execute();

                            }

                        } catch (PDOException $error) {

                            echo 'Error: '.$error->getMessage();
                        }
                    }

                    $message = '<script type="text/javascript">
                                    toastr.success("La importación de la información se realizo satisfactoriamente.", "Importar archivo SOPORTE_v4", {timeOut: 5000})
                                </script>';
                    
                    break;

                case 1: $dataArray = $spreadsheet->setActiveSheetIndex(1)->toArray();    
                    
                    foreach ($dataArray as $row) {

                        try {
                            
                            $insertData = array(
                                ':fecha_receta'     => $row[2],
                                ':folio_receta'     => $row[3],
                                ':curp_incorrecta'  => $row[4],
                                ':curp_correcta'    => $row[5],
                                ':motivo'           => $row[6]
                            );

                            if (isset($row[2]) || isset($row[3]) || isset($row[4]) || isset($row[5]) || isset($row[6])) {
                                
                                $query = "
                                INSERT INTO curp_correcciones
                                (fecha_receta, folio_receta, curp_incorrecta, curp_correcta, motivo)
                                VALUES(:fecha_receta, :folio_receta, :curp_incorrecta, :curp_correcta, :motivo)
                                ";

                                $statement = $connect->prepare($query);
                                $statement->bindParam(':fecha_receta',$row[2],PDO::PARAM_STR,10);
                                $statement->bindParam(':folio_receta',$row[3],PDO::PARAM_STR,15);
                                $statement->bindParam(':curp_incorrecta',$row[4],PDO::PARAM_STR,18);
                                $statement->bindParam(':curp_correcta',$row[5], PDO::PARAM_STR,28);
                                $statement->bindParam(':motivo',$row[6],PDO::PARAM_STR,150);
                                $statement->execute();

                            }

                        } catch (PDOException $error) {

                            echo 'Error: '.$error->getMessage();
                        }
                    }

                    $message = '<script type="text/javascript">
                                    toastr.success("La importación de la información se realizo satisfactoriamente.", "Importar archivo SOPORTE_v4", {timeOut: 5000})
                                </script>';
                    break;

                case 2: $dataArray = $spreadsheet->setActiveSheetIndex(2)->toArray();
                    
                    foreach ($dataArray as $row) {

                        try {
                            //code...
                            $insertData = array(
                                ':fecha_receta'    => $row[2],
                                ':folio_receta'    => $row[3],
                                ':ine_incorrecta'  => $row[4],
                                ':ine_correcta'    => $row[5],
                                ':motivo'          => $row[6]
                            );

                            if (isset($row[2]) || isset($row[3]) || isset($row[4]) || isset($row[5]) || isset($row[6])) {
                                
                                $query = "
                                INSERT INTO ine_correcciones
                                (fecha_receta, folio_receta, ine_incorrecta, ine_correcta, motivo)
                                VALUES(:fecha_receta, :folio_receta, :ine_incorrecta, :ine_correcta, :motivo)
                                ";
                                
                                $statement = $connect->prepare($query);
                                $statement->bindParam(':fecha_receta',$row[2],PDO::PARAM_STR,10);
                                $statement->bindParam(':folio_receta',$row[3],PDO::PARAM_STR,15);
                                $statement->bindParam(':ine_incorrecta',$row[4],PDO::PARAM_STR,15);
                                $statement->bindParam(':ine_correcta',$row[5], PDO::PARAM_STR,15);
                                $statement->bindParam(':motivo',$row[6],PDO::PARAM_STR,150);
                                $statement->execute();

                            }

                        } catch (PDOException $error) {
                            
                            echo 'Error: '.$error->getMessage();
                        }
                    }

                    $message = '<script type="text/javascript">
                                    toastr.success("La importación de la información se realizo satisfactoriamente.", "Importar archivo SOPORTE_v4", {timeOut: 5000})
                                </script>';
                    break;
            }// end switch case 

        }// end for
          
    }else{

        $message = '<script type="text/javascript">
                        var elemento = document.getElementById("loader");
                            elemento.style.display = "none"; 
                        toastr.error("Solo se permiten archivos con extensión .xls o .xlsx", "Importante", {timeOut: 5000})
                    </script>';
    }// end if & else 2

}else{
    
    $message = '<script type="text/javascript">
                    toastr.error("Olvidaste adjuntar el archivo.","Atención",{timeOut: 5000})
                </script>';
}// end if 1 

echo $message;

?>