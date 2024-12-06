<?php
session_start();

$message = "";
if (!isset($_SESSION['target_number'])) {
    $_SESSION['target_number'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'])) {
        $_SESSION['name'] = ($_POST['name']);
    }

    if (isset($_POST['guess'])) {
        $guess = intval($_POST['guess']);
        $_SESSION['attempts']++;

        if ($guess > $_SESSION['target_number']) {
            $message = "Too high! Try again.";
        } elseif ($guess < $_SESSION['target_number']) {
            $message = "Too low! Try again.";
        } else {
            $message = "Congratulations, {$_SESSION['name']}! You guessed the number in {$_SESSION['attempts']} attempts.";

            unset($_SESSION['target_number']);
            unset($_SESSION['attempts']);
            unset($_SESSION['name']);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Guessing Game</title>
</head>
<body>
    <div class="container">
        <h1>GUESSING GAME</h1>
        <p><?php echo $message; ?></p>

        <?php if (!isset($_SESSION['name'])): ?>
            <form method="post">
                <label for="name"><b>Enter your name:</b></label><br><br>
                <input type="text" name="name" id="name" required>
                <button type="submit">Start Game</button>
            </form>
        <?php else: ?>
            <form method="post">
                <label for="guess"><b>Your Guess:</b></label><br><br>
                <input type="number" name="guess" id="guess" required min="1" max="100">
                <button type="submit">Submit Guess</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
