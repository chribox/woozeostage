$(document).ready(function() {
    var box = null;
    $("#userclick li").click(function() {
        var $username = $(this).text();
        var pseudo = ($("#pseudo").data("pseudo"));
        var $container = $("#chat_div");
        var $divexiste = false;
        // ----------
        // Affichage
        // ----------
        //
        // on teste si un div ayant un id du même nom que le username_box existe déjà
        $('div').each(function() {
            if ($(this).attr('id') == $username + '_box') {
                $divexiste = true;
            }
        });
        // ---
        // si il n'existe pas, je le créer (id=username)
        // ---
        if (!$divexiste) {
            $container.append('<div id="' + $username + '" style="float :left;"></div>');
            //
            // je crée une box
            box = $('#' + $username).chatbox({id: $username,
                title: "woozeostage chat : " + $username,
                offset: 20,
                user: {key: "value"},
                messageSent: function(id, user, msg) {
                    $("#log").append(id + " said: " + msg + "<br/>");
                    $('#' + $username).chatbox("option", "boxManager").addMsg(pseudo, msg);
                }});
        }
//        else {
//            //
//            // je crée une box
//            //
//            box = $('#' + $username).chatbox({id: $username,
//                title: "woozeostage chat : " + $username,
//                offset: 20,
//                user: {key: "value"},
//                messageSent: function(id, user, msg) {
//                    $("#log").append(id + " said: " + msg + "<br/>");
//                    $('#' + $username).chatbox("option", "boxManager").addMsg(pseudo, msg);
//                }});
//        }

    });
});
