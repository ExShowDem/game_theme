/*
    WP-TeamMatches
    (c) 2011 Andrej Mihajlov

    This file is part of WP-TeamMatches.

    WP-TeamMatches is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WP-TeamMatches is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WP-TeamMatches.  If not, see <http://www.gnu.org/licenses/>.
*/

jQuery(document).ready(function ($) {
    var messages = {
        'wp-team-matches-maps': wpCWAdminL10n.confirmDeleteMap,
        'wp-team-matches-games': wpCWAdminL10n.confirmDeleteGame,
        'wp-team-matches-teams': wpCWAdminL10n.confirmDeleteTeam,
        'wp-team-matches-matches': wpCWAdminL10n.confirmDeleteMatch
    };

    Object.keys(messages).forEach(function (key) {
        $('.' + key + ' span.delete a').each(function () {
            var data = {
                link : $(this).attr('href'),
                message : messages[key]
            };

            $(this).bind('click', data,
                function (evt) {
                    if(confirm(evt.data.message)) {
                        location.href = evt.data.link;
                    }
                    return false;
                });

        });
    });

    $('select.select2').select2();

});

/*matches*/
function GoSubmit(e) {
    if ( e.which == 13 ) {
        e.preventDefault();
        jQuery('#matches-search-submit').click();
    }
}
jQuery(document).ready(function() {
    jQuery('#matches-search-submit').on('click', function(e) {
        e.preventDefault();
        document.location.search = insertParam('s', jQuery("#matches-search-input").val());
    });
});
function insertParam(key, value) {

    let kvp = document.location.search.substr(1).split('&');
    if (kvp === '') {
        document.location.search = '?' + key + '=' + value;
    }
    else {

        let i = kvp.length; var x; while (i--) {
            x = kvp[i].split('=');

            if (x[0] === key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if (i < 0) { kvp[kvp.length] = [key, value].join('='); }

        //this will reload the page, it's likely better to store this until finished
        //document.location.search
        return kvp.join('&');

    }
}
