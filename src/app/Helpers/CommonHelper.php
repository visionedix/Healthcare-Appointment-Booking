<?php

namespace App\Helpers;

use Exception;
use Carbon\Carbon;
use App\Models\Setting;
use App\Model\Common\Configuration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommonHelper
{
    public static function notFoundMessage($message, $code)
    {
        $response = [
            'code' => $code,
            'message' => $message,
        ];
        return response()->json($response, $response['code']);
    }

    public static function appUrlPath($path)
    {
        if ($path != null && $path != "") {
            return  env('APP_URL').'/'.$path;
        }
        return "";
    }

    /**
     *
     * @param type $code
     * @param type $message
     * @param type $count
     * @param type $payload
     * @return type
     */
    public static function successfulMessage($code, $message, $count, $payload)
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'count' => $count,
            'data' => $payload,
        ];

        return response()->json($response, $response['code']);
    }

    public static function generatePagination($responseArr = array(), $limit, $page, $searchCondition, $sortOrder, $searchColumn = array())
    {
        try {
            $returnArr = $resultArr = array();
            if ($searchCondition['searchQuery'] != "" && !empty($searchColumn)) {
                $searchData = preg_quote(strtolower(trim($searchCondition['searchQuery'])), '~'); // don't forget to quote input string!
                foreach ($searchColumn as $columnName) {
                    $resultArr += preg_grep('~' . $searchData . '~', array_map('strtolower', (array_column($responseArr, $columnName))));
                }
                $responseArr = array_intersect_key($responseArr, array_flip(array_keys($resultArr)));
            }

            $returnArr['totalRecord'] = $total = count($responseArr);
            $totalPages = ceil($total / $limit);
            if (is_array($sortOrder)) {
                foreach ($sortOrder as $key => $val) {
                    if (isset($val['dir'])) {
                        $responseArr = static::array_sort($responseArr, $val['field'], ($val['dir'] == 'desc') ? SORT_DESC : SORT_ASC);
                    }
                }
            }
            $page = max($page, 1);
            $page = min($page, $totalPages);
            $offset = ($page - 1) * $limit;
            if ($offset < 0) {
                $offset = 0;
            }

            $returnArr['result'] = array_slice($responseArr, $offset, $limit);
            return $returnArr;
        } catch (\Exception $ex) {
            return static::notFoundMessage($ex->getMessage(), 404);
        }
    }

}
