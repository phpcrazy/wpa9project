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

function  ValidateDate(){ 
    var str1 = $("#StartDate").val(); 
    var str2 = $("#DueDate").val();
    var dt1  = parseInt(str1.substring(0,2),10); 
    var mon1 = getMonthFromString(str1.substring(str1.indexOf('-')+1,str1.lastIndexOf('-'))); 
    var yr1  = parseInt(str1.substring(str1.lastIndexOf('-') + 1,str1.length),10);
    var dt2  = parseInt(str2.substring(0,2),10); 
    var mon2 = getMonthFromString(str2.substring(str1.indexOf('-')+1,str2.lastIndexOf('-'))); 
    var yr2  = parseInt(str2.substring(str2.lastIndexOf('-') + 1,str2.length),10);

    if(new Date(Date.parse(mon1 + " " + dt1 + ", " + yr1))>
        new Date(Date.parse(mon2 + " " + dt2 + ", " + yr2))){
        $("#due_error").text("Due Date should not be less than Start Date");
        $("#startDate_error").text("");
        return false;
    }
    else{
        return true;
    }

}

function getMonthFromString(mon){
    return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
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
    if($('body > .container .panel-heading span.hide').text()=='Dashboard'||$('body > .container .panel-heading span.hide').text()=='Projects'||$('body > .container .panel-heading span.hide').text()=='Work Area'||$('body > .container .panel-heading span.hide').text()=='Members'||$('body > .container .panel-heading span.hide').text()=='Progress'){
        var title = $('body > .container .panel-heading span.hide').text();
        title = title.slice();
        if(title=='Dashboard')title='  Dashboard';          
        else if(title=='Progress')title='  Progress';
        else if(title=='Work Area')title='  Work Area';
        else if(title=='Members')title='  Members';
        else title='  Projects';
        
        $('#sidebar_wrapper a').each(function(){
            if($(this).children('span').text()==title)
                $(this).addClass('active');         
        });
    };        

    $('.txtSource').each(function(){
        var source = $(this).closest('body').find("div:first").attr('id');        
        $(this).val(source);
    });    

    $('#btnNo').click(function(){
        window.location.reload();
    });

    $('#btnYes').click(function(){
        $(this).closest('#btn').find('#btnSubmit').click();
        
    });
});
