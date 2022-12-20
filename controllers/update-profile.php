<?php 

require '../core.php';

$validateName = false;
$validatePassword = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Get Values 
    $user_id = clearData($_POST['user_id']);
    $user_name = clearData($_POST['user_name']);
    $user_phone = clearData($_POST['user_phone']);
    $password_save = clearData($_POST['user_password_save']);
    $password = clearData($_POST['user_password']);
    $confirm_password = clearData($_POST['user_confirm_password']);
    

    if (empty($user_name)) {
        echo "<br><div class='ev-notify ev-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_159']."</div>";
    }elseif(!lengthInput($user_name, 3, 20)){
        echo "<br><div class='ev-notify ev-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_162']."</div>";
    }elseif (validateInput($user_name)) {
        echo "<br><div class='ev-notify ev-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_171']."</div>";
    }else{
        $validateName = true;
    }

    if (!empty($password) && !empty($confirm_password)) {

        if (empty($password) || empty($confirm_password)) {
            echo "<br><div class='ev-notify ev-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_160']."</div>";
        }elseif(!lengthInput($password, 8, 32) || !lengthInput($confirm_password, 8, 32)){
            echo "<br><div class='ev-notify ev-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_164']."</div>";
        }elseif($password != $confirm_password){
            echo "<br><div class='ev-notify ev-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_176']."</div>";
        }else{
            $validatePassword = true;
        }

    }else{
            $validatePassword = true;
    }

if ($validateName && $validatePassword) {

    if (empty($password)) {
        $password = $password_save;
    } else{
        $password = hash('sha512', $password);
    }

    $statment = $connect->prepare("UPDATE users SET user_name = :user_name, user_phone = :user_phone, user_password = :user_password WHERE user_id = :user_id");

    $statment->execute(array(
        ':user_id' => $user_id,
        ':user_name' => $user_name,
        ':user_phone' => $user_phone,
        ':user_password' => $password));

    echo "<br><div class='ev-notify ev-notify-success uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_190']."</div>";

}

}else{

    exit();
}


?>