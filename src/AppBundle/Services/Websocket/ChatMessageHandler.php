<?php
namespace AppBundle\Services\Websocket;

use Domain\WebsocketEvents\Chat\ChatMessage;
use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Handlers\Base\AbstractEventHandler;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use Gamma\Pushpin\PushpinBundle\Services\PushpinHelper;

class ChatMessageHandler extends AbstractEventHandler
{
    const EVENT_TYPE = TextEventInterface::EVENT_TYPE;

    /**
     * @var PushpinHelper
     */
    private $pushpinHelper;

    /**
     * @param PushpinHelper $pushpinHelper
     */
    public function setPushpinHelper(PushpinHelper $pushpinHelper)
    {
        $this->pushpinHelper = $pushpinHelper;
    }
    
    /**
     * @inheritdoc
     */
    public function handle(AbstractEvent $event)
    {
        /** @var ChatMessage $event */
        $this->pushpinHelper->sendWsMessageToChannel($event, json_encode([
                'room' => $event->room,
                'comment' => $event->comment,
            ], JSON_UNESCAPED_UNICODE)
        );
    }
}