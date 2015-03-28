<?php
/**
 * Mistakes for LiveStreet
 * Plugin for Grammar nazi!
 * (C) Wyfinger, wyfinger@yandex.ru
 *
 */

/**
 * Дополняем ActionAjax своим обработчиком
 */
class PluginMistakes_ActionAjax extends PluginMistakes_Inherit_ActionAjax
{
    /*
     * Регистрация Ajax обработчика
     */
    protected function RegisterEvent()
    {
        parent::RegisterEvent();
        $this->AddEventPreg('/^mistakes$/i', '/^message$/', 'EventMessageForm');
    }

    /*
     * Обработка сообщения об ошибке от Javascript
     */
    protected function EventMessageForm()
    {
        $this->Viewer_SetResponseAjax('jsonIframe', false);

        if (Config::Get('plugin.mistakes.need_authorization') && !$this->oUserCurrent) {
            $this->Message_AddErrorSingle($this->Lang_Get('plugin.mistakes.need_authorization_error'), $this->Lang_Get('error'));
            return;
        }

        $mistake_url = $_SERVER[HTTP_REFERER];
        $mistake_text = $this->Text_Parser(getRequestStr('mistake_text_hide', null, 'post'));
        $mistake_comment = $this->Text_Parser(strip_tags(getRequestStr('mistake_comment', null, 'post')));

        $topic_id = preg_replace('%.*/(\d+)\.html.*%simU', '$1', $mistake_url);
        $topic = $this->Topic_GetTopicById($topic_id);

        // Нельзя отправлять сообщения самому себе
        if($this->oUserCurrent->getUserId()==$topic->getUserId()) {
            return;
        }

        // Если разрешено отправлять сообщения об ошибках ананимно шлем сообщение от админа
        // Удалил лишнюю логику, need_authorization с пустым oUserCurrent уже проверено выше
        $message_from = $this->oUserCurrent ? $this->oUserCurrent->getUserId() : 1;

        $message_to = $topic->getUserId();

        $message_theme = str_replace(array('#topic_title#', '#topic_link#', '#mistake_text#', '#mistake_comment#'),
            array($topic->getTitle(), $mistake_url, $mistake_text, $mistake_comment), $this->Lang_Get('plugin.mistakes.message_theme'));
        $message_body = str_replace(array('#topic_title#', '#topic_link#', '#mistake_text#', '#mistake_comment#'),
            array($topic->getTitle(), $mistake_url, $mistake_text, $mistake_comment), $this->Lang_Get('plugin.mistakes.message_body'));

        // Отправляем сообщение пользователю
        $this->Talk_SendTalk($message_theme, $message_body, $message_from, $message_to);

        $this->Viewer_AssignAjax('sText', 'Ok');
    }
}
