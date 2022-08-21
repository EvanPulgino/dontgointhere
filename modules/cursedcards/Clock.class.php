<?php

/**
 * A Clock Cursed Card object
 */
class Clock extends DontGoInThereCursedCard
{
    public function __construct($game, $id, $typeArg, $locationArg)
    {
        parent::__construct($game);
        $this->id = $id;
        $this->name = clienttranslate('Clock');
        $this->type = CLOCK;
        $this->cssClass = "dgit-card-clock-".$typeArg;
        $this->tooltipText = self::buildTooltipText();
        $this->curses = $typeArg;
        $this->diceIcons = self::determineDiceIcons($typeArg);
        $this->endGameTrigger = false;
        $this->uiPosition = $locationArg;
    }

    /**
     * Build tooltip text for Clock
     * @return string Tooltip text
     */
    private function buildTooltipText()
    {
        return clienttranslate('If you are the 1st player to collect a set of Clock cards whose Curse values add up to 8 or more, immediately dispel 2 Clock cards of your choice. After that, collecting a set of clocks has no effect.');
    }
}