<?php

namespace Domain\WebsocketEvents\Chat;

use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractJsonEvent;
use Gamma\Pushpin\PushpinBundle\Interfaces\WebSocketChannelInterface;
use JMS\Serializer\Annotation\Type as JMS;

class ChatRoomLeave extends AbstractJsonEvent implements WebSocketChannelInterface
{
    /**
     * @var string
     * @JMS("string")
     */
    public $room;

    /**
     * @return string
     */
    public function getChannelName()
    {
        return $this->room;
    }
}
