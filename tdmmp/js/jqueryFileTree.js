// jQuery File Tree Plugin
// Core by Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
// Modified By Venom for TDMMp
//
//* ****************************************************************************
// *  - TDMMp By TDM   - TEAM DEV MODULE FOR XOOPS
// *  - Licence PRO Copyright (c)  (http://www.tdmxoops.net)
// *
// * Cette licence, contient des limitations!!!
// *
// * 1. Vous devez posséder une permission d'exécuter le logiciel, pour n'importe quel usage.
// * 2. Vous ne devez pas l' étudier,
// * 3. Vous ne devez pas le redistribuer ni en faire des copies,
// * 4. Vous n'avez pas la liberté de l'améliorer et de rendre publiques les modifications
// *
// * @license     TDMFR PRO license
// * @author		TDMFR ; TEAM DEV MODULE 
// *
// * ****************************************************************************
// *
function checkHover() {
	if (obj) {
		obj.fadeOut('fast');
	} //if
	if (obj2) {
		obj2.fadeOut('fast');
	} //if
} //checkHover

var $tdmmp = jQuery.noConflict();
var obj = null;
var obj2 = null;
$tdmmp(document).ready( function() {

$tdmmp("#tdmsauv").hover(function(){
		$tdmmp("#menusauv").slideDown('fast');
		obj = null;
	}, function() {
		obj = $tdmmp("#menusauv");
		setTimeout( "checkHover()", 400);
	});
	
$tdmmp("#menusauv").hover(function(){	
$tdmmp("#menusauv").slideDown('fast');
obj = null;
}, function() {
		obj = $tdmmp("#menusauv");
		setTimeout(
			"checkHover()",
			400); // 

	});
	
$tdmmp("#tdmread").hover(function(){
		$tdmmp("#menuread").slideDown('fast');
		obj2 = null;
	}, function() {
		obj2 = $tdmmp("#menuread");
		setTimeout(
			"checkHover()",
			400); // si vous souhaitez retarder la disparition, c'est ici
	});
	
$tdmmp("#menuread").hover(function(){	
$tdmmp("#menuread").slideDown('fast');
obj2 = null;
}, function() {
		obj2 = $tdmmp("#menuread");
		setTimeout( "checkHover()", 400); 
	});
	
	});

function masque(id) {

   	var $tdmmp = jQuery.noConflict();
	
	$tdmmp(document).ready(function(){

	 if ($tdmmp("#" +id+ ":visible").length != 0) {
		$tdmmp("#" +id).fadeOut("fast", function() {
            $tdmmp("#" +id).fadeIn("fast").hide();
        });
   
    } else {	    
	$tdmmp("#" +id).fadeOut("fast", function() {
         $tdmmp("#" +id).fadeIn("fast").show();
     });
}

	
});

}

function AddFolder(id, start)
{
var $tdmmp = jQuery.noConflict();

     $tdmmp.ajax({
       type: "POST",
       url: "./include/jquery.php",
	 data: "op=addfolder&cid="+id+"&start="+start,
	   success: function(msg){
	  	$tdmmp('#tdmfolder').html(msg);
		$tdmmp('#tdmfolder').attr('value', id);
	}
     });
}

function AddMsg(msg_id)
{
var $tdmmp = jQuery.noConflict();

     $tdmmp.ajax({
       type: "POST",
       url: "./include/jquery.php",
	 data: "op=addmsg&msg_id="+msg_id,
	   success: function(msg){
	   	$tdmmp('#tdmview').fadeIn("fast").show();
	  	$tdmmp('#tdmview').html(msg);
	}
     });
}

function RemoveMsg()
{
var $tdmmp = jQuery.noConflict();

if (confirm($tdmmp('#tdmremove').attr('value'))) {
 
 	folder = $tdmmp('#tdmfolder').attr('value');
	
idCheck = [];
$tdmmp("input:checked").each(function (i) {
	idCheck[i] = $tdmmp(this).val();
	$tdmmp.ajax({
    type: "POST",
    url: "./include/jquery.php",
	data: "op=removemsg&msg_id="+idCheck[i]+"&cid="+folder,
	success: function(msg){	
	$tdmmp('#tdmmsg').html(msg);
	$tdmmp('#tdmmsg').fadeIn("fast").show();
	AddFolder(folder);
	}
     });
	 
	
		
});
}
return false;
}

function ClearMsg()
{

var $tdmmp = jQuery.noConflict();

if (confirm($tdmmp('#tdmclear').attr('value'))) {

 folder = $tdmmp('#tdmfolder').attr('value');
 
	$tdmmp.ajax({
    type: "POST",
    url: "./include/jquery.php",
	data: "op=clearmsg&cid="+folder,
	success: function(msg){	
	$tdmmp('#tdmmsg').html(msg);
	$tdmmp('#tdmmsg').fadeIn("fast").show();
	//alert(msg);	
	AddFolder(folder);
	}	
     });	
}
return false;
}

function AddContact(from_userid)
{
var $tdmmp = jQuery.noConflict();

	$tdmmp.ajax({
    type: "POST",
    url: "./include/jquery.php",
	data: "op=addcontact&from_userid="+from_userid,
	success: function(msg){	
	$tdmmp('#tdmmsg').html(msg);
	$tdmmp('#tdmmsg').fadeIn("fast").show();
	}
     });	
return false;
}

function ViewContact(contact)
{
var $tdmmp = jQuery.noConflict();

	$tdmmp.ajax({
    type: "POST",
    url: "./include/jquery.php",
	data: "op=viewcontact&contact="+contact,
	success: function(msg){
	$tdmmp('#tdmview').fadeIn("fast").show();
	$tdmmp('#tdmview').html(msg);
	}
     });	
return false;
}


function MoveMsg(cid)
{
var $tdmmp = jQuery.noConflict();

if (confirm($tdmmp('#tdmsauv').attr('value'))) {
 
idCheck = [];
$tdmmp("input:checked").each(function (i) {
	idCheck[i] = $tdmmp(this).val();
	$tdmmp.ajax({
    type: "POST",
    url: "./include/jquery.php",
	data: "op=movemsg&msg_id="+idCheck[i]+"&cid="+cid,
	success: function(msg){	
	$tdmmp('#tdmmsg').html(msg);
	$tdmmp('#tdmmsg').fadeIn("fast").show();		
	folder = $tdmmp('#tdmfolder').attr('value');
	AddFolder(folder);
	}
     });
		
});
}
return false;
}

function ReadMsg(read)
{
var $tdmmp = jQuery.noConflict();

if (confirm($tdmmp('#tdmread').attr('value'))) {
 
idCheck = [];
$tdmmp("input:checked").each(function (i) {
	idCheck[i] = $tdmmp(this).val();
	$tdmmp.ajax({
    type: "POST",
    url: "./include/jquery.php",
	data: "op=readmsg&msg_id="+idCheck[i]+"&read="+read,
	success: function(msg){	
	$tdmmp('#tdmmsg').html(msg);
	$tdmmp('#tdmmsg').fadeIn("fast").show();	
	folder = $tdmmp('#tdmfolder').attr('value');
	AddFolder(folder);	
	}
     });
	
});
}
return false;
}

if(jQuery) (function($){

var $tdmmp = jQuery.noConflict();
	
	$tdmmp.extend($.fn, {
		fileTree: function(o, h) {
			// Defaults
			if( !o ) var o = {};
			if( o.root == undefined ) o.root = '/0/';
			if( o.script == undefined ) o.script = 'jqueryFileTree.php';
			if( o.folderEvent == undefined ) o.folderEvent = 'click';
			if( o.expandSpeed == undefined ) o.expandSpeed= 500;
			if( o.collapseSpeed == undefined ) o.collapseSpeed= 500;
			if( o.expandEasing == undefined ) o.expandEasing = null;
			if( o.collapseEasing == undefined ) o.collapseEasing = null;
			if( o.multiFolder == undefined ) o.multiFolder = true;
			if( o.loadMessage == undefined ) o.loadMessage = 'Loading...';
			
			$tdmmp(this).each( function() {
				
				function showTree(c, t) {
					$tdmmp(c).addClass('wait');
					$tdmmp(".jqueryFileTree.start").remove();
					$tdmmp.post(o.script, { dir: t }, function(data) {
						$tdmmp(c).find('.start').html('');
						$tdmmp(c).removeClass('wait').append(data);
						if( o.root == t ) $tdmmp(c).find('UL:hidden').show(); else $tdmmp(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
						bindTree(c);
					});
				}
				
				function bindTree(t) {
					$tdmmp(t).find('LI A').bind(o.folderEvent, function() {
						if( $tdmmp(this).parent().hasClass('directory') ) {
							if( $tdmmp(this).parent().hasClass('collapsed') ) {
								// Expand
								if( !o.multiFolder ) {
									$tdmmp(this).parent().parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
									$tdmmp(this).parent().parent().find('LI.directory').removeClass('expanded').addClass('collapsed');
								}
								$tdmmp(this).parent().find('UL').remove(); // cleanup
								showTree( $tdmmp(this).parent(), escape($tdmmp(this).attr('rel').match( /.*\// )) );
								$tdmmp(this).parent().removeClass('collapsed').addClass('expanded');
							} else {
								// Collapse
								$tdmmp(this).parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
								$tdmmp(this).parent().removeClass('expanded').addClass('collapsed');
							}
						} else {
							h($tdmmp(this).attr('rel'));
						}
						return false;
					});
					// Prevent A from triggering the # on non-click events
					if( o.folderEvent.toLowerCase != 'click' ) $tdmmp(t).find('LI A').bind('click', function() { return false; });
				}
				// Loading message
				$tdmmp(this).html('<ul class="jqueryFileTree start"><li class="wait">' + o.loadMessage + '<li></ul>');
				// Get the initial file list
				showTree( $tdmmp(this), escape(o.root) );
			});
		}
	});
	
})(jQuery);