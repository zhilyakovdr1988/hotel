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
    public $ExternalSystemCode;
    public $LanguageCode;
    /**
     * Конструктор класса и инициализация SOAP клиента
     *
     * @param string $wsdl URL WSDL веб-сервиса
     * @param string $login Логин для авторизации
     * @param string $password Пароль для авторизации
     * @param string $location Эндпоинт для вызова методов(по умолчанию $wsdl)
     * @param int    $connectionTimeout Таймаут соединения
     * @param int    $soapVersion SOAP версия (по умолчанию SOAP_1_2)
     * @param string $ExternalSystemCode Внешний код отеля, задается в 1С
     */
    public function __construct(
        $wsdl,
        $login = null,
        $password = null,
        $location = null,
        $connectionTimeout = 20,
        $soapVersion = SOAP_1_2,
        $ExternalSystemCode = 'API001',
        $LanguageCode = 'RU'
    ) {
        $this->wsdl = $wsdl . '?wsdl';
        $this->login = $login;
        $this->password = $password;
        $this->location = $location !== null ? $location : $wsdl;
        $this->soapVersion = $soapVersion;
        $this->connectionTimeout = $connectionTimeout;
        $this->ExternalSystemCode = $ExternalSystemCode;
        $this->LanguageCode = $LanguageCode;

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

    public function CancelGroupReservation($params = [])
    {
        return $this->call('CancelGroupReservation', $params);
    }
    public function CheckInGroupReservation($params = [])
    {
        return $this->call('CheckInGroupReservation', $params);
    }
    public function CheckOutGroupReservation($params = [])
    {
        return $this->call('CheckOutGroupReservation', $params);
    }
    public function CreateOrder($params = [])
    {
        return $this->call('CreateOrder', $params);
    }
    public function GetActiveGroupsList($params = [])
    {
        return $this->call('GetActiveGroupsList', $params);
    }
    public function GetActiveReservations($params = [])
    {
        return $this->call('GetActiveReservations', $params);
    }
    public function GetAgentDetails($params = [])
    {
        return $this->call('GetAgentDetails', $params);
    }
    public function GetAgentGroupsList($params = [])
    {
        return $this->call('GetAgentGroupsList', $params);
    }
    public function GetAgentReport($params = [])
    {
        return $this->call('GetAgentReport', $params);
    }
    public function GetAllReservationsWithTransactions($params = [])
    {
        return $this->call('GetAllReservationsWithTransactions', $params);
    }
    public function GetAvailableRoomsWithDailyPrices($params = [])
    {
        return $this->call('GetAvailableRoomsWithDailyPrices', $params);
    }
    public function GetAvailableRoomTypesExt($params = [])
    {
        return $this->call('GetAvailableRoomTypesExt', $params);
    }
    public function GetAvailableRoomTypesWithPrices($params = [])
    {
        return $this->call('GetAvailableRoomTypesWithPrices', $params);
    }
    public function GetClientByPhoneAndEMail($params = [])
    {
        return $this->call('GetClientByPhoneAndEMail', $params);
    }
    public function GetClientByPromoCode($params = [])
    {
        return $this->call('GetClientByPromoCode', $params);
    }
    public function GetClientDiscountCards($params = [])
    {
        return $this->call('GetClientDiscountCards', $params);
    }
    public function GetClientGuestGroupsList($params = [])
    {
        return $this->call('GetClientGuestGroupsList', $params);
    }
    public function GetDiscountCardPercent($params = [])
    {
        return $this->call('GetDiscountCardPercent', $params);
    }
    public function GetExternalGroupReservationStatus($params = [])
    {
        return $this->call('GetExternalGroupReservationStatus', $params);
    }
    public function GetExternalReservationStatus($params = [])
    {
        return $this->call('GetExternalReservationStatus', $params);
    }
    public function GetExtraServices($params = [])
    {
        return $this->call('GetExtraServices', $params);
    }
    public function GetHotelParameters($params = [])
    {
        return $this->call('GetHotelParameters', $params);
    }
    public function GetIdentityDocumentsList($params = [])
    {
        return $this->call('GetIdentityDocumentsList', $params);
    }
    public function GetPDF($params = [])
    {
        return $this->call('GetPDF', $params);
    }
    public function GetRoomInventoryBalance($params = [])
    {
        return $this->call('GetRoomInventoryBalance', $params);
    }
    public function GetVacantCheckInPeriods($params = [])
    {
        return $this->call('GetVacantCheckInPeriods', $params);
    }
    public function RequestCode($params = [])
    {
        return $this->call('RequestCode', $params);
    }
    public function SendExpressCheckInMessage($params = [])
    {
        return $this->call('SendExpressCheckInMessage', $params);
    }
    public function SendInvoice($params = [])
    {
        return $this->call('SendInvoice', $params);
    }
    public function UpdateClientInfo($params = [])
    {
        return $this->call('UpdateClientInfo', $params);
    }
    public function VerifyClient($params = [])
    {
        return $this->call('VerifyClient', $params);
    }
    public function VerifyPayment($params = [])
    {
        return $this->call('VerifyPayment', $params);
    }
    public function WriteExternalClient($params = [])
    {
        return $this->call('WriteExternalClient', $params);
    }
    public function WriteExternalClientExt($params = [])
    {
        return $this->call('WriteExternalClientExt', $params);
    }
    public function WriteExternalReservation($params = [])
    {
        return $this->call('WriteExternalReservation', $params);
    }
    public function WriteGuestGroupPayment($params = [])
    {
        return $this->call('WriteGuestGroupPayment', $params);
    }
    public function WriteGuestGroupPaymentExt($params = [])
    {
        return $this->call('WriteGuestGroupPaymentExt', $params);
    }
    public function WriteGuestGroupPreauthorisation($params = [])
    {
        return $this->call('WriteGuestGroupPreauthorisation', $params);
    }
    public function WriteNewGroup($params = [])
    {
        return $this->call('WriteNewGroup', $params);
    }

    // Аннуляция бронирования
    public function cancelReservation($params = [])
    {
        return $this->call('CancelReservation', $params);
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
        'ExternalSystemCode' => $client->ExternalSystemCode,
        'LanguageCode' => $client->LanguageCode
    ];
    $responseHL = $client->getHotelsList($params);
    //print_r($responseHL);

    $params = [
        'Hotel' => $responseHL->return->HotelParameters->HotelCode,
        'ExternalSystemCode' => $client->ExternalSystemCode,
        'LanguageCode' => $client->LanguageCode,
        'RoomRate' => ''
    ];
    $responseHP = $client->GetHotelParameters($params);
    //print_r($responseHP);
    $params = [];
    $responseIDL = $client->GetIdentityDocumentsList($params);
    //print_r($responseIDL);

    $params = [
        'Phone' => '79219470228',
        'EMail' => ''
    ];
    $responseC = $client->GetClientByPhoneAndEMail($params);
    //print_r($responseC);

    //Получаем свободные номера с ценами
    $params = [
        'Hotel' => $responseHL->return->HotelParameters->HotelCode,
        'RoomType' => null,
        'RoomQuota' => null,
        'PeriodFrom' => '2025-11-30T00:00:00',
        'PeriodTo' => '2025-12-01T00:00:00',
        'ClientType' => null,
        'RoomRates' => [],
        'GuestsQuantity' => [
            'Adults' => ['Quantity' => 1],
            'Kids' => [
                'Quantity' => 0,
                // Если требуется вложенные данные по детям, добавить сюда
            ],
            'RequestAttributes' => [ //пока можно очистить, не влияет на вывод
                'SessionID' => 123,
                'UserID' => 321,
                'utm_source' => '',
                'utm_medium' => '',
                'utm_campaign' => '',
                'utm_content' => ''
            ]
        ],
        'ClientIsAuthorized' => false,
        'ExternalSystemCode' => $client->ExternalSystemCode,
        'LanguageCode' => $client->LanguageCode,
        'ExtraParameters' => []
    ];
    $responseARWDP = $client->GetAvailableRoomsWithDailyPrices($params);
    print_r($responseARWDP);
} catch (SoapFault $e) {
    echo "Ошибка SOAP: " . $e->getMessage() . PHP_EOL;
    echo "LastRequest:\n" . $client->getLastRequest() . PHP_EOL;
    echo "LastResponse:\n" . $client->getLastResponse() . PHP_EOL;
}
?>