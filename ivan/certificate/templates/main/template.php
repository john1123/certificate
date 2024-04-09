<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

?>

<form method="post">
    <input type="text" name="certificate" />
    <input type="button" value="Активировать" />
    <input type="hidden" name="user_id" value="<?=CurrentUser::get()->getId() ?>" />
    <?=bitrix_sessid_post()?>
</form>
<div><?=Loc::getMessage('IVAN_CERTIFICATES_AVAILABLE') ?></div>
<ul>
<?php
if ($arResult["AVAILABLE"]->SelectedRowsCount() != 0) {
while ($element = $arResult["AVAILABLE"]->GetNext()) {
    echo '    <li><a href="' . $element['DETAIL_PAGE_URL'] . '">' . $element['NAME'] . "</a></li>\n";
}
} else {
    echo Loc::getMessage('IVAN_CERTIFICATES_LIST_EMPTY');
}
?>
</ul>
<?php
echo '[' . CurrentUser::get()->getId() . '] ' . CurrentUser::get()->getFullName();