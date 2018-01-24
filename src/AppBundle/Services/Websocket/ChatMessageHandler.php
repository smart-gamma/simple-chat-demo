<?php

namespace AppBundle\Services\Websocket;

use Domain\WebsocketEvents\Chat\ChatMessage;
use Gamma\Pushpin\PushpinBundle\Events\Base\AbstractEvent;
use Gamma\Pushpin\PushpinBundle\Handlers\Base\AbstractEventHandler;
use Gamma\Pushpin\PushpinBundle\Interfaces\Events\TextEventInterface;
use Gamma\Pushpin\PushpinBundle\Services\MessagePublisher;

class ChatMessageHandler extends AbstractEventHandler
{
    const EVENT_TYPE = TextEventInterface::EVENT_TYPE;

    /**
     * @var MessagePublisher
     */
    private $messagePublisher;

    /**
     * ChatMessageHandler constructor.
     *
     * @param MessagePublisher $messagePublisher
     */
    public function __construct(MessagePublisher $messagePublisher)
    {
        $this->messagePublisher = $messagePublisher;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(AbstractEvent $event)
    {
        /* @var ChatMessage $event */
        $this->messagePublisher->publishWebSocketMessage(
            $event,
            json_encode([
                'room' => $event->room,
                'comment' => htmlspecialchars($event->comment),
            ], JSON_UNESCAPED_UNICODE)
        );
    }
}
