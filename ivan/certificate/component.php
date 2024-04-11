<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Application;
use \Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$IBLOCK_ID = $this->arParams["IBLOCK_ID"];

$request = Application::getInstance()->getContext()->getRequest();
$certificate = $request->getPost("certificate");
if (!is_null($certificate)) {
    if (!check_bitrix_sessid()) {
        ShowError(Loc::getMessage('IVAN_CERTIFICATES_ACCESS_DENIED'));
        return;
    }
    // Данные пришёл из формы - пользователь хочет активировать сертификат

    // Поиск сертификата по его имени
    $arFilter = array(
        'IBLOCK_ID' => $IBLOCK_ID,
        'NAME' => $certificate,
        'PROPERTY_ACTIVATED' => false
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
        if ($res->SelectedRowsCount() > 0) {
            // Сертификат был найден
            // Обновляем свойства, сбрасываем кэш и сохраняем сертификат в сессию
            $dateNow = new DateTime();
            $dateNow = $dateNow->format('Y-m-d H:i:s');
            $values = array(
                'USER' => CurrentUser::get()->getId(),
                'ACTIVATED' => $dateNow
            );

            // Место для дополнительного кода.
            // Можно отправлять письма и т.п.

            CIBlockElement::SetPropertyValuesEx($id, false, $values);
            CIBlock::clearIblockTagCache($IBLOCK_ID);

            $session = Application::getInstance()->getSession();
            $session->set('certificate', $certificate);
    } else {

        ShowError(Loc::getMessage('IVAN_CERTIFICATES_NOT_FOUND'));
    }
}
$arResult['IBLOCK_ID'] = $arParams['IBLOCK_ID'];

$arFilter = array(
    'IBLOCK_ID' => $IBLOCK_ID,
    'ACTIVE' => 'Y',
    'PROPERTY_ACTIVATED' => false
);
// Заполняем доступные сертификаты
$this->arResult["AVAILABLE"] = CIBlockElement::GetList(
    array(),
    $arFilter,
    false,
    array(),
    array('ID', 'NAME')
);

$this->includeComponentTemplate();