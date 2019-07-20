function gettmtOptions() {
    var x = document.getElementById('destination');
    txt = '';
    for (i = 0; i < x.length; i++) {
        if (i == 0) {
            txt = x.options[0].value;
        } else {
            txt = txt + ';' + x.options[i].value;
        }

    }
    document.getElementById('auditors').value = txt;
}