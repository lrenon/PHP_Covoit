<?php
function getEnglishDate($date)
{
    $membres = explode('-', $date);
    $date = $membres[0] . '-' . $membres[1] . '-' . $membres[2];
    return $date;
}

function addJours($date, $nbJours)
{
    $membres = explode('-', $date);
    $date = $membres[0] . '-' . $membres[1] . '-' . (intval($membres[2]) + $nbJours);
    return $date;
}

function removeJours($date, $nbJours)
{
    $membres = explode('-', $date);
    $date = $membres[0] . '-' . $membres[1] . '-' . (intval($membres[2]) - $nbJours);
    return $date;
}
?>