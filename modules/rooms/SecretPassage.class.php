<?php

/**
 * SecretPassage: A Secret Passage Room object
 */
class SecretPassage extends DontGoInThereRoom
{
    public function __construct($game, $id)
    {
        parent::__construct($game);
        $this->id = $id;
        $this->name = clienttranslate('Secret Passage');
        $this->type = SECRET_PASSAGE;
        $this->cssClass = "dgit-room-secret-passage";
        $this->tooltipText = self::buildTooltipText();;
        $this->flipSideRoom = LIBRARY;
    }

    /**
     * buildTooltipText: Build tooltip text for Secret Passage
     */
    private function buildTooltipText()
    {
        return clienttranslate('Place the 3rd Cursed Card in the Secret Passage face-down. If you place a Meeple here, secret;y look at the face-down card. When a 3rd Meeple is placed here, reveal the card.');
    }
}