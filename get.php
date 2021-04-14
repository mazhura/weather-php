<?php


    class GetWeatherData
    {

        public const URL = 'api.openweathermap.org/data/2.5/weather';
        public const API = '6032494c874cf597456fad627cbc0bb0';

        private $params = null;
        private $url = null;

        public function __construct($city_id, $lang)
        {
            $this->params = http_build_query(array(
                'id' => $city_id,
                'appid' => self::API,
                'lang' => $lang,
                'units' => 'metric'
            ));
            $this->url = self::URL . '?' . $this->params;
        }

        public function getData()
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            return json_decode($data);
        }
    }