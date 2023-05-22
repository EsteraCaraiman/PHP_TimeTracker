<?php if (
    isset($_SESSION['email']) && !empty($_SESSION['email'])
    && isset($_SESSION['nume']) && !empty($_SESSION['nume'])
): ?>
<p>Bine ai venit:
    <?php echo $_SESSION['nume'] ?>
</p>
<a href="index.php">Inregistrare date utilizator</a>
<br />
<a href="logout.php">Log Out</a>
<?php else: ?>
<a href="login.php">Login</a>
<br />
<a href="register.php">Register</a>
<?php endif ?>