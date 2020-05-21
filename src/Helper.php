<?php

namespace Wiretables;

class Helper
{
    /**
     * Normalize the row from results (Eloquent, stdClass) to array
     *
     * @param $row \Illuminate\Database\Eloquent\Model|\stdClass
     *
     * @return array
     */
    public static function normalizeRow($row) : array
    {
        if ($row instanceof \Illuminate\Database\Eloquent\Model)
        {
            return $row->toArray();
        }
        else
        {
            return (array) $row;
        }
    }

    /**
     * @param $field
     * @param $fields
     * @return bool
     */
    public static function isFieldVisible($field, $fields) : bool
    {
        if (isset($fields[$field])
            AND isset($fields[$field]['display'])
            AND $fields[$field]['display'] == false) return false;

        return true;
    }

}
