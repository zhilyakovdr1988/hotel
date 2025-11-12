<?php
/**
 * Класс для работы с SOAP веб-сервисом 1CHotelReservationInterfaces
 */
class HotelReservationClient
{
    private $wsdl;
    private $client;
    private $login;
    private $password;
    private $soapVersion;
    private $location;
    private $connectionTimeout;
    private $lastRequest;
    private $lastResponse;

    /**
     * Конструктор класса и инициализация SOAP клиента
     *
     * @param string $wsdl URL WSDL веб-сервиса
     * @param string $login Логин для авторизации
     * @param string $password Пароль для авторизации
     * @param string $location Эндпоинт для вызова методов
     * @param int    $connectionTimeout Таймаут соединения
     * @param int    $soapVersion SOAP версия (по умолчанию SOAP_1_2)
     */
    public function __construct(
        $wsdl,
        $login = null,
        $password = null,
        $connectionTimeout = 20,
        $soapVersion = SOAP_1_2
    ) {
        $this->wsdl = $wsdl . '?wsdl';
        $this->login = $login;
        $this->password = $password;
        $this->location = $wsdl;
        $this->soapVersion = $soapVersion;
        $this->connectionTimeout = $connectionTimeout;

        $options = [
            'trace' => 1,
            'exceptions' => 1,
            'connection_timeout' => $this->connectionTimeout,
            'soap_version' => $this->soapVersion
        ];
        if ($this->login !== null && $this->password !== null) {
            $options['login'] = $this->login;
            $options['password'] = $this->password;
        }
        if ($this->location !== null) {
            $options['location'] = $this->location;
        }

        $this->client = new SoapClient($this->wsdl, $options);
    }

    /**
     * Вызов метода GetHotelsList
     *
     * @param array $params Параметры запроса ('ExternalSystemCode', 'LanguageCode')
     * @return mixed Ответ сервера
     * @throws SoapFault В случае ошибки SOAP
     */
    // Получение списка отелей
    public function getHotelsList($params = [])
    {
        return $this->call('GetHotelsList', $params);
    }

    // Получение типов номеров и цен
    public function getAvailableRoomTypes($params = [])
    {
        return $this->call('GetAvailableRoomTypes', $params);
    }

    // Оформление группового бронирования
    public function writeExternalGroupReservation($params = [])
    {
        return $this->call('WriteExternalGroupReservation', $params);
    }

    // Получение информации по группе бронирования
    public function getGroupReservationDetails($params = [])
    {
        return $this->call('GetGroupReservationDetails', $params);
    }

    // Аннуляция бронирования
    public function cancelReservation($params = [])
    {
        return $this->call('CancelReservation', $params);
    }

    // Универсальный вызов метода
    private function call($method, $params = [])
    {
        try {
            $response = $this->client->__soapCall($method, [$params]);
            $this->lastRequest = $this->client->__getLastRequest();
            $this->lastResponse = $this->client->__getLastResponse();
            return $response;
        } catch (SoapFault $fault) {
            $this->lastRequest = $this->client->__getLastRequest();
            $this->lastResponse = $this->client->__getLastResponse();
            throw $fault;
        }
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }
}
?>

<?php
$client = new HotelReservationClient(
    "http://217.76.41.210:9090/hotel/ws/ReservationInterfaces/1CHotelReservationInterfaces",
    "Booking",
    "Booking"
);

try {
    $params = [
        'ExternalSystemCode' => 'API001',
        'LanguageCode' => 'RU'
    ];
    $response = $client->getHotelsList($params);
    print_r($response);
} catch (SoapFault $e) {
    echo "Ошибка SOAP: " . $e->getMessage() . PHP_EOL;
    echo "LastRequest:\n" . $client->getLastRequest() . PHP_EOL;
    echo "LastResponse:\n" . $client->getLastResponse() . PHP_EOL;
}
?>