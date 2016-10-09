<?php
namespace AppBundle\Controller;

use Gamma\Pushpin\PushpinBundle\Controller\GripController;
use Gamma\Pushpin\PushpinBundle\DTO\WebSocketEventsDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ChatController extends GripController
{

    /**
     * @Route("/websocket/chat", name="app_websocket_chat_message")
     * @param Request $request
     * @param WebSocketEventsDTO $inputEvents
     *
     * @ParamConverter("inputEvents", converter="gamma.web_socket.events", options={"format": "json"})
     * @return Response
     */
    public function chatMessageAction(Request $request, WebSocketEventsDTO $inputEvents)
    {
        return $this->encodeWebSocketEvents(
            $this->get('gamma.pushpin.grip.events_handler')->handleEvents($inputEvents)
        );
    }
}
