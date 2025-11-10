<?php
// URL WSDL веб-сервиса
$wsdl = "http://217.76.41.210:9090/hotel/ws/ReservationInterfaces/1CHotelReservationInterfaces.1cws?wsdl";//"http://www.1chotel.ru/interfaces/reservation/GetHotelsList.xml"

try {
    // Создаем SOAP клиент
    $client = new SoapClient($wsdl, [
        'trace' => 1,
        'exceptions' => 1,
        'connection_timeout' => 20, // увеличить таймаут
        'stream_context' => stream_context_create([
            'http' => [
                'timeout' => 25,
                'header' => "Content-Type: application/soap+xml; charset=utf-8\r\nUser-Agent: PHP-SOAP-CURL"
            ]
        ]),
        'login' => 'Администратор 1C',      // если требуется авторизация Booking
        'password' => '',
        'soap_version' => SOAP_1_2
    ]);

    // Параметры запроса (если необходимо, можно передать)
    $params = [
        'ExternalSystemCode' => 'API001',
        'LanguageCode' => 'RU' // или 'EN', если нужен английский
    ];
    // Вызов метода GetHotelsList без параметров (или с нужными параметрами)
    $response   = '';
    $response = $client->GetHotelsList($params,$response);//$response = 
    // $response = $client->__soapCall("GetHotelsList", [$params]);//GetHotelsList

    // Вывод результата
    echo "Ответ сервера:" . PHP_EOL;
    print_r($response);

} catch (SoapFault $fault) {
    // Обработка ошибок SOAP
    echo "Ошибка SOAP: " . $fault->getMessage();
    echo "\nLastRequest:\n" . $client->__getLastRequest(); // покажет содержимое запроса
    echo "\nLastResponse:\n" . $client->__getLastResponse(); // покажет ответ сервера (если есть)
}
?>