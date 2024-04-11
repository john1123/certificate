<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

Loc::loadMessages(__FILE__);

$user = CurrentUser::get();
if ($user->getId()) {
    $session = Application::getInstance()->getSession();
    if (!$session->has('certificate')) { ?>
        <form method="post">
            <input type="text" id="certificate-current" name="certificate" />
            <input type="submit" value="<?=Loc::getMessage('IVAN_CERTIFICATES_ACTIVATE') ?>" />
            <input type="hidden" name="user_id" value="<?=CurrentUser::get()->getId() ?>" />
            <?=bitrix_sessid_post()?>
        </form>
        <div><?=Loc::getMessage('IVAN_CERTIFICATES_AVAILABLE') ?></div>
        <ul id="certificates-available">
        <?php
        if ($arResult["AVAILABLE"]->SelectedRowsCount() != 0) {
            while ($element = $arResult["AVAILABLE"]->GetNext()) {
                echo '    <li><a href="javascript:void(' . $element['ID'] . ')">' . $element['NAME'] . "</a></li>\n";
            }
        } else {
            echo Loc::getMessage('IVAN_CERTIFICATES_LIST_EMPTY');
        }
        ?>
        </ul>
        <?php
    } else {
        echo Loc::getMessage('IVAN_CERTIFICATES_HAVE_ACTIVE_CERTIFICATE') . ' (' . $session->get('certificate') . ')<br />' . PHP_EOL;
    }
    echo '[' . $user->getId() . '] ' . $user->getFullName();
} else {
    echo Loc::getMessage('IVAN_CERTIFICATES_ONLY_AUTHORIZED_USERS');
}