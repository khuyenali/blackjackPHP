<!-- 410705640 李任本耀 第8次作業12/23
4107056040 BenYao 8th Homework 12/23  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@500&display=swap" rel="stylesheet" />
</head>

<body>
    <div>
        <div id="title">Admin Page</div>
        <?php
        include_once "database.php";

        ?>
        <div class="container">

            <table id="statistic">
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

        </div>
        <div> <a href="index.php" id="return"> Return to login page</a></div>
        <div class="contact">
            <form action="admin.php" method="GET">
                <div id="formtitle">Check user history game</div>
                <select name="id" id="id" class="contact-form-input">
                    <option value="all">All</option>
                    <?php
                    $sql = 'SELECT id FROM player';
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($info = $result->fetch_assoc()) {
                            echo '<option class="contact-form-input">';
                            echo $info['id'];
                            echo '</option>';
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="submit" class="contact-form-submit">
            </form>
        </div>

        <?php
        if (isset($_GET['id'])) {
            echo '<div style="margin-top: 1rem;height:55vh;overflow:auto;">
        <div id="tableTitle">Game record of ' . $_GET['id'] . '</div>
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


            echo '</table></div>';
        }
        ?>
    </div>
</body>

</html>