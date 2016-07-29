<?php
/**
 * Created by PhpStorm.
 * User: gcorn
 * Date: 7/29/16
 * Time: 12:47 AM
 */

namespace AppBundle\EventListener;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AngularPostListener
{
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();

        if(empty($request->getContent()) || $request->getContentType() != "json") {
            return;
        }

        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
    }
}