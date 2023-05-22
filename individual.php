<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('includes/db.php');
require_once('includes/validateInput.php');
require_once('includes/generareInput.php');
echo '<a href="admin.php">Inapoi la pagina de Admin</a>';
echo '<br>';
echo '<br>';

// indetificam userul
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // cules date din baza de date pentru userul respectiv
        $id = $_GET['id'];
        $query = "SELECT * FROM addinfo WHERE id='$id'";

        $result = mysqli_query($conn, $query);
        $utilizator = mysqli_fetch_assoc($result);

    } else {
        die('utilizator inexistent');
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (isset($_POST['delete']) && !empty($_POST['delete'])) {

        $id = $_POST['id'];

        $query = "DELETE FROM addinfo WHERE id='$id'";

        $result = mysqli_query($conn, $query);

        header("Location:admin.php");
    } else {
        if (
            validateInput([            
            'nume' => ['required' => true],
            'prenume' => ['required' => true],
            'email' => ['required' => true, 'valid'=> true, 'domeniu'=>true],
            'parola' => ['required' => true , 'min' => 8 ,'max' => 25, 'conditie' => true],
            'telefon' => ['required' => true ],
            'departament' => ['required' => true],
            'categorii' => ['required' => true],
            'ore' => ['required' => true]])
        ) {
           if(isset($_POST['nume']) && !empty($_POST['nume']) && isset($_POST['prenume']) && !empty($_POST['prenume']) &&
           isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['parola']) && !empty($_POST['parola']) &&
           isset($_POST['telefon']) && !empty($_POST['telefon']) && isset($_POST['departament']) && !empty($_POST['departament']) &&
           isset($_POST['categorii']) && !empty($_POST['categorii']) && isset($_POST['ore']) && !empty($_POST['ore'])){

         $nume = $_POST['nume'];
         $prenume = $_POST['prenume'];
         $email = $_POST['email'];
         $parola = $_POST['parola'];
         $telefon = $_POST['telefon'];
         $departament = $_POST['departament'];
         $categorii = $_POST['categorii'];
         $ore= $_POST['ore'];

            $query = "UPDATE addinfo SET 
            nume='$nume', 
            prenume='$prenume',
            email='$email', 
            parola='$parola', 
            telefon='$telefon', 
            departament ='$departament', 
            categorii='$categorii', 
            ore='$ore' 
            WHERE id='$id'";

            $result = mysqli_query($conn, $query);

            header("Location: individual.php?id=$id");
        
        }
        

        } else {
            echo '<p style="color:red">Nu ati introdus datele corect!</p>';
            echo '<br>';

        }
    }

}
?>


<html>


<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <input name="id" value="<?php echo $utilizator['id'] ?>" hidden />
        <label>Nume:</label>
        <br>
        <input type="text" name="nume" value="<?php echo $utilizator['nume'] ?>" />
        <br>
        <label>Prenume</label>
        <br>
        <input type="text" name="prenume" value="<?php echo $utilizator['prenume'] ?>" />
        <br>
        <label>E-mail</label>
        <br>
        <input type="text" name="email" value="<?php echo $utilizator['email'] ?>" />
        <br>
        <label>Parola</label>
        <br>
        <input type="password" name="parola" value="<?php echo $utilizator['parola'] ?>" />
        <br>
        <label>Telefon</label>
        <br>
        <input type="number" name="telefon" value="<?php echo $utilizator['telefon'] ?>" />
        <br>
        <label>Departament</label>
        <br>
        <input type="text" name="departamen" value="<?php echo $utilizator['departament'] ?>" />
        <br />
        <label>Categorii</label>
        <br>
        <input type="text" name="categorii" value="<?php echo $utilizator['categorii'] ?>" />
        <br />
        <label>Ore</label>
        <br>
        <input type="number" name="ore" value="<?php echo $utilizator['ore'] ?>" />
        <br />
        <input type="submit" value="modifica utilizator" />

    </form>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <input type="text" name="delete" value="yes" hidden />
        <input name="id" value="<?php echo $utilizator['id'] ?>" hidden />
        <p>Dezactiveaza Utilizator:</p>
        <input type="submit" value="sterge">
    </form>


</html>