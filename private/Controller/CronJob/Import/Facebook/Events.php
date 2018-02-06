<?php

namespace Controller\CronJob\Import\Facebook;

use Controller\CronJob\Facebook;
use Lib\Core\Util;
use Lib\Data\Agenda;

/**
 * Class Events
 * @package Controller\CronJob\Import\Facebook
 * @author Joost Mul <scoutingcms@jmul.net>
 */
final class Events extends Facebook
{
    /**
     *
     */
    protected function runCron()
    {
        try {
            $events = $this->getFbClient()->get('/' . $this->getPageId() . '/events');
            foreach ($events->getDecodedBody()['data'] as $event) {
                $this->processEvent($event);
            }
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param array $eventData
     */
    private function processEvent($eventData)
    {
        $title = Util::arrayGet($eventData, 'name', '');
        $description = Util::arrayGet($eventData, 'description', '');
        $startTime = strtotime(Util::arrayGet($eventData, 'start_time', ''));
        $endTime = strtotime(Util::arrayGet($eventData, 'end_time', ''));

        if ($startTime < time() || $endTime < time()) {
            return;
        }

        $event = new Agenda(
            null,
            $title,
            date('Y-m-d H:i:s', $startTime),
            date('Y-m-d H:i:s', $endTime),
            $description,
            Util::slugify($title),
            0
        );

        $event->save();
    }
}
