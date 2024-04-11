<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Application;
use \Bitrix\Main\Engine\CurrentUser;

$IBLOCK_ID = $this->arParams["IBLOCK_ID"];

$request = Application::getInstance()->getContext()->getRequest();
$certificate = $request->getPost("certificate");
if (!is_null($certificate)) {
    $arFilter = array(
        'IBLOCK_ID' => $IBLOCK_ID,
        'NAME' => $certificate
    );
    $res = CIBlockElement::GetList(
        array(),
        $arFilter,
        false,
        array(),
        array('ID'));
        while($ar = $res->Fetch() ) {
            $id = $ar['ID'];
        }
    $dateNow = new DateTime();
    $dateNow = $dateNow->format('Y-m-d H:i:s');
    $values = array(
        'USER' => CurrentUser::get()->getId(),
        'ACTIVATED' => $dateNow
    );
    CIBlockElement::SetPropertyValuesEx($id, false, $values);
    CIBlock::clearIblockTagCache($IBLOCK_ID);
}
$arResult['IBLOCK_ID'] = $arParams['IBLOCK_ID'];

$arFilter = array(
    'IBLOCK_ID' => $IBLOCK_ID,
    'ACTIVE' => 'Y',
    'PROPERTY_ACTIVATED' => false
    // USER // Привязка к пользователю
);
$this->arResult["AVAILABLE"] = CIBlockElement::GetList(
    array(),
    $arFilter,
    false,
    array(),
    array('ID', 'NAME')
);

$this->includeComponentTemplate();