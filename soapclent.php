<?php
// URL WSDL веб-сервиса
$wsdl = "http://www.1chotel.ru/interfaces/reservation/GetHotelsList.xml";

try {
    // Создаем SOAP клиент
    $client = new SoapClient($wsdl, [
        'trace' => 1,
        'exceptions' => 1,
        //'login' => 'your_username',      // если требуется авторизация
        //'password' => 'your_password'
    ]);

    // Параметры запроса (если необходимо, можно передать)
    $params = [];

    // Вызов метода GetHotelsList без параметров (или с нужными параметрами)
    $response = $client->__soapCall("GetHotelsList", [$params]);

    // Вывод результата
    echo "Ответ сервера:" . PHP_EOL;
    print_r($response);

} catch (SoapFault $fault) {
    // Обработка ошибок SOAP
    echo "Ошибка SOAP: " . $fault->getMessage();
}
?>