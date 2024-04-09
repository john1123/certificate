<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult['IBLOCK_ID'] = $arParams['IBLOCK_ID'];

$arFilter = array(
    'IBLOCK_ID' => $this->arParams["IBLOCK_ID"],
    'ACTIVE' => 'Y',
    // ACTIVATED // Когда сертификат был активирован
    // USER // Привязка к пользователю
);
$this->arResult["AVAILABLE"] = CIBlockElement::GetList(
    array(),
    $arFilter,
    false,
    array(),
    array('ID', 'NAME', 'DETAIL_PAGE_URL', 'ACTIVE')
);

$this->includeComponentTemplate();