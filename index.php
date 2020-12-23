<!-- 410705640 李任本耀 第8次作業12/23
4107056040 BenYao 8th Homework 12/23 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@500&display=swap" rel="stylesheet" />
</head>

<body>

    <?php
    // print_r($_COOKIE['result']);
    session_start();
    include_once 'database.php' ?>
    <div id="welcome">Welcome to blackjack</div>
    <div>
        <a href="admin.php" id="admin">Admin login</a>
    </div>
    <div id="container">
        <div id="login" class="contact">
            <div>Login</div>
            <form action="index.php" method="POST">
                <div class="contact-form-group">
                    <label class="contact-form-label">ID</label>
                    <input type="text" name="idLogin" id="idLogin" class="contact-form-input" required>
                </div>
                <div class="contact-form-group">
                    <label class="contact-form-label">Password</label>
                    <input type="password" name="passwordLogin" id="passwordLogin" class="contact-form-input" required>
                </div>
                <div class="buttonContainer">
                    <!-- <label></label> -->
                    <input type="submit" value="Clean" id="cleanLogin" name="cleanLogin" class="contact-form-submit" formnovalidate>
                    <input type="submit" value="submit" id="submitLogina" name="submitLogin" class="contact-form-submit">
                </div>
            </form>
        </div>
        <div id="new" class="contact">
            <div>Create</div>
            <form action="index.php" method="POST">
                <div class="contact-form-group">
                    <label class="contact-form-label">ID</label>
                    <input type="text" name="idNew" id="idNew" class="contact-form-input" required>
                </div>

                <div class="contact-form-group">
                    <label class="contact-form-label">Password</label>
                    <input type="password" name="passwordNew" id="passwordNew" class="contact-form-input" required>
                </div>
                <div class="contact-form-group">
                    <label class="contact-form-label">Confirm Password</label>
                    <input type="password" name="repasswordNew" id="repasswordNew" class="contact-form-input" required>
                </div>
                <div class="buttonContainer">
                    <!-- <label></label> -->
                    <input type="submit" value="Clean" id="cleanNew" name="cleanNew" class="contact-form-submit" formnovalidate>
                    <input type="submit" value="submit" id="submitNew" name="submitNew" class="contact-form-submit">
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['submitNew'])) {
        $id = $_POST['idNew'];
        $password = $_POST['passwordNew'];
        $rePass = $_POST['repasswordNew'];
        if ($password === $rePass) {
            $sql = 'INSERT INTO player VALUES("' . $id . '", "' . $password . '", "' . 1000 . '")';
            if ($conn->query($sql)) {
                echo '<div class="warning">User create successfully</div>';
            } else {
                // echo 'Error ' . mysqli_error($link);
                echo '<div class="warning">ID was taken!</div>';
            }
        } else {
            echo '<div class="warning">Confirm password must match with password</div>';
        }
    }

    if (isset($_POST['submitLogin'])) {
        $id = $_POST['idLogin'];
        $password = $_POST['passwordLogin'];
        $sql = 'SELECT id, password, chips FROM player WHERE id="' . $id . '"';
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // echo $mysqli_result;
            // while($row = $result->fetch_assoc()){
            //     echo $row['id'];
            // }
            // echo 'Wrong id or password';
            $info = $result->fetch_assoc();
            if ($info['password'] === $password) {
                echo 'Login!!!';
                include_once 'game.php';

                $player = new Player($id, $info['chips']);
                $com = new Player('9', 100);

                $_SESSION['player'] = serialize($player);
                $_SESSION['com'] = serialize($com);
                // $_SESSION['$conn'] = serialize($conn);
                header('Location: ./app.php');
                $conn->close();
                exit();
                //to do

            } else {
                echo '<div class="warning">Wrong ID or password</div>';
            }
        } else {
            echo '<div class="warning">Wrong ID or password</div>';
        }
    }

    // mysqli_close($link);
    $conn->close();
    ?>
</body>

</html>