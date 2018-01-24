<?php

namespace AppBundle\Controller;

use Gamma\Pushpin\PushpinBundle\Messages\GammaHttpStreamMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/ws", name="app_default_ws")
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function wsChatAction(Request $request)
    {
        return [
            'webSocketServer' => sprintf(
                'ws://%s:7999%s',
                $this->getParameter('domain'),
                $this->generateUrl('app_websocket_chat_message')
            ),
        ];
    }

    /**
     * @Route("/stream/{channel}", name="app_default_stream")
     * @Template()
     *
     * @param Request $request
     * @param string  $channel
     *
     * @return array
     */
    public function httpStreamAction(Request $request, string $channel)
    {
        $message = new GammaHttpStreamMessage('');
        $form = $this->createFormBuilder($message)
            ->setAction($this->generateUrl('app_stream_chat_message', ['channel' => $channel]))
            ->add('content', TextType::class, ['label' => false])
            ->getForm()
        ;

        return [
            'form' => $form->createView(),
            'postUrl' => $this->generateUrl('app_stream_chat_message', ['channel' => $channel]),
            'streamUri' => sprintf(
                'http://%s:7999%s',
                $this->getParameter('domain'),

                $this->generateUrl('app_stream_chat_connect', ['channel' => $channel])
            ),
        ];
    }
}
