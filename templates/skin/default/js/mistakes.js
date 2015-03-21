/*
 * Mistakes for LiveStreet
 * Plugin for Grammar nazi!
 * (C) Wyfinger, wyfinger@yandex.ru
 *
 * Этот код почти полностью взят отсюда: http://www.mistakes.ru/script/mistakes_dev
 *
 */

function getText(e) {
    if (!e) e = window.event;
    if ((e.ctrlKey) && ((e.keyCode == 10) || (e.keyCode == 13))) {
        CtrlEnter();
    }
    return true;
}

function mis_get_sel_text() {
    if (window.getSelection) {
        txt = window.getSelection();
        selected_text = txt.toString();
        full_text = txt.anchorNode.textContent;
        selection_start = txt.anchorOffset;
        selection_end = txt.focusOffset;
    }
    else if (document.getSelection) {
        txt = document.getSelection();
        selected_text = txt.toString();
        full_text = txt.anchorNode.textContent;
        selection_start = txt.anchorOffset;
        selection_end = txt.focusOffset;
    }
    else if (document.selection) {
        txt = document.selection.createRange();
        selected_text = txt.text;
        full_text = txt.parentElement().innerText;

        var stored_range = txt.duplicate();
        stored_range.moveToElementText(txt.parentElement());
        stored_range.setEndPoint('EndToEnd', txt);
        selection_start = stored_range.text.length - txt.text.length;
        selection_end = selection_start + selected_text.length;
    }
    else {
        return;
    }
    var txt = {
        selected_text: selected_text,
        full_text: full_text,
        selection_start: selection_start,
        selection_end: selection_end
    };
    return txt;
}

function mis_get_sel_context(sel) {
    selection_start = sel.selection_start;
    selection_end = sel.selection_end;
    if (selection_start > selection_end) {
        tmp = selection_start;
        selection_start = selection_end;
        selection_end = tmp;
    }

    context = sel.full_text;

    context_first = context.substring(0, selection_start);
    context_second = context.substring(selection_start, selection_end);
    context_third = context.substring(selection_end, context.length);
    context = context_first + '<strong>' + context_second + '</strong>' + context_third;

    context_start = selection_start - 60;
    if (context_start < 0) {
        context_start = 0;
    }

    context_end = selection_end + 60;
    if (context_end > context.length) {
        context_end = context.length;
    }

    context = context.substring(context_start, context_end);

    context_start = context.indexOf(' ') + 1;

    if (selection_start + 60 < context.length) {
        context_end = context.lastIndexOf(' ', selection_start + 60);
    }
    else {
        context_end = context.length;
    }

    selection_start = context.indexOf('<strong>');
    if (context_start > selection_start) {
        context_start = 0;
    }

    if (context_start) {
        context = context.substring(context_start, context_end);
    }

    return context;
}

function CtrlEnter() {
    var sel = mis_get_sel_text();
    if (sel.selected_text.length > 300) {
        //alert('Можно выделить не более 300 символов!');
        alert(js_300_char_max);  // переменные js_select_text и js_300_char_max берутся из файла локали и прогружаются
    }                            // черех Js в шаблоне
    else if (sel.selected_text.length == 0) {
        //alert('Выделите ошибку!');
        alert(js_select_text);
    }
    else {
        // Get selection context.
        mis = mis_get_sel_context(sel);
        $("#mistake_comment").val('');
        $("#mistake_text_div").html(mis);
        $("#mistake_text_hide").val(mis);
        $("#window_mistakes")
            .jqm()
            .jqmShow()
    }
};

ls.ajaxSendMistake = function (form) {
    ls.ajaxSubmit('mistakes/message/', form, function (data) {
        if (data.bStateError) {
            ls.msg.error(data.sMsgTitle, data.sMsg);
        } else {
            $
            $('#window_mistakes')
                .find('#mistake_text, #mistake_comment').val('')
                .end()
                .jqmHide();
        }
    });
};

document.onkeypress = getText;
