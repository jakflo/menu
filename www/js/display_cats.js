    var display_sibbs = function(data){
        var row = "";
        var count = data.length; var c;
        for (c = 0; c < count; c++){
            row += "<li id='" + data[c].id + "'><span>" + data[c].name + "</span></li>";
        }
        row = "<ul>" + row + "</ul>" + "\n";
        return row;
    };
    
    var kids_of_id = function(cats, id){
        var kids = new Array();
        var c, ind = 0;
        var count = cats.length;
        for (c = 0; c < count; c++){
            if (cats[c].parrent_id == id){
                kids[ind] = cats[c];
                ind++;
            }
        }
        return kids;
    };
    var data = new Array();
    var html_chunk;
    
    
    data = kids_of_id(cats, null);
    html_chunk = display_sibbs(data);
    $("div#menu").html(html_chunk);
    
    var parrents_count = ids_with_kids.length;
    var i;
    for (i = 0; i < parrents_count; i++){
        data = new Array();
        data = kids_of_id(cats, ids_with_kids[i]);
        html_chunk = display_sibbs(data);
        $("div#menu ul li#" + ids_with_kids[i]).append(html_chunk);
    } 

