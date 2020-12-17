<?php
if (isset($_POST['clear'])) {
    $_SESSION = [];
}
class Deck
{
    private $suits = ["S", "D", "C", "H"];
    private $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
    private $index = 0;
    function __construct()
    {
        $this->getDeck();
        $this->shuffle();
    }

    private $deck = array();
    function getDeck()
    {

        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 13; $j++) {
                $realValue = 0;
                switch ($this->values[$j]) {
                    case "A":
                        $realValue = 11;
                        break;
                    case "J":
                    case "Q":
                    case "K":
                        $realValue = 10;
                        break;
                    default:
                        $realValue = (int)($this->values[$j]);
                        break;
                }
                $card = ['value' => $this->values[$j], 'suit' => $this->suits[$i], 'realValue' => $realValue];
                // $deck.push($hand);
                // $desk[] = $card;
                array_push($this->deck, $card);
            }
        }
    }

    function printDeck()
    {
        // echo count($deck);
        foreach ($this->deck as $card)
            // foreach ($card as $key => $value) {
            // echo '<p>' . $card['value'] . '<p>';
            echo '<img src="Cards/' . $card['value'] . $card['suit'] . '.png" alt="" >';
        // }
    }

    function shuffle()
    {
        shuffle($this->deck);
    }

    function getCard()
    {
        if($this->index === 50){
            $this->deck = array();
            $this->index = 0;
            $this->getDeck();
            $this->shuffle();
        }
        $temp = $this->deck[$this->index++];
        // echo $temp;
        return $temp;
    }
}

if (isset($_SESSION['deck'])) {
    $deck = unserialize($_SESSION['deck']);
} else {
    $deck = new Deck();
}

class Com
{
    public ?string $id = null;
    public ?int $chips = null;
    public $hand = array();
    public $point = [0, ''];

    public function __construct($id)
    {
        $this->id = $id;
    }

    function callMe()
    {
        echo 'Hello' . $this->id;
    }

    function calPoint()
    {
        $point = 0;
        $numAce = 0;
        // print_r($this->hand);
        foreach ($this->hand as $card) {
            // print_r($card);
            $point += $card['realValue'];
            if ($card['value'] == 'A') {
                $numAce++;
            }
        }

        while ($numAce > 0) {
            if ($point > 21) {
                $point -= 10;
                $numAce--;
            } else {
                break;
            }
        }

        $stringPoint = '';
        if ($point > 21) {
            $stringPoint = 'Burst';
        } else if ($point == 21) {
            $stringPoint = 'BlackJack';
        } else {
            $stringPoint = $point;
        }

        $this->point = [$point, $stringPoint];
    }

    function compare(Player $player)
    {
        if ($player->point[1] === 'Burst') {
            $player->status = 'Lose -'. $player->bets;
            $player->chips -= $player->bets;
            // echo "L: " . $this->point[1] . " " . $player->point[1] . "";
        } else if ($this->point[1] === 'Burst' || $player->point[0] > $this->point[0]) {
            $player->status = 'Win +'. $player->bets;
            $player->chips += $player->bets;
            // echo "W: " . $this->point[1] . " " . $player->point[1] . "";
        } else if ($player->point[0] < $this->point[0]) {
            $player->status = 'Lose -'. $player->bets;
            $player->chips -= $player->bets;
            // echo "L: " . $this->point[1] . " " . $player->point[1] . "";
        } else {
            $player->status = "Draw"; 
            // echo "D: " . $this->point[1] . " " . $player->point[1] . "";
        }
    }

    function auto($deck, $player)
    {
        if ($player->point[1] === 'Burst') {
            return;
        }
        while ($this->point[0] < 17) {
            echo $this->point[0] . 'hello';
            $this->hand[] = $deck->getCard();
            $this->calPoint();
        }
    }

    // private function
}

class Player extends Com
{
    public ?int $bets = null;
    public $status = null;

    public function __construct($id, $chips)
    {
        $this->id = $id;
        $this->chips = $chips;
    }

    function callMe()
    {
        echo 'Hello' . $this->id;
    }
}

if (isset($_SESSION['player'])) {
    $player = unserialize($_SESSION['player']);
} else {
    $player = new Player('0', 1000);
}
// print_r($player);
if (isset($_SESSION['com'])) {
    $com = unserialize($_SESSION['com']);
} else {
    $com = new Player('9', 100);
}
