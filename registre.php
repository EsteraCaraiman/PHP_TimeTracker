<?php 
require_once('includes/db.php');
require_once('includes/validateInput.php');
require_once('includes/generareInput.php');
require_once('includes/function.php');
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (
        validateInput([
            'nume' => ['required' => true],
            'email' => ['required' => true, 'valid'=> true, 'domeniu'=>true],
            'parola' => ['required' => true , 'min' => 8 ,'max' => 25, 'conditie' => true],
            'repeta_parola' => ['required' => true, 'identica'=> $_POST["parola"]],
            'rol' => ['required' => true]
        ])
    ) {
        // colecatam din formular datele
        $nume = $_POST['nume'];
        $email = $_POST['email'];
        $parola = $_POST['parola'];
        $repetaParola = $_POST['repeta_parola'];
        $rol = $_POST['rol'];
        //Creare baza de data pentru administrator
     
        $queryadmin = getOne( 'inregistrare', 'email', $email, $conn );
        $rowsadmin = mysqli_num_rows($queryadmin);
        if ($rowsadmin > 0) {
            echo 'utilizatorul exista deja';
            } else {
            // sa verificam parolele sa fie identice
            if ($parola === $repetaParola) {
                // sa facem un hash pentru parola si sa il salvam in baza de date 
                $hash = password_hash($parola, PASSWORD_DEFAULT);
                $query = create( 'inregistrare' , array (  'nume' ,  'email'  ,'parola' ,'rol' ) , array( $nume , $email  , $hash, $rol) , $conn);
                // $query = "INSERT INTO registreadministrator ( nume, email, parola, rol) VALUES ( '$nume', '$email','$hash', '$rol');";
                // mysqli_query($conn, $query);
                header('Location:login.php');
            } else {
                $_POST['errors']['parola'] = 'parolele trebuie sa fie identice.';
            }

        }
        
    

    

    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <br>
    <label>Nume</label>
    <?php generateInput('text', 'nume', 'introduce-ti numele'); ?>
    <br>
    <label>E-mail</label>
    <?php generateInput('email', 'email', 'introduce-ti adresa de email'); ?>
    <br>
    <label>Parola</label>
    <?php generateInput('password', 'parola', 'introduceti parola'); ?>
    <br>
    <label>Repeta Parola</label>
    <?php generateInput('password', 'repeta_parola', 'repetati parola'); ?>
    <br>
    <label>Rol:</label>
    <br />
    <label>Administrator</label>
    <input type="radio" value="administrator" name="rol" <?php if (isset($_POST['rol']) && $_POST['rol'] === 'administrator') {
        echo 'checked';
    } ?> />
    <label>Utilizator</label>
    <input type="radio" value="utilizatori" name="rol" <?php if (isset($_POST['rol']) && $_POST['rol'] === 'utilizatori') {
        echo 'checked';
    } ?> />
    <?php if (isset($_POST['errors']['rol']) && !empty($_POST['errors']['rol'])): ?>
    <p style="color:red">
        <?php echo $_POST['errors']['rol'] ?>
    </p>
    <?php endif ?>
    <br />
    <br />
    <input type='submit' value="submit" name='submit' />
</form>


</html>