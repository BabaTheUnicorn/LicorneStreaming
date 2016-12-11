var liste = [
	"Pirates des Caraibes",
	"Top Gun",
	"Dans la peau de John Malkovich",
	"Super 8",
	"Superman",
	"Tarzan",
	"Piège de Cristal"
];

$(document).ready( function() {
	$("#recherche").autocomplete({
		source : 'liste.php',
		focus: function( event, ui ) {
        	$("#recherche").val( ui.item.name );
        	return false;
      	},
      	select: function(event, ui) {
      		$("#recherche").val(ui.item.name);
      		$("#request").submit();
      		return false;
      	}
	}).data("ui-autocomplete")._renderItem = function(ul, item) {
		//var inner_html = '<a><div class="list_item_container"><div class="image"><img src="' + item.poster_path + '"></div><div class="titre">' + item.name + '</div></div></a>';
		return $("<li>")
			.data("item.autocomplete", item)
			//.append("<a>" + item.name + "<br><img src=\""  + item.poster_path + "\"/></a>")
			.append('<a><div class="list_item_container"><div class="image"><img src="' + item.poster_path + '"></div><div class="titre">' + item.name  + '</div></div></a>')
			.appendTo(ul);
	};/*
	.autocomplete("instance")._renderItem = function (ul, item) {
		return $("<li>")
			.append("<div>" + item.name + "</div>")
			.appendTo(ul);
	};*/
})