<?php

namespace AppBundle\Controller;

use Gamma\Pushpin\PushpinBundle\Configuration\PushpinResponse;
use Gamma\Pushpin\PushpinBundle\Dto\WebSocketEventsDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebSocketChatController extends Controller
{
    /**
     * @Route("/websocket/chat", name="app_websocket_chat_message")
     *
     * @param WebSocketEventsDto $inputEvents
     *
     * @PushpinResponse(format="ws-message")
     * @ParamConverter("inputEvents", converter="gamma.web_socket.events", options={"format": "json"})
     *
     * @return Response
     */
    public function chatMessageAction(WebSocketEventsDto $inputEvents)
    {
        return $this->get('gamma.pushpin.grip.events_handler')->handleEvents($inputEvents);
    }
}
