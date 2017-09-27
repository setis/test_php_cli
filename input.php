<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 27.09.17
 * Time: 16:14
 */
if (PHP_SAPI !== 'cli') {
    die('только в консоле');
}
if ($argc < 2) {
    input();
} else {
    $func = function ($value) {
        try {
            $arr = handler($value);
        } catch (Error $e) {
            echo $e->getMessage();
            return;
        }
        echo isArithmetic($arr) ? "является" : "не является";
        echo " арифметической прогрессией\n";
        echo isGeomethric($arr) ? "является" : "не является";
        echo " геометрической прогрессией\n";
    };
    foreach ($argv as $i => $value) {
        if ($i === 0) {
            continue;
        }
        echo "\n$value\n";
        $func($value);
    }

}
function input()
{
    echo "введите числа через запитую : ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    fclose($handle);
    try {
        $arr = handler($line);
    } catch (Error $e) {
        echo $e->getMessage();
        input();
        return;
    }
    echo isArithmetic($arr) ? "является" : "не является";
    echo " арифметической прогрессией\n";
    echo isGeomethric($arr) ? "является" : "не является";
    echo " геометрической прогрессией\n";
    input();

}

function handler($input)
{
    $arr = array_map('trim',explode(',', $input));
    // Элементов должно быть более 2
    if (count($arr) < 2) {
        throw new Error('должно быть минимум 2 числа ' . $input);
    }
    $nonums = array_filter($arr, function ($value) {
        return (!is_numeric($value));
    });
    if (count($nonums) > 0) {
        throw new Error('не все введеные являються числами:' . implode(',', $nonums));
    }
    return array_map(function ($value) {
        return $value + 0;
    }, $arr);
}

/**
 * Проверка является ли арифметической прогрессией
 * @param array $arr разделенные запятой значения прогрессии
 * @return boolean является ли прогрессией
 */
function isArithmetic($arr)
{

    // Искомая разность прогрессии между первым и вторым элементом
    // должна сохранять во всей прогрессии
    $commonDifference = $arr[1] - $arr[0];
    for ($i = 0; $i < count($arr) - 1; $i++) {
        // Разница между элементами N и N+1 не сохраяется, то это не арифметическая последовательность
        if ($arr[$i + 1] - $arr[$i] != $commonDifference) {
            return false;
        }
    }
    return true;
}

/**
 * Проверяет является ли геометрической прогрессией
 * @param array $arr разделенные запятой значения
 * @return boolean является ли геометрической прогрессией
 */
function isGeomethric($arr)
{
    $lastElement = NULL;
    // Искомая разность прогрессии между первым и вторым элементом
    // должна сохранять во всей прогрессии
    $commonDifference = $arr[1] / $arr[0];
    for ($i = 0; $i < count($arr) - 1; $i++) {

        // Разница между элементами N и N+1 не сохраяется, то это не арифметическая последовательность
        if ($arr[$i] * $commonDifference != $arr[$i + 1]) {
            return false;
        }
    }
    return true;
}

?>