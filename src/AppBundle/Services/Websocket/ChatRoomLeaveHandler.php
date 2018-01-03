<?php

namespace AppBundle\Services\Websocket;

use Domain\WebsocketEvents\Chat\ChatRoomLeave;
use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Handlers\Base\AbstractEventHandler;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use Gamma\Pushpin\PushpinBundle\Services\PushpinHelper;

class ChatRoomLeaveHandler extends AbstractEventHandler
{
    const EVENT_TYPE = TextEventInterface::EVENT_TYPE;

    /**
     * @var PushpinHelper
     */
    private $pushpinHelper;

    /**
     * @param PushpinHelper $pushpinHelper
     */
    public function setPushpinHelper($pushpinHelper)
    {
        $this->pushpinHelper = $pushpinHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(AbstractEvent $event)
    {
        /* @var ChatRoomLeave $event */
        return $this->pushpinHelper->unSubscribeFromChannel($event);
    }
}
