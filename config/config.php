<?php
/**
 * Mistakes for LiveStreet
 * Plugin for Grammar nazi!
 * (C) Wyfinger, wyfinger@yandex.ru
 *
 */

$config['need_authorization'] = true;  // если fasle неавторизованные пользователи тоже могут сообщать об ошибках,
                                       // тогда личное сообщение прийдет от админа

$config['can_send_himself'] = true;    // если true автор топика сможет сообщать об ошибках самому себе


return $config;

?>