<?php

/**
 * ------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * DontGoInThere implementation : © Evan Pulgino <evan.pulgino@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * SecretPassage.class.php
 * 
 * Secret Passage room object
 */

class SecretPassage extends DontGoInThereRoom
{
    public function __construct($game, $row)
    {
        parent::__construct($game);
        $this->id = $row[ID];
        $this->name = clienttranslate('Secret Passage');
        $this->type = SECRET_PASSAGE;
        $this->cssClass = "dgit-room-secret-passage";
        $this->tooltipText = self::buildTooltipText();;
        $this->flipSideRoom = LIBRARY;
        $this->uiPosition = $row[LOCATION_ARG];
    }

    /**
     * Build tooltip text for Secret Passage
     * @return string Tooltip text
     */
    private function buildTooltipText()
    {
        return clienttranslate('Place the 3rd Cursed card in the Secret Passage face-down. If you place a Meeple here, secretly look at the face-down card. When a 3rd Meeple is placed here, reveal the card.');
    }
}