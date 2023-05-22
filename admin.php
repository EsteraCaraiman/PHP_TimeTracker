<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('includes/db.php');
require_once('includes/validateInput.php');
require_once('includes/generareInput.php');
require_once('includes/navAdmin.php');

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: register.php'); // regula de aplicate in toate fisierele protejate de autentificare
}


$selectQuery = "SELECT * FROM addinfo";
$array = mysqli_query($conn, $selectQuery);

?>

<html>
<h3>Adaugare departamente si categorii</h3>
<button><a href='departament.php'>Adaugare</a></button>

</html>

<h3>Informatii utilizatori</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Nume</th>
        <th>Prenume</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Departament</th>
    </tr>
    <?php foreach ($array as $ar): ?>
    <tr>
        <td>
            <?php echo $ar['id'] ?>

        </td>
        <td>
            <?php echo $ar['nume'] ?>
        </td>
        <td>
            <?php echo $ar['prenume'] ?>
        </td>
        <td>
            <?php echo $ar['email'] ?>
        </td>
        <td>
            <?php echo $ar['rol'] ?>
        </td>
        <td>
            <?php echo $ar['departament'] ?>
        </td>
        <td>
            <button><a href="individual.php?id=<?php echo $ar['id'] ?>" </a>Vizualizare profil</a></button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<h3>Vizualizarea orelor logate de utilizatori dintr-un anumit departament</h3>


<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label>Departament</label>
    <input type="text" name="departament">
    <button type="submit">Afiseaza ore</button>
</form>

<?php
if(isset($_POST['departament']) && !empty($_POST['departament'])) {
    // Obținerea valorii selectate din input
    $departament = $_POST['departament'];

    // Interogarea SELECT cu JOIN pentru a obține orele logate în funcție de numele departamentului selectat
    $sql = "SELECT SUM(addinfo.ore) AS ore FROM addinfo 
        JOIN departament ON addinfo.departament = departament.departament 
        WHERE departament.departament = '$departament'";
    $result = mysqli_query($conn, $sql);
    $utilizatorOre = mysqli_fetch_assoc($result);
    echo "Numarul de ore logate pentru departamentul $departament este: ".$utilizatorOre['ore'];

}
?>

<html>
<br>


</html>
<br>

<h3>Mutarea utilizatorilor dintr-un departament in altul</h3>

<?php

  if(isset($_POST['email']) && !empty($_POST['email'])){
    // preluăm valorile din formular
  $email = $_POST['email'];
  $departament = $_POST['departament'];

  // actualizăm tabela addinfo
  $sqlAdd = "UPDATE addinfo SET departament = '$departament' WHERE email = '$email'";
  $result = mysqli_query($conn, $sqlAdd);

  // verificăm dacă actualizarea a avut loc cu succes
  if ($result) {
    echo "Utilizatorul a fost mutat în departamentul $departament.";
    echo '<br>';
    echo '<br>';
  } else {
    echo "Eroare la mutarea utilizatorului în departamentul $departament.";
    echo '<br>';
  }

  }
  
?>

<html>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="email">Selectează utilizatorul:</label>
        <select name="email" id="email">
            <?php
          // afișăm opțiunile pentru selectarea utilizatorului
          $sql = "SELECT * FROM addinfo ORDER BY email";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='".$row['email']."'>".$row['email']."</option>";
          }
        ?>
        </select>

        <br>
        <br>
        <label for="departament">Mută utilizatorul în departamentul:</label>
        <select name="departament" id="departament">
            <?php
          // afișăm opțiunile pentru selectarea noului departament
          $sql = "SELECT * FROM departament ORDER BY departament";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='".$row['departament']."'>".$row['departament']."</option>";
          }
        ?>
        </select>

        <br>
        <br>
        <button type="submit">Mută utilizatorul</button>
    </form>
</body>

</html>