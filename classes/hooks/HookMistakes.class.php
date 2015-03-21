<?php
/**
 * Mistakes for LiveStreet
 * Plugin for Grammar nazi!
 * (C) Wyfinger, wyfinger@yandex.ru
 *
 */

class PluginMistakes_HookMistakes extends Hook
{
    /**
     * Регистрация хука для вставки своего html кода в шаблон
     */
    public function RegisterHook()
    {
        // Если открыта страница топика и авторизация не требуется или если требуется и пользователь залогинен
        if ((Router::GetAction() == "blog") && (!Config::Get('need_authorization') || ($this->oUserCurrent))) {
            $this->AddHook('template_body_end', 'Mistakes');
        }
    }

    /**
     * @return mixed Возвращаем свой шаблон для внедрения в страницу
     */
    public function Mistakes()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'window_mistakes.tpl');
    }

}