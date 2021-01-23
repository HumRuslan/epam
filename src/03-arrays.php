<?php
/**
 * The $input variable contains an array of digits
 * Return an array which will contain the same digits but repetitive by its value
 * without changing the order.
 * Example: [1,3,2] => [1,3,3,3,2,2]
 *
 * @param  array  $input
 * @return array
 */
function repeatArrayValues(array $input)
{
    $result = [];
    foreach ($input as $value) {
        for ($i = 0; $i < $value; $i++) {
            array_push($result, $value);
        }
    }
    return $result;
}

/**
 * The $input variable contains an array of digits
 * Return the lowest unique value or 0 if there is no unique values or array is empty.
 * Example: [1, 2, 3, 2, 1, 5, 6] => 3
 *
 * @param  array  $input
 * @return int
 */
function getUniqueValue(array $input)
{
    foreach ($input as $value) {
        $keys = array_keys($input, $value);
        if (count($keys) == 1) {
            return $value;
        }
    }
    return 0;
}

/**
 * The $input variable contains an array of arrays
 * Each sub array has keys: name (contains strings), tags (contains array of strings)
 * Return the list of names grouped by tags
 * !!! The 'names' in returned array must be sorted ascending.
 *
 * Example:
 * [
 *  ['name' => 'potato', 'tags' => ['vegetable', 'yellow']],
 *  ['name' => 'apple', 'tags' => ['fruit', 'green']],
 *  ['name' => 'orange', 'tags' => ['fruit', 'yellow']],
 * ]
 *
 * Should be transformed into:
 * [
 *  'fruit' => ['apple', 'orange'],
 *  'green' => ['apple'],
 *  'vegetable' => ['potato'],
 *  'yellow' => ['orange', 'potato'],
 * ]
 *
 * @param  array  $input
 * @return array
 */
function groupByTag(array $input)
{
    $result = [];
    foreach ($input as $value) {
        foreach ($value['tags'] as $item) {
            if (array_key_exists($item, $result)) {
                $result[$item][] = $value['name'];
                sort($result[$item], SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                $result[$item] = [$value['name']];
            }
        }
    }
    ksort($result, SORT_NATURAL | SORT_FLAG_CASE);
    return $result;
}