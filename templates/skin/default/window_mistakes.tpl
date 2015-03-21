<div class="modal modal-mistake_window" id="window_mistakes">
    <header class="modal-header">
        <h3>{$aLang.plugin.mistakes.dialog_title}</h3>
        <a href="#" class="close jqmClose"></a>
    </header>
    <script type="text/javascript">
        var js_select_text="{$aLang.plugin.mistakes.js_select_text}";
        var js_300_char_max="{$aLang.plugin.mistakes.js_300_char_max}";
    </script>
    <div class="modal-content">
        <form method="POST" action="" enctype="multipart/form-data" id="block_mistake_comment" onsubmit="return false;"
              data-type="pc">
            <p>
                <label>{$aLang.plugin.mistakes.dialog_message}</label>

            <div id="mistake_text_div" class="mistake_text">&nbsp;</div>
            <input name="mistake_text_hide" id="mistake_text_hide" type="hidden">
            </p>
            <p>
                <label for="mistake_comment">{$aLang.plugin.mistakes.dialog_comment_label}</label>
                <textarea name="mistake_comment" id="mistake_comment" class="input-width-full"></textarea>
            </p>
            <button type="submit" class="button button-primary"
                    onclick="ls.ajaxSendMistake('block_mistake_comment');">{$aLang.plugin.mistakes.submit}</button>
            <button type="submit" class="button jqmClose">{$aLang.plugin.mistakes.cancel}</button>
        </form>
    </div>
</div>
	