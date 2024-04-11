Компонент для 1С Битрикс.

Нужно поместить в папку `local/components/`

Для работы требуется инфоблок с сертификатами.
К инфоблоку требуется добавить два свойства: Время активации (Дата/Время) с именем ACTIVATED и Пользователь (Привязка к пользователю) с именем USER
В первое помещается когда был активирован сертификат, а во-второе кто это сделал. Для простоты смотрится только первое поле. Предполагается, что второе также либо заполнено, либо нет.

Дополнительно, для генерации сертификатов (номеров) был написан простой инструмент на языке PHP. Для простоты в нём не был реализован контроль уникальности.
Код инструмента:
```php
<?php

$template = '....-....';
$items = 15;

$template = str_split($template);
for ($i=0; $i<$items; $i++) {
    $str = '';
    foreach ($template as $char) {
        if ($char == '.') {
            $str .= generate();
        } else {
            $str .= $char;
        }
    }
    echo $str . PHP_EOL;
}
function generate() {
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char = substr(str_shuffle($permitted_chars), 0, 1);
    return $char;
}
```

Для подключения компонента, автор использовал следующий код:
```php
<?
$APPLICATION->IncludeComponent(
	"ivan:certificate",
	"main",
	Array(
		"IBLOCK_ID" => 8.
	)
);
?>
```
