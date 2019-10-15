<?php

require_once(__DIR__.'/vendor/autoload.php');

$sc = new \Mh\Skyscanner\Client([
    'key' => 'YOUR-KEY',
]);

$country = 'DK';
$city = 'Malaga';
$currency = 'DKK';

$locationOut = 'AAL-sky';
$locationIn = 'AGP-sky';
$dateOut = '2019-12-01';
$dateIn = '2019-12-07';

/*
$dateOut = 'anytime';
$dateIn = 'anytime';
 */

//$res = $sc->getMarkets();

//$res = $sc->getCurrencies();

//$res = $sc->getPlaces($country, $currency, $city);

//$res = $sc->getQuotes($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn);

//$res = $sc->getRoutes($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn);

//$res = $sc->getDates($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn);

//$res = $sc->getQuotesInbound($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn);

//$res = $sc->getDatesInbound($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn);

//$res = $sc->getRoutesInbound($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn);

$cabin = [
    'economy',
    'premiumeconomy',
    'business',
    'first',
];

$params = [
    //'cabinClass' => 'business',
    'adults' => 1,
    'children' => 0,
    'infants' => 0,
    'groupPricing' => true,
];

/*
$res = $sc->makeSession($country, $currency, $locationOut, $locationIn, $dateOut, $dateIn, $params);
dump($res);
die();
 */

$session = 'dc151014-4445-43b7-80f7-0e5d1567eb3e';

$query = [
    'session' => $session,
    'sortType' => 'price',
    'sortOrder' => 'asc',
    'duration' => '300',
    //'includeCarriers' => 'sas',
    //'excludeCarriers' => 'norwegian',
    //'originAirports' => 'AAL-sky',
    //'destinationAirports' => 'AGP-sky',
    'stops' => '0',
    'outboundDepartTime' => 'M',
    //'outboundDepartStartTime' => '06:00',
    //'outboundDepartEndTime' => '21:00',
    //'outboundArriveStartTime' => '06:00',
    //'outboundArriveEndTime' => '21:00',
    //'inboundDepartTime' => 'A,E',
    //'inboundDepartStartTime' => '06:00',
    //'inboundDepartEndTime' => '21:00',
    //'inboundArriveStartTime' => '06:00',
    //'inboundArriveEndTime' => '21:00',
    'pageIndex' => '0',
    'pageSize' => '10'
];

$res = $sc->getSession($query);

dump($res->json->Status, $res->json->Query);

foreach ($res->json->Itineraries as $value) {
    dump($value);
    break;
}

foreach ($res->json->Legs as $value) {
    dump($value);break;
}

foreach ($res->json->Segments as $value) {
    dump($value);break;
}

foreach ($res->json->Carriers as $value) {
    dump($value);break;
}

foreach ($res->json->Agents as $value) {
    dump($value);break;
}

foreach ($res->json->Places as $value) {
    dump($value);break;
}

foreach ($res->json->Currencies as $value) {
    dump($value);break;
}
