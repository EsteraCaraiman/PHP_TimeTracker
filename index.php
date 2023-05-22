<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('includes/db.php');
require_once('includes/validateInput.php');
require_once('includes/generareInput.php');
require_once('includes/function.php');

echo '<a href="admin.php">Inapoi pagina Admin</a>';
echo '<br>';
echo '<br>';
echo '<br>';
// if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
//     header('Location: register.php'); // regula de aplicate in toate fisierele protejate de autentificare
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
    validateInput([
            'nume' => ['required' => true],
            'prenume' => ['required' => true],
            'email' => ['required' => true, 'valid'=> true, 'domeniu'=>true],
            'parola' => ['required' => true , 'min' => 8 ,'max' => 25, 'conditie' => true],
            'telefon' => ['required' => true ],
            'departament' => ['required' => true],
            'categorii' => ['required' => true],
            'rol' => ['required' => true],
            'ore' => ['required' => true]
        ])
    ) {

        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $email = $_POST['email'];
        $parola = $_POST['parola'];
        $telefon = $_POST['telefon'];
        $departament = $_POST['departament'];
        $categorii = $_POST['categorii'];
        $rol= $_POST['rol'];
        $ore= $_POST['ore'];
        
        // $query = "INSERT INTO registre (nume, prenume, email, parola, telefon, departament, rol, ore) 
        // VALUES  ('$nume', '$prenume ', '$email', '$parola','$telefon', '$departament' '$rol','$ore' )";
        // mysqli_query($conn, $query);
        $hash = password_hash($parola, PASSWORD_DEFAULT);
        $query = create( 'addInfo' , array (  'nume' , 'prenume' , 'email'  ,'parola' ,'telefon', 'departament', 'categorii' ,'rol', 'ore' ) ,
        array( $nume, $prenume , $email  , $hash, $telefon , $departament, $categorii, $rol, $ore) , $conn);
        header('Location: admin.php');
        echo 'Datele au fost inregistrate';
        echo "<br>";

    } else {
        echo '<p style="color:red">Nu ati introdus datele corect!</p>';
        echo '<br>';
    }

}

?>



<html>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label>Nume</label>
    <?php generateInput('text', 'nume', 'introduceti numele') ?>
    <label>Prenume</label>
    <?php generateInput('text', 'prenume', 'introduceti prenumele') ?>
    <label>E-mail</label>
    <?php generateInput('email', 'email', 'introduce-ti adresa de email'); ?>
    <br>
    <label>Parola</label>
    <?php generateInput('password', 'parola', 'introduceti parola'); ?>
    <br>
    <label>Telefon</label>
    <?php generateInput('number', 'telefon', 'introduceti telefon') ?>
    <br />
    <label>Departament</label>
    <?php generateInput('text', 'departament', 'introduceti departamentul') ?>
    <br />
    <label>Categorii</label>
    <?php generateInput('text', 'categorii', 'introduceti departamentul') ?>
    <br />
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
    <label>Ore</label>
    <?php generateInput('number', 'ore', 'introduceti orele') ?>
    <button>Trimite</button>
</form>


</html>