<?php 

$ossec_tmp_path = $GLOBALS['ossec_root'].'tmp/files';
//print($ossec_tmp_path);
if(count($_FILES['location']) > 0){
    $files = tmpPath($ossec_tmp_path);
    print_r($files);
}
try{
    switch ($_POST['type']) {
        case 'command':
            $name = $_POST['name'] ? htmlspecialchars(str_replace(" ",'%',$_POST['name'])) : null;
            $executable = $_POST['executable'] ? htmlspecialchars(str_replace(" ",'%',$_POST['executable'])) : null;
            $expect = $_POST['expect'] ? htmlspecialchars(str_replace(" ",'%',$_POST['expect'])) : null;
            $timeout_allowed = $_POST['timeout_allowed'] ? htmlspecialchars(str_replace(" ",'%',$_POST['timeout_allowed'])) : null;
            $active_response = $_POST['active_response'] ? htmlspecialchars(str_replace(" ",'%',$_POST['active_response'])) : null;

            if ($name && $executable && $expect && $timeout_allowed && $active_response) {
                shell_exec('./newUtil.sh addfile ');
            } else {
                throw new Exception;
            }
        
        break;
        case 'localFile':
            $type_format = $_POST['type_format'] ? htmlspecialchars(str_replace(" ",'%',$_POST['type_format'])) : null;
            if ($type_format && $type_format == 'file'){
                $logFormat = $_POST['logFormat'] ? htmlspecialchars(str_replace(" ",'%',$_POST['logFormat'])) : null;
                $location = $_POST['location'] ? htmlspecialchars(str_replace(" ",'%',$_POST['location'])) : null;
                $check_diff = $_POST['check_diff'] ? htmlspecialchars(str_replace(" ",'%',$_POST['check_diff'])) : null;
                $only_future_events = $_POST['only-future-events'] ? htmlspecialchars(str_replace(" ",'%',$_POST['only-future-events'])) : null;
                if ($logFormat && $location && $check_diff && $only_future_events) {
                    $exec_command ='./../sh/newUtil.sh addfile ' .$type_format.' ' .$logFormat. ' ' .$location. ' ' .$check_diff. ' ' .$only_future_events;
                    print($exec_command);
                    exit;
                    print_r( shell_exec('./../sh/newUtil.sh file localFile ' .$logFormat. ' ' .$location. ' ' .$check_diff. ' ' .$only_future_events));
                    exit;
                
                } else {
                    throw new Exception;
                }
            }
            

        
            //[type_format] => file [logFormat] => syslog [location] => prueba.log [check_diff] => yes [only-future-events] => no
            //./NEWuTIL.SH addfile command argu1 argu2 arg3
            //str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] ) : mixed
        break;
        case 'dns':break;
        case 'website':
            
        break;
        default: 
            header("Location:/ossec/bootstrap/customLogs.php"); 
            //print($_POST['type']);
        break;

    }
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

exit;

function tmpPath($ossec_tmp_path)
{
    $files = array();
    print_r($_FILES);
    //print_r($_FILES["location"]['error']);
    foreach ($_FILES["location"]["error"] as $clave => $error) {
        print_r($_FILES["location"]);
        if ($error == UPLOAD_ERR_OK) {
            
            $nombre_tmp = $_FILES["location"]["tmp_name"][$clave];
            // basename() puede evitar ataques de denegació del sistema de ficheros;
            // podría ser apropiado más validación/saneamiento del nombre de fichero
            $nombre = basename($_FILES["location"]["name"][$clave]);
            move_uploaded_file($nombre_tmp, $ossec_tmp_path.'/'.$nombre);
            array_push($files,$ossec_tmp_path.'/'.$nombre);
        }
    }
    return $files;
}