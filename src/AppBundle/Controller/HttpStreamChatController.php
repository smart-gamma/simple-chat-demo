<?php

namespace AppBundle\Controller;

use Gamma\Pushpin\PushpinBundle\Configuration\PushpinResponse;
use Gamma\Pushpin\PushpinBundle\Dto\HttpStreamDto;
use Gamma\Pushpin\PushpinBundle\Messages\GammaHttpStreamMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HttpStreamChatController extends Controller
{
    /**
     * @Route("/stream/chat/{channel}", name="app_stream_chat_connect")
     * @Method("GET")
     *
     * @param Request $request
     * @param string  $channel
     *
     * @PushpinResponse(format="http-stream")
     *
     * @return HttpStreamDto
     */
    public function connectAction(Request $request, string $channel)
    {
        $dto = new HttpStreamDto();
        $dto->connectionId = $request->headers->get('connection-id');
        $dto->channelName = $channel;

        return $dto;
    }

    /**
     * @Route("/stream/chat/{channel}", name="app_stream_chat_message")
     * @Method("POST")
     *
     * @param Request $request
     * @param string  $channel
     *
     * @return Response
     */
    public function messageAction(Request $request, string $channel)
    {
        $message = GammaHttpStreamMessage::build('');

        $form = $this->createFormBuilder($message)
            ->add('content', TextType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publisher = $this->get('gamma.pushpin.message_publisher');

            $publisher->publish($channel, $form->getData());

            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['success' => false, 'errors' => $form->getErrors(true)]);
    }
}
