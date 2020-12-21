<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="user.css">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet" />
</head>

<body>
    <?php
    session_start();
    include_once 'game.php';
    include_once 'database.php';
    $id = $player->id;

    $sql = 'SELECT *, password, chips FROM player WHERE id="' . $id . '"';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $info = $result->fetch_assoc();
        $chips =  $info['chips'];
    }

    ?>

    <div id="title">User infomation</div>
    <div>ID: <?php echo $id ?></div>
    <div>Chips: <?php echo $chips ?></div>

    <div>
        <div>Game record</div>
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

    <div>
        <form action="app.php">
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
            <input type="submit" value="Play">
        </form>
        <a href="index.php">Log out</a>
    </div>
    <?php
    $conn->close();
    ?>

</body>

</html>