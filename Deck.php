<?php

//  410705640 李任本耀 第8次作業12/23
// 4107056040 BenYao 8th Homework 12/23
namespace app;

$hello = 231;
class Deck
{
    private $suits = ["S", "D", "C", "H"];
    private $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];

    function __construct()
    {
        $this->getDesk();
    }

    private $deck = array();
    function getDesk()
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
        // echo count($deck);
        // foreach ($this->deck as $card)
        //     // foreach ($card as $key => $value) {
        //     // echo '<p>' . $card['value'] . '<p>';
        //     echo '<img src="Cards/' . $card['value'] . $card['suit'] . '.png" alt="" >';
        // // }
    }
}
