<!-- 410705640 李任本耀 第8次作業12/23
4107056040 BenYao 8th Homework 12/23  -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <meta http-equiv="x-ua-compatible" content="IE=11" /> -->
  <link rel="stylesheet" href="./css/app.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400&display=swap" rel="stylesheet" />
  <title>21 Point</title>
</head>

<body>

  <?php
  session_start();
  ?>

  <?php include_once 'game.php'; ?>

  <?php
  if (isset($_POST['stand'])) {
    $com->auto($deck, $player);
    $com->compare($player);
  }
  if (isset($_POST['signal'])) {
    if ($_POST['bet'] > $player->chips) {
      echo '<div class="warning">Please add more chips in user info</div>';
      unset($_POST['signal']);
    } else if ($_POST['bet'] <= 0) {
      echo '<div class="warning">Bets amount must be positive number</div>';
      unset($_POST['signal']);
    }
  }
  ?>


  <div id="menu">
    <ul>
      <div id="left">
        <!-- <li id="bj">BlackJack</li> -->
      </div>
      <div id="right">
        <?php
        echo '<li>ID: ' . $player->id . '</li>';
        ?>
        <li><a href="user.php">User info</a></li>
        <li><a href="index.php">Log out</a></li>
      </div>
    </ul>
  </div>
  <div id="playGround" style="height: 100vh;">
    <div id="com">
      <div id="p9" class="isSignal">
        <div>Dealer</div>
        <div id="img9" class="img">
          <?php
          if (isset($_POST['stand'])) {
            foreach ($com->hand as $card) {
              echo '<img src="Cards/' . $card['value'] . $card['suit'] . '.png" alt="" >';
            }
          } else {
            if (isset($_POST['signal'])) {
              $com->hand[] = $deck->getCard();
              $com->hand[] = $deck->getCard();
              $com->calPoint();
              echo '<img src="Cards/BackCard.jpg" alt="" >';
              echo '<img src="Cards/' . $com->hand[1]['value'] . $com->hand[1]['suit'] . '.png" alt="" >';
            } else if (isset($_POST['hit'])) {
              echo '<img src="Cards/BackCard.jpg" alt="" >';
              echo '<img src="Cards/' . $com->hand[1]['value'] . $com->hand[1]['suit'] . '.png" alt="" >';
            }
          }
          ?>
        </div>
        <div id="status9" class="status">
          <?php
          if (isset($_POST['stand']))
            echo '<div id="point0">Point: ' . $com->point[1] . '</div>';
          ?>
        </div>
      </div>
    </div>
    <div id="players">
      <div id="p0" class="player selected">
        <div id=" playerText0">
          <?php
          // echo 'ID: ' . $player->id;
          ?>
        </div>
        <div id="img0" class="img">
          <?php
          if (isset($_POST['signal'])) {
            $player->hand[] = $deck->getCard();
            $player->hand[] = $deck->getCard();
            $player->calPoint();
            $player->bets = $_POST['bet'];
            $_SESSION['player'] = serialize($player);
            $_SESSION['com'] = serialize($com);
            $_SESSION['deck'] = serialize($deck);
            echo '<img src="Cards/' . $player->hand[0]['value'] . $player->hand[0]['suit'] . '.png" alt="" >';
            echo '<img src="Cards/' . $player->hand[1]['value'] . $player->hand[1]['suit'] . '.png" alt="" >';
          }

          if (isset($_POST['hit']) || isset($_POST['stand'])) {
            if (isset($_POST['hit'])) {
              $newCard = $deck->getCard();
              $player->hand[] = $newCard;
              $player->calPoint();
            }
            $_SESSION['player'] = serialize($player);
            $_SESSION['com'] = serialize($com);
            $_SESSION['deck'] = serialize($deck);
            foreach ($player->hand as $card) {
              echo '<img src="Cards/' . $card['value'] . $card['suit'] . '.png" alt="" >';
            }
          }
          ?>
        </div>
        <div id="status0" class="status">

          <?php

          echo '<div id="chips0">Chips: ' . $player->chips . '</div>';
          if (isset($_POST['stand'])) {
            echo '<div id="point0">Point: ' . $player->point[1] . '</div>';
            echo '<div id="">Result: ' . $player->status . '</div>';
            // $player->bets = 0;
          } else {
            echo '<div id="bets0">Bets: '  . $player->bets . '</div>';
          }
          if (isset($_POST['signal']) || isset($_POST['hit']))
            echo '<div id="point0">Point: ' . $player->point[1] . '</div>';
          ?>
        </div>

        <div id="button0">
          <form action="app.php" method="POST">
            <input type='submit' id="hit0" name="hit" value="Hit" <?php
                                                                  if (isset($_POST['signal']) || isset($_POST['hit'])) {
                                                                    echo '';
                                                                  } else
                                                                    echo 'hidden';
                                                                  ?>>
            <input type='submit' id="stand0" value="Stand" name="stand" <?php
                                                                        if (isset($_POST['signal']) || isset($_POST['hit'])) {
                                                                          echo '';
                                                                        } else
                                                                          echo 'hidden';
                                                                        ?>>
            <input type="number" class="input" id="input0" name="bet" <?php
                                                                      if (isset($_POST['signal']) || isset($_POST['hit']) || isset($_POST['stand'])) {
                                                                        echo 'hidden';
                                                                      } else
                                                                        echo ' required';
                                                                      ?>>
            <input type='submit' name='signal' id="signal0" value="Signal" <?php
                                                                            if (isset($_POST['signal']) || isset($_POST['hit']) || isset($_POST['stand'])) {
                                                                              echo 'hidden';
                                                                            } else
                                                                              echo '';
                                                                            ?>>
            <input type='submit' name='again' id="again" value="Play Agian" <?php
                                                                            if (isset($_POST['stand'])) {
                                                                              echo '';
                                                                            } else
                                                                              echo 'hidden';
                                                                            ?>>
            <!-- <input type="submit" name="clear" value="clear" formnovalidate> -->
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST['stand'])) {
    setcookie('id', $player->id, time() + 60);
    setcookie('result', $player->status, time() + 60);
    include_once "database.php";
    // print_r($conn);

    $sql = 'INSERT INTO game(uID, dealerPoint, userPoint, result, chipsRemains) VALUES ("' . $player->id . '", "' . $com->point[1] . '", "' . $player->point[1] . '", "' . $player->status . '", ' . $player->chips . ')';
    $sql1 = 'UPDATE player set chips =' . $player->chips . ' WHERE id="' . $player->id . '"';
    if ($conn->query($sql)) {
      // echo "game update successfully.";
    } else {
      echo "ERROR: Could not able to execute at game $sql. " . $conn->error;
    }

    if ($conn->query($sql1)) {
      // echo "player update successfully.";
    } else {
      echo "ERROR: Could not able to execute at player $sql1. " . $conn->error;
    }

    if ($player->status[0] === 'W') {
      $sql = 'UPDATE admin SET totalLose=totalLose+1, balance=balance-' . $player->bets . '';
    } else if ($player->status[0] === 'L') {
      $sql = 'UPDATE admin SET totalWin=totalWin+1, balance=balance+' . $player->bets . '';
    }


    if ($conn->query($sql)) {
      // echo "player update successfully.";
    } else {
      echo "ERROR: Could not able to execute at player $sql1. " . $conn->error;
    }

    $conn->close();
    $player->hand = [];
    $com->hand = [];
    $player->bets = 0;
    $_SESSION['player'] = serialize($player);
    $_SESSION['com'] = serialize($com);
    $_SESSION['deck'] = serialize($deck);
  }
  ?>
</body>

</html>