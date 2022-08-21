<?php

/**
 * A Music Box Cursed Card object
 */
class MusicBox extends DontGoInThereCursedCard
{
    public function __construct($game, $id, $typeArg, $locationArg)
    {
        parent::__construct($game);
        $this->id = $id;
        $this->name = clienttranslate('Music Box');
        $this->type = MUSIC_BOX;
        $this->cssClass = "dgit-card-music-box-".$typeArg;
        $this->tooltipText = self::buildTooltipText();
        $this->curses = $typeArg;
        $this->diceIcons = self::determineDiceIcons($typeArg);
        $this->endGameTrigger = true;
        $this->uiPosition = $locationArg;
    }

    /**
     * Build tooltip text for Music Box
     * @return string Tooltip text
     */
    private function buildTooltipText()
    {
        return clienttranslate('At game end, if you have the most Curses on Music Box cards, dispel 2 Music Box cards of your choice. If tied, all tied players dispel 2 Music Box cards.');
    }
}