<?php


namespace App\Helpers;


class ResultGenerate
{
    /**
     * @param array|object $object
     * @param bool $status
     * @param string $message
     * @return bool|string
     */
    public static function Success(string $message = 'Успешно!', $object = [], bool $status = true): string
    {
        return json_encode((object)[
            'status' => $status,
            'message' => $message,
            'result' => $object,
        ]);
    }

    public static function Error(string $message = 'Ошибка!', $object = [], bool $status = false): string
    {
        return json_encode((object)[
            'status' => $status,
            'message' => $message,
            'result' => $object,
        ]);
    }
}
