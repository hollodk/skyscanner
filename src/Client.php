<?php

namespace Mh\Skyscanner;

/**
 * Skyscanner
 */
class Client
{
    private $secret;

    public function __construct($options)
    {
        $this->secret = $options['key'];
    }

    public function getMarkets($locale='en-GB')
    {
        $url = "reference/v1.0/countries/".$locale;
        $res = $this->request($url);

        return $res->json;
    }

    public function getCurrencies()
    {
        $url = 'reference/v1.0/currencies';
        $res = $this->request($url);

        return $res->json;
    }

    public function getPlaces($country, $currency, $query, $locale='en-GB')
    {
        $query = [
            'query' => $query,
        ];

        $url = sprintf("autosuggest/v1.0/%s/%s/%s/",
            $country,
            $currency,
            $locale
        );

        $res = $this->request($url, 'get', null, $query);

        return $res->json;
    }

    public function getQuotes($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn=null, $locale='en-GB')
    {
        $query = [
            'inboundpartialdate' => $dateIn,
        ];

        $url = sprintf("browsequotes/v1.0/%s/%s/%s/%s/%s/%s",
            $country,
            $currency,
            $locale,
            $locationOut,
            $locationIn,
            $dateOut
        );

        $res = $this->request($url, 'get', [], $query);

        return $res->json;
    }

    public function getRoutes($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn, $locale='en-GB')
    {
        $query = [
            'inboundpartialdate' => $dateIn,
        ];

        $url = sprintf("browseroutes/v1.0/%s/%s/%s/%s/%s/%s",
            $country,
            $currency,
            $locale,
            $locationOut,
            $locationIn,
            $dateOut
        );

        $res = $this->request($url, 'get', [], $query);

        return $res->json;
    }

    public function getDates($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn, $locale='en-GB')
    {
        $query = [
            'inboundpartialdate' => $dateIn,
        ];

        $url = sprintf("browsedates/v1.0/%s/%s/%s/%s/%s/%s",
            $country,
            $currency,
            $locale,
            $locationOut,
            $locationIn,
            $dateOut
        );

        $res = $this->request($url, 'get', $query);

        return $res->json;
    }

    public function getQuotesInbound($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn=null, $locale='en-GB')
    {
        $url = sprintf("browsequotes/v1.0/%s/%s/%s/%s/%s/%s/%s",
            $country,
            $currency,
            $locale,
            $locationOut,
            $locationIn,
            $dateOut,
            $dateIn
        );

        $res = $this->request($url);

        return $res->json;
    }

    public function getRoutesInbound($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn, $locale='en-GB')
    {
        $url = sprintf("browseroutes/v1.0/%s/%s/%s/%s/%s/%s/%s",
            $country,
            $currency,
            $locale,
            $locationOut,
            $locationIn,
            $dateOut,
            $dateIn
        );

        $res = $this->request($url);

        return $res->json;
    }

    public function getDatesInbound($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn, $locale='en-GB')
    {
        $url = sprintf("browsedates/v1.0/%s/%s/%s/%s/%s/%s/%s",
            $country,
            $currency,
            $locale,
            $locationOut,
            $locationIn,
            $dateOut,
            $dateIn
        );

        $res = $this->request($url);

        return $res->json;
    }

    public function getBooking($session)
    {
        throw new \Exception('not implemented yet');

        $url = sprintf('pricing/v1.0/%s/booking',
            $session
        );

        $body = 'OutboundLegId=9187-1912011210--32132-1-9320-1912011930&InboundLegId=9320-1912071800--32013-2-9187-1912081330';
        $res = $this->request($url, 'put', null, null, $body);

        return $res->json;
    }

    public function getSession($query)
    {
        $url = 'pricing/uk2/v1.0/'.$query['session'];

        $res = $this->request($url, 'get', $query);

        return $res->json;
    }

    public function makeSession($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn=null, $params=[], $locale='en-GB')
    {
        $url = "pricing/v1.0";

        $params['country'] = $country;
        $params['currency'] = $currency;
        $params['locale'] = $locale;
        $params['originPlace'] = $locationOut;
        $params['destinationPlace'] = $locationIn;
        $params['outboundDate'] = $dateOut;
        $params['inboundDate'] = $dateIn;

        $res = $this->request($url, 'post', $params);

        $o = preg_split("/\//", $res->headers['Location'][0]);
        $id = array_pop($o);

        return $id;
    }

    private function request($endpoint, $method='get', $params=null, $query=null, $body=null)
    {
        $client = new \GuzzleHttp\Client();

        $prefix = "https://skyscanner-skyscanner-flight-search-v1.p.rapidapi.com/apiservices/";
        $url = $prefix.$endpoint;

        $r = $client->request($method, $url, [
            'headers' => [
                'X-RapidAPI-Host' => 'skyscanner-skyscanner-flight-search-v1.p.rapidapi.com',
                'X-RapidAPI-Key' => $this->secret,
            ],
            'body' => $body,
            'query' => $query,
            'form_params' => $params,
        ]);

        $res = new \StdClass();
        $res->json = json_decode($r->getBody()->getContents());
        $res->headers = $r->getHeaders();

        return $res;
    }
}
