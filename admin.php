<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div>Admin</div>

    <?php
    include_once "database.php";

    ?>
    <table>
        <tr>
            <th>Balance</th>
            <th>Total Win Game</th>
            <th>Total Lose Game</th>
        </tr>
        <?php
        $sql = 'SELECT * FROM admin';
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($info = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $info['balance'] . '</td>';
                echo '<td>' . $info['totalWin'] . '</td>';
                echo '<td>' . $info['totalLose'] . '</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
    <form action="admin.php" method="GET">
        <div>Check user history game</div>
        <select name="id" id="id">
            <option value="all">All</option>
            <?php
            $sql = 'SELECT id FROM player';
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($info = $result->fetch_assoc()) {
                    echo '<option>';
                    echo $info['id'];
                    echo '</option>';
                }
            }
            ?>
        </select>
        <input type="submit" value="submit">
    </form>

    <?php
    if (isset($_GET['id'])) {
        echo '<div>
        <div>Game record</div>
        <table>
            <tr>
                <th>Game ID</th>
                <th>User point</th>
                <th>Dealer point</th>
                <th>Result</th>
                <th>Chips remains</th>
            </tr>';
        if ($_GET['id'] == 'all') {
            $sql = 'SELECT * FROM game';
        } else {
            $sql = 'SELECT * FROM game WHERE uID="' . $_GET['id'] . '"';
        }
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


        echo '</table>
    </div>';
    }
    ?>
    <div><button> <a href="index.php"> Return to login page</a></button></div>
</body>

</html>