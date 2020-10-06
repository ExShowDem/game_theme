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

    var settings = window.wpTeamMatchesLoginSettings || {};

    $('#steam-login').on('click', function () {
        window.open(settings.steam_login_url, 'wp-team-matches-auth', 'width=800,height=600');
    });

    $('#facebook-login').on('click', function () {
        window.open(settings.facebook_login_url, 'wp-team-matches-auth', 'width=520,height=320');
    });

    $('#wp-team-matches-why-login').tipsy();

});