$(document).ready(function(){
    let className = 'code-mirror-aware';
    $('textarea.' + className).each(function(){
        if($(this).hasClass(className + '-css')){
            adminCodeMirror($(this), 'css');
        }else if($(this).hasClass(className + '-js')){
            adminCodeMirror($(this), 'javascript');
        }
    });
});

function adminCodeMirror(selector, type, isHtmlMode = true, isAutoRefresh = true){
    selector.each(function () {
        let templateData = $(this);
        let templateWrapper = templateData.parent().get(0);
        $(templateWrapper).addClass('code-mirror-aware-style-' + type);
        let cm = CodeMirror(templateWrapper, {
            value: templateData.val(),
            mode: type,
            htmlMode: isHtmlMode,
            autoRefresh: isAutoRefresh,
            lineNumbers: true
        }).on('change', function (cm) {
            templateData.val(cm.getValue());
        });
        templateData
            .hide()
            .parents('.form-group')
            .find('label');
    });
}