<?php

function validateInput($reguliDeValidare)
{
    // 2.Verifica valorile trimise din formular prin $_POST
//      2.1 Folosim un parametru pentru verificare
//      2.2 Folosim ca parametru un array
//      2.3 const $array = ['nume' => 'required|min:3|max:20']
//      2.3.1 $array = ['nume' => ['required' => true, 'min'=> 3, 'max'=>20]] --> varianta folosita
    foreach ($reguliDeValidare as $numeCamp => $reguli) { // parcurgem reguli de validare
        foreach ($reguli as $regulaKey => $regulaValue) { // parcurgem fiecare regula

            // 3.Pune mesaje de eroare pentru fiecare validare esuata
            //      3.1 setam mesajul de eroare $_POST['errors']['numele campului'] 
            switch ($regulaKey) {
                case 'required': {
                        if ($regulaValue) {
                            if (!isset($_POST[$numeCamp]) || empty($_POST[$numeCamp])) {
                                $_POST['errors'][$numeCamp] = $numeCamp . ' este obligatoriu.';
                            }
                        }
                        break;
                    }
                case 'min': {
                        if (strlen($_POST[$numeCamp]) < $regulaValue) {
                            $_POST['errors'][$numeCamp] = $numeCamp . ' este prea scurt.';
                        }

                        break;
                    }
                case 'max': {
                        if (strlen($_POST[$numeCamp]) > $regulaValue) {
                            $_POST['errors'][$numeCamp] = $numeCamp . '  este prea lung.';
                        }
                        break;
                    }
                case 'valid': {
                    if(!filter_var($_POST[$numeCamp], FILTER_VALIDATE_EMAIL)){
                     $_POST['errors'][$numeCamp] = $numeCamp . ' nu contine @ .';
                    } 
                    break;
                }
                case 'domeniu':{
                    $blacklistDomains = ['gmail.com', 'yahoo.com', 'googlemail.com'];
                    // Împărtire e-mailul după „@” pentru a obține domeniul
                    $emailParts = explode('@', $_POST[$numeCamp]);
                    if (!(in_array(end($emailParts), $blacklistDomains))) {
                    $_POST['errors'][$numeCamp] = $numeCamp . ' trebuie introdus numai gmail.com , yahoo.com si googlemail.com ';
                    }
                    break;
                }
                case 'conditie': {
                    if(!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $_POST[$numeCamp])){
                        $_POST['errors'][$numeCamp] = $numeCamp . ' trebuie introdus cel putin o litera mare, una mica, un numar si un carcter special '; 
                    }
                    break;
                }
                case 'identica': {
                    if($_POST[$numeCamp] != $regulaValue){
                        $_POST['errors'][$numeCamp] = $numeCamp . ' nu este idenitica cu campul PAROLA ';
                    }
                    break;
                } 
                default:
                break;
            }
        }
    }
    // 4.Opreste executia daca sunt validari esuate
    //      4.1 daca este setat $_POST['errors'] si nu este gol $_POST['errors']
    //      4.2 return false
    if (isset($_POST['errors']) && !empty($_POST['errors'])) {
        return false;
    }

    return true;
}