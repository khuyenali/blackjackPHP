<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php

    session_start();
    include_once 'database.php' ?>
    <div>
        <button><a href="admin.php">Admin login</a></button>
    </div>
    <div id="container">
        <div id="login">
            <div>Login</div>
            <form action="index.php" method="GET">
                <label>ID</label>
                <input type="text" name="idLogin" id="idLogin" required><br>
                <label>Password</label>
                <input type="text" name="passwordLogin" id="passwordLogin" required><br>
                <div class="buttonContainer">
                    <label></label>
                    <input type="submit" value="Clean" id="cleanLogin" name="cleanLogin" formnovalidate>
                    <input type="submit" value="submit" id="submitLogina" name="submitLogin">
                </div>
            </form>
        </div>
        <div id="new">
            <div>Create</div>
            <form action="index.php" method="GET">
                <label>ID</label>
                <input type="text" name="idNew" id="idNew" required><br>

                <label>Password</label>
                <input type="text" name="passwordNew" id="passwordNew" required><br>
                <label>Repeat Password</label>
                <input type="text" name="repasswordNew" id="repasswordNew" required><br>
                <div class="buttonContainer">
                    <label></label>
                    <input type="submit" value="Clean" id="cleanNew" name="cleanNew" formnovalidate>
                    <input type="submit" value="submit" id="submitNew" name="submitNew">
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_GET['submitNew'])) {
        $id = $_GET['idNew'];
        $password = $_GET['passwordNew'];
        $rePass = $_GET['repasswordNew'];
        if ($password === $rePass) {
            $sql = 'INSERT INTO player VALUES("' . $id . '", "' . $password . '", "' . 1000 . '")';
            if ($conn->query($sql)) {
                echo 'User create successfully';
            } else {
                // echo 'Error ' . mysqli_error($link);
                echo 'ID was taken!';
            }
        } else {
            echo 'Repeat password must match with password';
        }
    }

    if (isset($_GET['submitLogin'])) {
        $id = $_GET['idLogin'];
        $password = $_GET['passwordLogin'];
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
                echo 'Wrong password';
            }
        } else {
            echo 'ID not found';
        }
    }

    // mysqli_close($link);
    $conn->close();
    ?>
</body>

</html>