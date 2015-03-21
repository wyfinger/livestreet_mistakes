<?php
/**
 * Mistakes for LiveStreet
 * Plugin for Grammar nazi!
 * (C) Wyfinger, wyfinger@yandex.ru
 *
 */

if (!class_exists('Plugin')) {
    die('You are bad hacker, try again, baby!');
}

class PluginMistakes extends Plugin
{
    /**
     * Объявление переопределений
     */
    protected $aInherits = array(
        'action' => array('ActionAjax'),  // Дополним модуль Ajax своим методом
    );

    /**
     * Активация плагина
     * @return bool Удалось ли активизироваться
     */
    public function Activate()
    {
        return true;
    }

    /**
     * Инициализация плагина
     */
    public function Init()
    {
        parent::Init();
        // Если авторизация не требуется или если требуется и пользователь залогинен - подключим наши Js и Css
        if(!Config::Get('need_authorization') || ($this->oUserCurrent)) {
            $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__) . 'js/mistakes.js');
            $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__) . 'css/mistakes.css');
        }
    }
}

?>