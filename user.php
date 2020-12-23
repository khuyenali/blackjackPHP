<!-- 410705640 李任本耀 第8次作業12/23
4107056040 BenYao 8th Homework 12/23  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/user.css">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400&display=swap" rel="stylesheet" />
</head>

<body>


    <?php
    session_start();
    include_once 'game.php';
    include_once 'database.php';
    $id = $player->id;

    if (isset($_GET['add'])) {
        $sql = 'UPDATE player SET chips=chips+' . $_GET['amount'] . ' WHERE id="' . $id . '"';
        if ($conn->query($sql)) {
            // echo "player update successfully.";
        } else {
            echo "ERROR: Could not able to execute at player $sql1. " . $conn->error;
        }
    }

    $sql = 'SELECT *, password, chips FROM player WHERE id="' . $id . '"';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $info = $result->fetch_assoc();
        $chips =  $info['chips'];
    }

    ?>
    <div>



    </div>
    <div id="menu">
        <ul>
            <div id="left">
                <!-- <li id="bj">BlackJack</li> -->
            </div>
            <div>
                <form action="app.php" id="right">
                    <?php
                    $sql = 'SELECT id, password, chips FROM player WHERE id="' . $id . '"';
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $info = $result->fetch_assoc();
                        $player = new Player($id, $info['chips']);
                        $com = new Player('9', 100);

                        $_SESSION['player'] = serialize($player);
                        $_SESSION['com'] = serialize($com);
                    }
                    ?>
                    <li><input type="submit" value="Play" id="play"></li>
                    <li><a href="index.php">Log out</a></li>
                </form>
            </div>
        </ul>
    </div>
    <div class="container">
        <div id="title">User infomation</div>
        <div class="label">ID: <?php echo $id ?></div>
        <div class="label">Chips: <?php echo $chips ?></div>
        <form action="user.php" method="GET">
            <input type="text" name="amount" class="contact-form-input">
            <input type="submit" value="Add chips" name="add" class="contact-form-submit">
        </form>
        <div style="margin-top: 1rem;height:60vh;overflow:auto;">
            <div id="tableTitle">Game record</div>
            <table>
                <tr>
                    <th>Game ID</th>
                    <th>User point</th>
                    <th>Dealer point</th>
                    <th>Result</th>
                    <th>Chips remains</th>
                </tr>
                <?php
                $sql = 'SELECT * FROM game WHERE uID="' . $player->id . '"';
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($info = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $info['gID'] . ' ' . '</td>';
                        echo '<td>' . $info['userPoint'] . ' ' . '</td>';
                        echo '<td>' . $info['dealerPoint'] . ' ' . '</td>';
                        echo '<td>' . $info['result'] . ' ' . '</td>';
                        echo '<td>' . $info['chipsRemains'] . ' ' . '</td>';
                        echo '</tr>';
                    }
                }
                ?>


            </table>
        </div>


        <?php
        $conn->close();
        ?>

    </div>
</body>

</html>