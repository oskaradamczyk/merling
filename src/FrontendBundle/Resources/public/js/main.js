/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    if ($(document).scrollTop() > 50){
        $('nav').addClass('scrolled');
    }else{
        $('nav').removeClass('scrolled');
    }
   $(window).scroll(function(){
       if ($(document).scrollTop() > 50){
           $('nav').addClass('scrolled');
       }else{
           $('nav').removeClass('scrolled');
       }
       if ($(document).scrollTop() === ($(document).height() - $(window).height())){
           $(".footerBar").stop().animate({height:'350'},150);
           $(".imgFooter").stop().animate({width:'350'},250);
       }else{
           $(".footerBar").stop().animate({height:'70'},150);
           $(".imgFooter").stop().animate({width:'0'},0);
       }
   }) 
});
function growSlowly(){
    if($(document).scrollTop() < ($(document).height() - $(window).height() - 50)){
        $(".footerBar").animate({height:'350'});
        $(".imgFooter").stop().animate({width:'350'});
    }
}
function shrinkSlowly(){
    if($(document).scrollTop() < ($(document).height() - $(window).height() - 50)){
        $(".footerBar").animate({height:'70'});
        $(".imgFooter").stop().animate({width:'0'});
    }
}
function changeGlyphicon(id){function hasClass(element, cls){return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;};var el=document.getElementById(id);if(hasClass(el, 'glyphicon-chevron-down')==true){$("#"+id).addClass('glyphicon-chevron-up');$("#"+id).removeClass('glyphicon-chevron-down');}else if(hasClass(el, 'glyphicon-chevron-up')==true){$("#"+id).addClass('glyphicon-chevron-down');$("#"+id).removeClass('glyphicon-chevron-up');}else if(hasClass(el, 'glyphicon-chevron-left')==true){$("#"+id).addClass('glyphicon-chevron-right');$("#"+id).removeClass('glyphicon-chevron-left');}else{$("#"+id).addClass('glyphicon-chevron-left');$("#"+id).removeClass('glyphicon-chevron-right');}}
function enlargeTeamText(id){function hasClass(element, cls){return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;};var el=document.getElementById(id);if(hasClass(el, 'glyphicon-chevron-left')==true){$("#f"+id).animate({width:'96.5%'});}else{$("#f"+id).animate({width:'330'});}}
    