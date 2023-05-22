<?php
require_once('includes/db.php');
require_once('includes/validateInput.php');
require_once('includes/generareInput.php');
require_once('includes/function.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit'])) {

    if (
        // verificam inputul din formular
        validateInput([
            'email' => ['required' => true, 'valid'=> true, 'domeniu'=>true],
            'parola' => ['required' => true , 'min' => 8 ,'max' => 25, 'conditie' => true],
        ])
    ) {
        $email = $_POST['email'];
        $parola = $_POST['parola'];
       
        // sa verificam in baza de date daca exista
        $query = "SELECT * FROM inregistrare WHERE email='$email' ";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);
        if ($rows > 0) {
            //un utilizator cu email si parola care sunt identice cu datele noastre
            $user = mysqli_fetch_assoc($result);
            if (password_verify($parola, $user['parola'])) {
             // setam valor in superglobala de sesiune
             $_SESSION['email'] = $user['email'];
             $_SESSION['nume'] = $user['nume'];
             $_SESSION['rol'] = $user['rol'];
            

             if($_SESSION['rol'] === 'administrator'){
                header('Location:admin.php');
             }else if($_SESSION['rol'] === 'utilizator'){
                header('Location:user.php'); 
             }
             
            } 
        } else {
            echo 'Datele introduse nu sunt corecte.';
        }
    }
}
?>

<html>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <!--  sa aratam erori daca sunt -->
    <?php generateInput('email', 'email', 'introduceti email') ?>
    <br>
    <?php generateInput('password', 'parola', 'introduceti parola'); ?>
    <br>
    <input type="submit" name="submit" value="login" />
</form>

</html>