<?php 

namespace Core; 

class NotificationManager {
    public const TYPE_SUCCESS = 1;
    public const TYPE_FAILURE = 0;

    protected static $temporaryNotifications = [];

    public static function GetTemporaryNotifications() {
        return self::$temporaryNotifications;
    }

    /**
     * @var $type - Messagetype
     * @var $message - Notificationmessage
     */
    public static function ShowTemporaryNotification($type, $message) {
        self::$temporaryNotifications[] = array(
            'message' => $message,
            'type' => $type
        );
    }
}