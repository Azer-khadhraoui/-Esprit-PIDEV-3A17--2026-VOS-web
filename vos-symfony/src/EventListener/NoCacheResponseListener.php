<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class NoCacheResponseListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $path = $request->getPathInfo();

        $session = $request->getSession();
        if (!$session) {
            return;
        }

        $isAuthenticated = (int) $session->get('admin_user_id', 0) > 0
            || (int) $session->get('user_id', 0) > 0;

        $isPrivatePath = str_starts_with($path, '/admin') || str_starts_with($path, '/client');

        if (!$isAuthenticated && !$isPrivatePath) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
    }
}