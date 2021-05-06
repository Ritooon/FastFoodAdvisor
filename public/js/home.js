$(document).ready(function(){

    $('.search_input').off('keyup').on('keyup', function(){
       
    });
});

function toogleTheme(theme)
{
    if(theme == 'dark-theme') {
        $('.fa-moon').parent().css('display', 'none');
        $('.fa-sun').parent().css('display', 'inline-block');
    } else {
        $('.fa-moon').parent().css('display', 'inline-block');
        $('.fa-sun').parent().css('display', 'none');
    }

    document.cookie = "theme=" + theme;
    $('body').attr('class', theme);
}