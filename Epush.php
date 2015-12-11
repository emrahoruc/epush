<?php

/**
*    Emrah Oruç
*    Dec.2015
*
*     
*    apiKey: server api key
*    devices: destination Android devices. array or string.
*    message: notification body
*    title: notification title
*    subtitle: notification subtitle.
*    tickerText: notification ticker text.
*    vibrate: vibrate. Default TRUE
*    sound: sound. Default TRUE
*    largeIcon: large icon
*    smallIcon: small icon
*    debugMode: debug mode. Default FALSE
*/


class Epush
{
    
    const API_URL = 'https://android.googleapis.com/gcm/send';

    private $_apiKey;
    private $_devices;

    // 'here is a message'
    private $_message;

    // 'This is a title'
    private $_title;

    // 'This is a subtitle'
    private $_subTitle;

    // Ticker text here    
    private $_tickerText;

    private $_vibrate = TRUE;
    private $_sound = TRUE;

    private $_largeIcon;
    private $_smallIcon;

    private $_debug = FALSE;
    private $inputs;


    public function __construct () {
    }

    public function apiKey ($apiKey) {
        $this->_apiKey = (string)$apiKey;
    }
    public function getApiKey () {
        return $this->_apiKey;
    }

    public function devices ($devices) {
        $this->_devices = is_array($devices) ? $devices : [$devices];
    }
    public function getDevices () {
        return $this->_devices;
    }

    public function message ($message) {
        $this->_message = (string)$message;
    }
    public function getMessage () {
        return $this->_message;
    }

    public function title ($title) {
        $this->_title = (string)$title;
    }
    public function getTitle () {
        return $this->_title;
    }

    public function subtitle ($subTitle) {
        $this->_subTitle = (string)$subTitle;
    }
    public function getSubtitle () {
        return $this->_subTitle;
    }

    public function tickerText ($tickerText) {
        $this->_tickerText = (string)$tickerText;
    }
    public function getTickerText () {
        return $this->_tickerText;
    }

    public function vibrate ($vibrate) {
        $this->_vibrate = (int)$vibrate;
    }
    public function getVibrate () {
        return $this->_vibrate;
    }

    public function sound ($sound) {
        $this->_sound = (int)$sound;
    }
    public function getSound () {
        return $this->_sound;
    }

    public function largeIcon ($largeIcon) {
        $this->_largeIcon = (string)$largeIcon;
    }
    public function getLargeIcon () {
        return $this->_largeIcon;
    }

    public function smallIcon ($smallIcon) {
        $this->_smallIcon = (string)$smallIcon;
    }
    public function getSmallIcon () {
        return $this->_smallIcon;
    }

    public function debugMode ($debug) {
        $this->_debug = (boolean)$debug;
    }
    public function getDebugMode () {
        return $this->_debug;
    }

    public function send() {

        if (Empty($this->_apiKey)) {
            exit('Missing Server Api Key.');

        } else if (Empty($this->_devices)) {
            exit('Missing Device(s).');

        } else if (Empty($this->_message)) {
            exit('Missing Message Content.');
        }


        $headers = [
            'Authorization: key=' . $this->getApiKey(),
            'Content-Type: application/json'
        ];

        $data =[
            'registration_ids' => $this->getDevices(),
            'data'  => [
                'title'      => $this->getTitle(),
                'subtitle'   => $this->getSubTitle(),
                'message'    => $this->getMessage(),
                'tickerText' => $this->getTickerText(),
                'vibrate'    => $this->getVibrate(),
                'sound'      => $this->getSound(),
                'largeIcon'  => $this->getLargeIcon(),
                'smallIcon'  => $this->getSmallIcon()
            ]
        ];

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, self::API_URL );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS,  json_encode($data) );
        $result = json_decode( curl_exec( $ch ) );
        curl_close( $ch );

        if ($this->getDebugMode()) {

            return [
                'output' => $result,
                'input'  => $data
            ];

        } else {
            return ($result->success === 1) ? true : false;
        }
    }
}

?>
