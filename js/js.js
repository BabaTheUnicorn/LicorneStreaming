var jq = (function() {

	return {
		modules : {}
	}

}) ();

jq.modules.animation = ( function() {

	var area = $(".frame");
	var cnrTL = $(".cnrTL");
	var cnrTR = $(".cnrTR");
	var cnrBL = $(".cnrBL");
	var cnrBR = $(".cnrBR");
	
	return {
		enter : function() {
			cnrTL.animate({top: "-4px", left: "-4px", width: "0px", height: "99px"}, 200, "linear");
			cnrTR.animate({top: "-4px", right: "-4px", width: "199px", height: "0px"}, 200, "linear");
			cnrBL.animate({bottom: "-4px", left: "-4px", width: "199px", height: "0px"}, 200, "linear");
			cnrBR.animate({bottom: "-4px", right: "-4px", width: "0px", height: "99px"}, 200, "linear");
		},
		leave : function() {
			cnrTL.animate({top: "4px", left: "4px", width: "12px", height: "12px"}, 200, "linear");
			cnrTR.animate({top: "4px", right: "4px", width: "12px", height: "12px"}, 200, "linear");
			cnrBL.animate({bottom: "4px", left: "4px", width: "12px", height: "12px"}, 200, "linear");
			cnrBR.animate({bottom: "4px", right: "4px", width: "12px", height: "12px"}, 200, "linear");
		},
		init : function() {
			area.hover(jq.modules.animation.enter, jq.modules.animation.leave);
		}
	}
	
}) ();


jq.modules.seasons = ( function() {

	var nbSeasons = 1;

	$("#liste_saison").children()/*.each(function() {
		$(this)*/.click(function() {
			$(".episodes_active:nth-child(" + nbSeasons + ")").css("display", "none");
			$(".active").removeClass("active");
			$(this).addClass("active");
			// Changement de saison active
			nbSeasons = $(".active").val();
			nbSeasons++;
			console.log("NB : " + $(".active").val());
			//$(".episodes_active:nth-child(" + nbSeasons + ")").css("display", "none");

			/*$(".active").removeClass("active");
			$(this).addClass("active");*/
			// Recuperation du nouveau numero de saison
			//nbSeasons = $(".active").val();
			$(".episodes_active:nth-child(" + nbSeasons + ")").css("display", "unset");
			// Ajout des épisode de la nouvelle saison
			/*var ligne = $("<tr></tr>");
				ligne.append($("<td><img src=\""+ /*item*res.movies[i].image + "\" alt=\"image du film\" /></td>"));*/
		});
	//});
	
	/*return {
		enter : function() {
			cnrTL.animate({top: "-4px", left: "-4px", width: "0px", height: "99px"}, 200, "linear");
			cnrTR.animate({top: "-4px", right: "-4px", width: "199px", height: "0px"}, 200, "linear");
			cnrBL.animate({bottom: "-4px", left: "-4px", width: "199px", height: "0px"}, 200, "linear");
			cnrBR.animate({bottom: "-4px", right: "-4px", width: "0px", height: "99px"}, 200, "linear");
		},
		leave : function() {
			cnrTL.animate({top: "4px", left: "4px", width: "12px", height: "12px"}, 200, "linear");
			cnrTR.animate({top: "4px", right: "4px", width: "12px", height: "12px"}, 200, "linear");
			cnrBL.animate({bottom: "4px", left: "4px", width: "12px", height: "12px"}, 200, "linear");
			cnrBR.animate({bottom: "4px", right: "4px", width: "12px", height: "12px"}, 200, "linear");
		},
		init : function() {
			area.hover(jq.modules.animation.enter, jq.modules.animation.leave);
		}
	}*/
	
}) ();

jq.modules.search = ( function() {
	$("#srch").click(function() {
		$("#recherche").animate({display: "block", width: "300px"}, 550);
	});

}) ();



jq.modules.home = ( function() {
	$(".serie_conteneur").hover(function() {
		$(this).find($(".filtre")).animate({opacity: "1"}, 50);
	}, function() {
		$(".filtre").animate({opacity: "0"}, 50);
	});

}) ();


$(document).ready( function() {
	jq.modules.animation.init();
});