<?php

namespace Netgsm\Service;

use Exception;
use Netgsm\Enums\ServiceName;
use Netgsm\Helper;


class SmsSender
{
    /**
     * Netgsm API'ye JSON POST isteği gönderme.
     *
     
     * @param object $data Gönderilecek veri
     * @return mixed API'den dönen cevap
     */
    public static function post(object $data)
    {
        $url = "https://api.netgsm.com.tr/sms/send/rest/v1";
        $requiredParams = ['NETGSM_MSGHEADER'];
        $optionalParams = ['NETGSM_APPNAME', 'NETGSM_IYSFILTER', 'NETGSM_PARTNERCODE', 'NETGSM_ENCODING'];

        foreach ($requiredParams as $param) {
            if (!env($param)) {
                throw new Exception("Check the $param parameter");
            }
            
            $data->{strtolower(str_replace("NETGSM_", "", $param))} = env($param);
        }

        foreach ($optionalParams as $param) {
            if (env($param)) {
                $data->{strtolower(str_replace("NETGSM_", "", $param))} = env($param);
            }
        }

        $data->encoding = $data->encoding ?? 'tr';
        $response = Helper::curl($data, $url, ServiceName::SmsSend->value);

        return $response;
    }
}
