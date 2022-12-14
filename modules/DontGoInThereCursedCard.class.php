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
 * DontGoInThereCursedCard.class.php
 * 
 * Abstract card object
 */

abstract class DontGoInThereCursedCard extends APP_GameClass
{
    protected $game;

    public function __construct($game)
    {
        $this->game = $game;
    }

    protected $id = 0;
    protected $name = '';
    protected $type = 0;
    protected $cssClass = '';
    protected $tooltipText = '';
    protected $curses = 0;
    protected $diceIcons = 0;
    protected $endGameTrigger = false;
    protected $uiPosition = 0;
    protected $abilityText = '';
    protected $statName = '';

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getType() { return $this->type; }
    public function getCssClass() { return $this->cssClass; }
    public function getTooltipText() { return $this->tooltipText; }
    public function getCurses() { return $this->curses; }
    public function getDiceIcons() { return $this->diceIcons; }
    public function isEndGameTrigger() { return $this->endGameTrigger; }
    public function getUiPosition() { return $this->uiPosition; }
    public function getAbilityText() { return $this->abilityText; }
    public function getStatName() { return $this->statName; }

    /**
     * Get ui data of CursedCard visible by current player
     * @return array<mixed> An array of uiData for a CursedCard object
     */
    public function getUiData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'cssClass' => $this->cssClass,
            'tooltipText' => $this->tooltipText,
            'curses' => $this->curses,
            'diceIcons' => $this->diceIcons,
            'endGameTrigger' => $this->endGameTrigger,
            'uiPosition' => $this->uiPosition,
        ];
    }

    /**
     * Abstract for trigger effect function
     * @param mixed $args
     * @return void
     */
    public function triggerEffect($args) 
    {
        return;
    }

    // Map of curse value to number of dice icons on a card
    protected static $cursesToDiceIcons = [
        1 => 2,
        2 => 2,
        3 => 1,
        4 => 1,
    ];

    /**
     * Get the appropriate count of dice icons based on curse value of card
     * @param int $curses Curse value of a card
     * @throws BgaVisibleSystemException 
     * @return int THe number of dice icons on a card
     */
    protected function determineDiceIcons($curses)
    {
        if(!isset(self::$cursesToDiceIcons[$curses]))
        {
            throw new BgaVisibleSystemException("getDiceIcons: Invalid curses amount $curses");
        }
        return self::$cursesToDiceIcons[$curses];
    }
}