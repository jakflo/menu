$("div#buttons button").attr("disabled", true);
    var id_selected;
    var click_disabled = false;
    var click_disabled_by_button = false;
    var id_clicked;
    var task;
        
$("div#menu ul li").mousedown(function(){
    if (!click_disabled && !click_disabled_by_button){
        id_clicked = $(this).attr("id");
        click_disabled = true;
        $("#" + id_selected).removeClass("selected");
        if (id_selected == id_clicked){
            $("div#buttons button").attr("disabled", true);
            return;
        }
        $("#" + id_clicked).addClass("selected");
        id_selected = id_clicked;
        $("div#buttons button").attr("disabled", false);
    }
});
$("div#menu ul li").mouseup(function(){
    if (!click_disabled_by_button){
        click_disabled = false;
    }
});

$("button#add_sibb, button#add_kid, button#rename").click(function(){
    click_disabled_by_button = true;
    task = $(this).attr("id");
    open_modal_add_or_ren();
});
$("button#delete").click(function(){
    click_disabled_by_button = true;
    task = $(this).attr("id");
    open_modal_delete();
});

function open_modal_add_or_ren(){
   $("div#modal_add_or_ren").css("visibility", "visible");
   var modalbox_text;
   var action_button_text;
   switch (task){
       case "add_sibb":
          modalbox_text = "Přidání nové kategorie. Vyberte jméno.";
          action_button_text = "Přidej";
          break;
        case "add_kid":
          modalbox_text = "Přidání nové podkategorie. Vyberte jméno.";
          action_button_text = "Přidej";
          break;
        case "rename":
          modalbox_text = "Přejmenování kategorie. Vyberte jméno.";
          action_button_text = "Přejmenuj";
          break;
        default: return;
    }
    $("div#modal_add_or_ren p").text(modalbox_text);
    $("button#modal_add_or_ren_action_button").text(action_button_text);
}

function open_modal_delete(){
    $("div#modal_delete").css("visibility", "visible");
    var modal_text = 'Skutečně si přejete vymazat kategorii <b>"' +
            escapeHtml($('#' + id_selected + ' >span').text()) +
            '"</b> a VŠECHNY její podkategorie?';
    $("div#modal_delete p").html(modal_text);
}

$("button#modal_add_or_ren_cancel_button, button#modal_delete_no_button").click(function(){
    if (task == "add_sibb" || task =="add_kid" || task == "rename"){
        $("div#modal_add_or_ren").css("visibility", "collapse");
    }
    if (task == "delete"){
        $("div#modal_delete").css("visibility", "collapse");
    }
    task = "";
    click_disabled_by_button = false;
});

$("button#modal_add_or_ren_action_button, button#modal_delete_yes_button").click(function(){
    var form_cat_name = "";
    if (task == "add_sibb" || task =="add_kid" || task == "rename"){
        form_cat_name = document.forms["modal_add_or_ren_form"]["cat_name"].value;
        if (form_cat_name == ""){ return;}
    }
    var cat_mod_obj = new Object();
    cat_mod_obj.task = task;
    cat_mod_obj.cat_id = id_selected;
    cat_mod_obj.name = form_cat_name;
    var cat_mod_json = JSON.stringify(cat_mod_obj);
    $.get("/admin/?do=editCats&payload=" + cat_mod_json, function(resp){ window.location = "/admin";});
});
    
