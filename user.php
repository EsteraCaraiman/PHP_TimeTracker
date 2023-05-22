<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('includes/db.php');
require_once('includes/validateInput.php');
require_once('includes/navUser.php');
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: register.php'); // regula de aplicate in toate fisierele protejate de autentificare
}


if (isset($_POST['submit'])){
    // Obțineți valorile selectate din formular
    $departament1 = $_POST['departament1'];
    $categorii = $_POST['categorii'];
    $ore_lucrate = $_POST['ore_lucrate'];
   

    // Verificați dacă departamentele și categoria au fost selectate
    if (!empty($departament1)  && !empty($categorii) && !empty($ore_lucrate)) {
        // Actualizați numărul de ore pentru departamentul specificat și categorie
        $query1 = "UPDATE departament SET ore_lucrate = $ore_lucrate WHERE departament = '$departament1' AND categorii = '$categorii'";
        $res = mysqli_query($conn, $query1);


        // Verificați dacă actualizarea a avut loc cu succes pentru ambele departamente
        if (mysqli_affected_rows($conn) > 0) {
            echo "Numărul de ore a fost actualizat pentru departamentele $departament1 , categoria $categorii.";
            echo '<br>';
        } else {
            echo "Nu s-a putut actualiza numărul de ore pentru departamentele $departament1 , categoria $categorii.";
        }
    } else {
        echo "Vă rugăm să completați toate câmpurile.";
    }

 


}
if(isset($_POST['departament']) && !empty($_POST['departament']) && isset($_POST['categorii']) && !empty($_POST['categorii'])){
        $departament1 = $_POST['departament1'];
        $categorii = $_POST['categorii'];
        $ore_lucrate = $_POST['ore_lucrate'];

        $queryOre = "SELECT SUM(departament.ore_lucrate) AS ore_lucrate FROM departament WHERE departament = '$departament1' OR categorie = '$categorii'";
        $result = mysqli_query($conn, $queryOre);
        $row = mysqli_fetch_assoc($result);
        $totalOre = $row['total_ore'] + $ore;

      if ($totalOre < 8) {
        echo "Suma orelor logate pe toate departamentele sau categoriile este mai mare de 8 ore.";
        return;
    }
}


$selectQuery = "SELECT * FROM addinfo";
$array = mysqli_query($conn, $selectQuery);
$user = mysqli_fetch_assoc($array);
$_SESSION['telefon']=$user['telefon'];
$_SESSION['id'] = $user['id'];  
$_SESSION['parola'] = $user['parola'];  

// if (isset($_POST['submit'])) {
//     if (
//         validateInput(['nume' => ['required' => true], 'email' => ['required' => true, 'valid' => true, 'domeniu' => true], 'parola' => ['required' => true, 'min' => 8, 'max' => 25, 'conditie' => true], 'telefon' => ['required' => true]])
//     ) {
//         $nume = $_POST['nume'];
//         $email = $_POST['email'];
//         $parola = $_POST['parola'];
//         $telefon = $_POST['telefon'];

//         // Adăugați clauza WHERE pentru a actualiza doar înregistrarea utilizatorului curent
//         $query = "UPDATE addinfo SET nume='$nume', email='$email', parola='$parola', telefon='$telefon' WHERE email='$email'";
//         $result = mysqli_query($conn, $query);

//         if ($result) {
//             // Redirecționați utilizatorul către pagina de profil actualizată
//             header("Location: user.php");
//             exit;
//         } else {
//             echo '<p style="color:red">Eroare la actualizarea utilizatorului.</p>';
//         }
//     } else {
//         echo '<p style="color:red">Nu ați introdus datele corect!</p>';
//         echo '<br>';
//     }
// }



?>

<html>
<h3>Informatii utilizatori</h3>

<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Email</th>
            <th>Telefon</th>
        </tr>
        <tr>
            <td>
                <?php echo $_SESSION['id'] ?>
            </td>
            <td>
                <?php echo $_SESSION['nume'] ?>
            </td>
            <td>
                <?php echo $_SESSION['email'] ?>
            </td>
            <td>
                <?php echo $_SESSION['telefon'] ?>
            </td>

        </tr>
    </table>


    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Nume:</label>
        <br>
        <input type="text" name="nume" value="<?php echo $_SESSION['nume'] ?>" />
        <br>
        <label>E-mail:</label>
        <br>
        <input type="text" name="email" value="<?php echo $_SESSION['email'] ?>" />
        <br>
        <label>Parola:</label>
        <br>
        <input type="password" name="parola" value="<?php echo $_SESSION['parola'] ?>" />
        <br>
        <label>Telefon:</label>
        <br>
        <input type="number" name="telefon" value="<?php echo $_SESSION['telefon'] ?>" />
        <br>
        <br />
        <input type="submit" name="submit" value="Modifică utilizator" />
    </form>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <br>
        <br>
        <label for="departament1">Departament :</label>
        <input type="text" name="departament1" id="departament1">

        <label for="categorie">Categorie:</label>
        <input type="text" name="categorii" id="categorii">

        <label for="ore_lucrate">Număr de ore:</label>
        <input type="number" name="ore_lucrate" id="ore_lucrate">

        <button type="submit" name="submit">Adaugă număr de ore</button>
    </form>
</body>

</html>

</html>