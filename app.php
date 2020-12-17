<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <meta http-equiv="x-ua-compatible" content="IE=11" /> -->
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet" />
  <title>21 Point</title>
</head>

<body>
  <?php
  session_start();
  ?>

  <?php include_once 'game.php'; ?>

  <?php
  echo $hello;
  if (isset($_POST['stand'])) {
    $com->auto($deck, $player);
    $com->compare($player);
    $player->bet = 0;
    $player->point = [0, ''];
    $_SESSION['player'] = serialize($player);
    $_SESSION['com'] = serialize($com);
    $_SESSION['deck'] = serialize($deck);
  }
  ?>
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
        echo 'ID: '.$player->id;
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
            echo '<div id="">Result: ' . $player->status . '</div>';
            $player->bets = 0;
          } else {
            echo '<div id="bets0">Bets: '  . $player->bets . '</div>';
          }
          if (isset($_POST['signal']) || isset($_POST['hit']))
            echo '<div id="point0">Point: ' . $player->point[1] . '</div>';
          ?>
        </div>
        <div id="button0">
          <form action="app.php" method="POST">
            <input type='submit' id="assign0" value="Assign chips" <?php
                                                                    if (isset($_POST['signal']) || isset($_POST['hit']) || isset($_POST['stand'])) {
                                                                      echo 'hidden';
                                                                    } else
                                                                      echo '';
                                                                    ?>>
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
            <input type='submit' name='again' id="aa" value="Play Agian" <?php
                                                                          if (isset($_POST['stand'])) {
                                                                            echo '';
                                                                          } else
                                                                            echo 'hidden';
                                                                          ?>>
            <input type="submit" name="clear" value="clear" formnovalidate>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST['stand'])) {
    $player->hand = [];
    $player->bet = 0;
    $com->hand = [];
    $_SESSION['player'] = serialize($player);
    $_SESSION['com'] = serialize($com);
  }
  ?>
</body>

</html>