<?php

require_once('DontGoInThereRoom.class.php');
require_once('rooms/Attic.class.php');
require_once('rooms/Basement.class.php');
require_once('rooms/Hallway.class.php');
require_once('rooms/Library.class.php');
require_once('rooms/Nursery.class.php');
require_once('rooms/SecretPassage.class.php');

/**
 * Functions to manage rooms
 */
class DontGoInThereRoomManager extends APP_GameClass
{
    public $game;

    public function __construct($game)
    {
        $this->game = $game;

        $this->rooms = $this->game->getNew("module.common.deck");
        $this->rooms->init("room");
    }

    /**
     * Setup rooms for a new game
     * @return void
     */
    public function setupNewGame()
    {
        // Get list of room types
        $roomTypes = range(ATTIC, SECRET_PASSAGE);

        // Create 1 of each room
        $rooms = [];
        foreach($roomTypes as $roomType)
        {
            $rooms[] = [TYPE => $roomType, TYPE_ARG => 0, 'nbr' => 1];
        }
        $this->rooms->createCards($rooms, DECK);

        // Shuffle room deck
        $this->rooms->shuffle(DECK);

        // Deal 3 opening rooms
        for($uiPosition = 1; $uiPosition <= 3; $uiPosition++)
        {
            self::dealOpeningRoom($uiPosition);
        }
    }

    // Map of room type to object class
    private static $roomClasses = [
        ATTIC => 'Attic',
        BASEMENT => 'Basement',
        HALLWAY => 'Hallway',
        LIBRARY => 'Library',
        NURSERY => 'Nursery',
        SECRET_PASSAGE => 'SecretPassage',
    ];

    // Map of rooms and their flip sides
    private static $roomFlipSides = [
        ATTIC => NURSERY,
        BASEMENT => HALLWAY,
        HALLWAY => BASEMENT,
        LIBRARY => SECRET_PASSAGE,
        NURSERY => ATTIC,
        SECRET_PASSAGE => LIBRARY,
    ];

    /**
     * Factory to create a DontGoInThereRoom object
     * @param int $roomType Room type
     * @param int $id Database id of room
     * @param int $locationArg Database location_arg Used to denote ui position of room within its location
     * @throws BgaVisibleException 
     * @return DontGoInThereRoom A DontGoInThereRoom object
     */
    public function getRoom($roomType, $id, $locationArg)
    {
        if(!isset(self::$roomClasses[$roomType]))
        {
            throw new BgaVisibleException("getRoom: Unknown room type $roomType");
        }
        $className = self::$roomClasses[$roomType];
        return new $className($this->game, $id, $locationArg);
    }

    /**
     * Get all DontGoInThereRoom objects in specified location
     * @param string $location Location value in database
     * @return array<DontGoInThereRoom> An array of DontGoInThereRoom objects
     */
    public function getRooms($location)
    {
        $rooms = $this->rooms->getCardsInLocation($location);
        return array_map(function($room) {
            return $this->getRoom($room[TYPE], $room[ID], $room[LOCATION_ARG]);
        }, $rooms);
    }

    /**
     * Get a gaceup room by its ui position
     * @param int $uiPosition
     * @return DontGoInThereRoom room object
     */
    public function getFaceupRoomByUiPosition($uiPosition)
    {
        return self::findRoomByUiPosition(self::getRooms(FACEUP), $uiPosition);
    }

    /**
     * Get uiData of all rooms in specified location
     * @param string $location Location value from database
     * @return array An array of uiData for a room
     */
    public function getUiData($location)
    {
        $ui = [];
        foreach($this->getRooms($location) as $room)
        {
            $ui[] = $room->getUiData();
        }
        return $ui;
    }

    /**
     * Get the UI position of the Library if it is faceu[]
     * @return mixed UI position of Library if its faceup otherwise return false
     */
    public function getLibraryPosition()
    {
        $faceupRooms = self::getRooms(FACEUP);
        $library = self::findRoomByType($faceupRooms, LIBRARY);
        if(!$library){
            return 0;
        }
        return $library->getUiPosition();
    }
    
    /**
     * Deal a starting room, put is flipside in waiting.
     * @param int $roomPosition The UI position of a room within its location
     * @return void
     */
    private function dealOpeningRoom($roomPosition)
    {
        // Get room deck
        $rooms = self::getRooms('deck');

        // Pull first room
        $drawnRoom = array_shift($rooms);

        // Place card faceup in position
        $this->rooms->moveCard($drawnRoom->getId(), FACEUP, $roomPosition);

        // Get flip side room, and put in waiting
        $flipSideRoom = self::findRoomByType($rooms, $drawnRoom->getFlipSideRoom());
        $this->rooms->moveCard($flipSideRoom->getId(), FACEDOWN, $roomPosition);
    }

    /**
     * Return a DontGoInThereRoom of specified type from a list of rooms
     * @param array<DontGoInThereRoom> $rooms An array of DontGoInThereRoom objects
     * @param int $roomType A room type value
     * @return mixed a DontGoInThereRoom object if it exists in the list, otherwise false
     */
    public function findRoomByType($rooms, $roomType)
    {
        foreach($rooms as $room)
        {
            if($roomType == $room->getType()) {
                return $room;
            }
        }

        return false;
    }

    /**
     * Return a DontGoInThereRoom of specified ui location from a list of rooms
     * @param array<DontGoInThereRoom> $rooms An array of DontGoInThereRoom objects
     * @param int $uiPosition A room ui position
     * @return mixed a DontGoInThereRoom object if it exists in the list, otherwise false
     */
    public function findRoomByUiPosition($rooms, $uiPosition)
    {
        foreach($rooms as $room)
        {
            if($uiPosition == $room->getUiPosition()) {
                return $room;
            }
        }
        return false;
    }
}