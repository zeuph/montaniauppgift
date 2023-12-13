<?php

namespace App\Service;


/*
Filter service is used to filter the data according to its method
*/

class FilterService
{
    public function filter($data, $method)
    {
        // Filter everything first
        switch ($method) {
            case 'lowtohigh':
                usort($data, function ($a, $b) {
                    return $a->pris - $b->pris;
                });
                break;
            case 'hightolow':
                usort($data, function ($a, $b) {
                    return $b->pris - $a->pris;
                });
                break;
            case 'alphabetical':
                usort($data, function ($a, $b) {
                    return (
                        strcmp(
                            property_exists($a, 'artiklar_benamning')  ? $a->artiklar_benamning : "Namn kunde inte hittas",
                            property_exists($b, 'artiklar_benamning')  ? $b->artiklar_benamning : "Namn kunde inte hittas"
                        )
                    );
                });
                break;
        }
        // Break it up into categories after sorting
        $categoryArr = $this->separateIntoCategories($data);
        // Sneaky quick fix to get unsorted at bottom of the page
        return array_reverse($categoryArr);
    }

    function separateIntoCategories($data)
    {
        $groupedObjects = [];
        foreach ($data as $object) {
            $category = property_exists($object, 'artikelkategorier_id') ? $object->artikelkategorier_id : "OSORTERAT";
            if (!isset($groupedObjects[$category])) {
                $groupedObjects[$category] = [];
            }
            $groupedObjects[$category][] = $object;
        }
        return $groupedObjects;
    }
}
