<?php 
function sanitize($db, $var){
    $var = htmlspecialchars(trim($var));
    return $db->real_escape_string($var);
}

function check_value($value)
{
    return check_value_array($value, $_POST);
}

function check_value_get($value){
    return check_value_array($value, $_GET);
}

function check_value_array($value, $array){
    return (isset($array[$value]) and !empty($array[$value]));
}


function upload_profile_pic($name, $username) {
    $file = $_FILES[$name];
    if (filesize($file['tmp_name']) > 11) $imagetype = exif_imagetype($file['tmp_name']);
    else $imagetype = FALSE;
    if($imagetype and ($imagetype === IMAGETYPE_JPEG or $imagetype === IMAGETYPE_PNG or $imagetype === IMAGETYPE_GIF )){
        $target_file = "uploads/";
        $target_file = $target_file.$username;
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $_SESSION['error'] = ['success', 'Immagine Profilo Aggiornata Correttamente'];
            return $target_file;
        } else {
            $_SESSION['error'] = ['danger', "Errore durante il caricamento dell'immagine"];
        }
        return $target_file;
    } else {
        $_SESSION['error']= ['danger', "Il file deve essere un immagine di tipo JPEG,PMG o GIF"];
    }
    return FALSE;
}
?>