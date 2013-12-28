function validateNumber(evt) {
    var e = evt || window.event;
    var key = e.keyCode || e.which;

    if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
    // numbers   
    key >= 48 && key <= 57 ||
    // Numeric keypad
    key >= 96 && key <= 105 ||
    // Backspace and Tab and Enter
    key == 8 || key == 9 || key == 13 ||
    // Home and End
    key == 35 || key == 36 ||
    // left and right arrows
    key == 37 || key == 39 ||
    // Del and Ins
    key == 46 || key == 45) {
        // input is VALID
    }
    else {
        // input is INVALID
        e.returnValue = false;
        if (e.preventDefault) e.preventDefault();
    }

    // comma, period and minus, . on keypad  key == 190 || key == 188 || key == 109 || key == 110 ||
}

function notiTypeStyle(tmp){
    tmp.each(function(){
        var type = $(this).closest('p').children('span:first').text();
        var tmp = 'label-';
        if(type==2)tmp+='danger';
        else if(type==3)tmp+='success';
        else tmp+='info';
        $(this).addClass(tmp);
    }); 
}

$(document).ready( function() {    
    if($('body > .container .panel-title').text()=='Dashboard'||$('body > .container .panel-title').text().contains('Project')||$('body > .container .panel-title').text()=='Work Area'||$('body > .container .panel-title').text()=='Member List'||$('body > .container .panel-title').text()=='Progress'){
        var title = $('body > .container .panel-title').text();
        title = title.slice();
        if(title=='Dashboard')title='  Dashboard';          
        else if(title=='Progress')title='  Progress';
        else if(title=='Work Area')title='  Work Area';
        else if(title=='Member List')title='  Members';
        else title='  Projects';
        
        $('#sidebar_wrapper a').each(function(){
            if($(this).children('span').text()==title)
                $(this).addClass('active');         
        });
    };
});
