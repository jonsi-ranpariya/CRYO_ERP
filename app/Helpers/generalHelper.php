<?php

use App\Models\Master\InvoiceTypeMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isNull;

if (!function_exists('testDie')) {
    /**
     * @param $data
     * @param bool|int $isDie
     */
    function testDie($data, bool|int $isDie = true): void
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($isDie === true) {
            die();
        }
    }
}

if (!function_exists('createTree')) {
    /**
     * @param $data
     * @param $modal 'New Model Object'
     * @return array
     */
    function createTree($data, $modal): array
    {
        foreach ($data as $key => $value) {
            $response[$key]['d_id'] = $value->_id;
            $response[$key]['id'] = $key;
            $response[$key]['label'] = $value->groupName;
            $response[$key]['groupCode'] = $value->groupCode;
            $response[$key]['sequenceNo'] = $value->sequenceNo ?? null;
            $response[$key]['groupName'] = $value->groupName;
            $response[$key]['isLastLevel'] = $value->isLastLevel;
            if ($value->isLastLevel == 'No') {
                $fetchChildData = $modal::where('parentGroupId', $value->_id)->orderBy('groupName', 'ASC')->get();
                $response[$key]['children'] = createTree($fetchChildData, $modal);
            }
        }
        return $response ?? [];
    }
}

if (!function_exists('generateGroupCode')) {
    /**
     * @param $data
     * @param $modal
     * @return string
     */
    function generateGroupCode($data, $modal): string
    {
        $parentCode = $modal::where('_id', $data['parentGroupId'])->first();
        $parentCount = $modal::where('parentGroupId', $data['parentGroupId'])->count();

        if (empty($data['parentGroupId'])) {
            return substr(strtoupper($data['groupName']), 0, 1);
        }

        if ($parentCount == 0) {
            return strtoupper($parentCode->groupCode) . '001';
        } else {
            $counter = (string)($parentCount + 1);
            if ($parentCount + 1 >= 100) {
                return $parentCode->groupCode . $counter;
            } elseif ($counter >= 10) {
                return $parentCode->groupCode . '0' . $counter;
            } else {
                return $parentCode->groupCode . '00' . $counter;
            }
        }
    }
}

if (!function_exists('jsonData')) {
    /**
     * @param $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonData($data, int $status = \Illuminate\Http\Response::HTTP_OK)
    {
        return new \Illuminate\Http\JsonResponse($data, $status);
    }
}

if (!function_exists('deleteStorageItem')) {
    /**
     * @param $path
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function deleteStorageItem($path): void
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        } else {
            throw new \Illuminate\Contracts\Filesystem\FileNotFoundException('Item Not Found');
        }
    }
}

if (!function_exists('deleteStorageMultipleItem')) {
    /**
     * @param array $paths
     */
    function deleteStorageMultipleItem(array $paths): void
    {
        Storage::delete($paths);
    }
}

if (!function_exists('generateCodes')) {
    /**
     * @param $modal
     * @param string $initialCode
     * @param string $dbField
     * @param string $appendExtra
     * @param bool $assignLot
     * @return string
     */
    function generateCodes($modal, string $initialCode, string $dbField, string $appendExtra = '', bool $assignLot = false): string
    {
        $latest = $modal::query()->latest()->first();
        if (!$latest) {
            $newNumber = $initialCode;
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->$dbField);
            if ($assignLot === true) {
                $newNumber = $appendExtra . sprintf('%08d', $string + 1);
            } else {
                $newNumber = $appendExtra . sprintf('%05d', $string + 1);
            }
        }

        return $newNumber;
    }
}

if (!function_exists('generateShortCode')) {
    /**
     * @param $column
     * @param int $length
     * @return string
     */
    function generateShortCode($column, int $length = 5): string
    {
        $stringSize = '%0' . $length . 'd';
        $string = preg_replace("/[^0-9\.]/", '', $column);
        return sprintf($stringSize, $string + 1);
    }
}

if (!function_exists('get_amount_words')) {
    /**
     * @param $number
     * @return string
     */
    function get_amount_words($number): string
    {
        $number = (float)str_replace(',', '', $number);
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = [];
        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        ];
        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' ' : null;
                $str [] = ($number < 21)
                    ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred
                    : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "And " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? 'INR ' . $Rupees : '') . $paise . ' Only';
    }
}

if (!function_exists('getFinancialYear')) {
    /**
     * @param string $format
     * @param string $separator
     * @return string
     */
    function getFinancialYear(string $format = "y", string $separator = ''): string
    {
        $date = date_create(now()->format('Y-m-d'));
        if (date_format($date, "m") >= 4) {
            $financial_year = (date_format($date, $format)) . $separator . (date_format($date, $format) + 1);
        } else {
            $financial_year = (date_format($date, $format) - 1) . $separator . date_format($date, $format);
        }

        return $financial_year;
    }
}

if (!function_exists('dateFormat')) {
    /**
     * @param string|null $dateTime
     * @param string $format
     * @return string
     */
    function dateFormat(
        ?string $dateTime = null,
        string  $format = 'd-m-Y H:i:s',
    ): string
    {
        if (isNull($dateTime)) {
            return now()->format($format);
        }

        return Carbon::parse($dateTime)->format($format);
    }
}

function get_guard(): ?string
{
    if (Auth::guard('web')->check()) {
        return "web";
    } elseif (Auth::guard('api')->check()) {
        return "api";
    } elseif (Auth::guard('sanctum')->check()) {
        return "api";
    }

    return null;
}
