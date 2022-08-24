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
 * Twin.class.php
 * 
 * Twin card object
 */

class Twin extends DontGoInThereCursedCard
{
    public function __construct($game, $row)
    {
        parent::__construct($game);
        $this->id = $row[ID];
        $this->name = clienttranslate('Twin');
        $this->type = TWIN;
        $this->cssClass = "dgit-card-twin-".$row[TYPE_ARG];
        $this->tooltipText = self::buildTooltipText();
        $this->curses = $row[TYPE_ARG];
        $this->diceIcons = self::determineDiceIcons($row[TYPE_ARG]);
        $this->endGameTrigger = false;
        $this->uiPosition = $row[LOCATION_ARG];
    }

    /**
     * Build tooltip text for Twin
     * @return string Tooltip text
     */
    private function buildTooltipText()
    {
        return clienttranslate('When you collect 2 Twin cards with the same Curse value, immediately dispel those 2 Twin cards.');
    }
}