<?php 
require_once('includes/db.php');
require_once('includes/validateInput.php');
require_once('includes/generareInput.php');
require_once('includes/function.php');
session_start();

echo '<a href="admin.php">Inapoi pagina Admin</a>';
echo '<br>';
echo '<br>';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (
        validateInput([
            'departament'=> ['required' => true],
            'categorii' => ['required' => true]
        ])
    ) {
        // colecatam din formular datele
        $departament = $_POST['departament'];
        $categorii = $_POST['categorii'];
        //Creare baza de data
        $query = "INSERT INTO departament (departament, categorii) VALUES ('$departament', '$categorii')";
        mysqli_query($conn, $query);
         header('Location: admin.php');
    

    

    } else {
        echo '<p style="color:red">Nu ati introdus datele corect!</p>';
        echo '<br>';
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <br>
    <label>Departament</label>
    <?php generateInput('text', 'departament', 'introduce-ti departament'); ?>
    <br>
    <label>Categorii</label>
    <?php generateInput('text', 'categorii', 'introduce-ti categorii'); ?>
    <br />
    <input type='submit' value="submit" name='submit' />
</form>


</html>