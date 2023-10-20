<?php
function getBaseUrl() {
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
return $protocol . $domainName;
}

function getFieldId($fieldLabel, $fieldCount = 1)
{
    return "{$fieldLabel}-{$fieldCount}";
}

function getFieldName($fieldLabel, $fieldCount = 1)
{
    return "Card[{$fieldCount}][{$fieldLabel}]";
}