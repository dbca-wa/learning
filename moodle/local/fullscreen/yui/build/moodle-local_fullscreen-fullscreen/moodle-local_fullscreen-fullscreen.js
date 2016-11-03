YUI.add('moodle-local_fullscreen-fullscreen', function (Y, NAME) {

/**
 * This file contains the toggle fullscreen mode functionality.
 *
 * @module    local_fullscreen-fullscreen
 * @copyright 2014 Univeristy of Nottingham <http://nottingham.ac.uk>
 * @author    Barry Oosthuizen <barry.oosthuizen@nottingham.ac.uk>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

var FULLSCREENNAME = 'fullscreen';
/**
 * Constructs a new fullscreen manager.
 *
 * @namespace M.local_fullscreen.fullscreen
 * @class Fullscreen
 * @constructor
 * @extends Y.Base
 */
var FULLSCREEN = function() {
    FULLSCREEN.superclass.constructor.apply(this, arguments);
};

Y.extend(FULLSCREEN, Y.Base, {
    keypressed: false,
    floatrendered: false,
    bodynode: null,
    mainnode: null,
    fullscreentoggle: null,
    fullscreenmode: null,
    floatingfullscreentoggle: null,
    icon_classes: null,
    /**
     * Initializer for the local_fullscreen-fullscreen module
     *
     * @param {string} config
     * @returns void
     */
    initializer: function(config) { // 'config' contains the parameter values.
        this.mainnode = Y.one('#region-main'); // Get the main node.
        this.fullscreenmode = config.fullscreenmode; // Get the initial screen state from the database.
        this.bodynode = Y.one('body'); // The body node.
        this.icon_classes = 'fullscreen'; // Full screen icon to be displayed by default.

        // Check which icon (fullscreen / restore screen) should be displayed intially.
        if (this.fullscreenmode === '1') {
            this.icon_classes = 'fullscreen restore_fullscreen';
            this.fullscreenmode = true;
            this.bodynode.addClass('fullscreenmode');
        } else {
            this.fullscreenmode = false;
        }
        // Create the full screen toggle icon.
        this.fullscreentoggle = this.createFullscreenToggle();
        // Create the floating full screen toggle icon.
        this.floatingfullscreentoggle = this.createFloatingFullscreenToggle();
        // Add the full screen toggle icon as the first child of mainnode.
        this.mainnode.prepend(this.fullscreentoggle);
        // Handle on click event of the fullscreen icon.
        this.fullscreentoggle.on("click", this.toggleFullScreen, this);
        // Handle on click event of the hovering fullscreen icon.
        this.floatingfullscreentoggle.on("click", this.toggleFullScreen, this);
        // Check for ALT + b to toggle full screen mode.
        Y.one(document).on('keydown', this.toggleFullscreenViaKeydown, this);
        // Only toggle screen mode once until both keys are released.
        Y.one(document).on('keyup', this.toggleKeyPressed, this);
        // On scrolling down, show the hovering bubble with full screen / restore screen icon.
        Y.on('scroll', this.toggleFullscreenIcon, window, this);
    },
    /**
     * Create the node object for the fullscreen toggle bubble
     *
     * @returns {Object}
     */
    createFullscreenToggle: function() {
        return Y.Node.create('<div id="fullscreenpadding"><div id="fullscreen" title="' +
                M.str.local_fullscreen.togglefullscreenmode +
                '" class="' + this.icon_classes + '"></div></div>');
    },
    /**
     * Create the node object for the floating fullscreen toggle bubble
     *
     * @returns {Object}
     */
    createFloatingFullscreenToggle: function() {
        return Y.Node.create('<div id="fullscreenfloat" title="' +
                M.str.local_fullscreen.togglefullscreenmode +
                '" class="' + this.icon_classes + '"></div>');
    },
    /**
     * Render the floating full screen toggle bubble if the window is scrolled down far enough
     * Hide the floating full screen toggle bubble if the window is in responsive mode
     *
     * @returns void
     */
    toggleFullscreenIcon: function() {
        var winWidth = window.innerWidth;
        if (window.pageYOffset > 205 && winWidth >= 768) {
            if (this.floatrendered === false) {
                // Add the full screen toggle icon as the first child of the body node.
                this.bodynode.prepend(this.floatingfullscreentoggle);
                this.floatingfullscreentoggle.show();
                this.floatrendered = true;
            } else {
                this.floatingfullscreentoggle.show();
            }
        } else if (this.floatrendered === true) {
            this.floatingfullscreentoggle.hide();
        }
    },
    /**
     * Toggle between full screen and normal screen mode
     *
     * @returns void
     */
    toggleFullScreen: function() {
        if (this.fullscreenmode === true) {
            this.fullscreenmode = false;
            this.bodynode.removeClass('fullscreenmode');
            this.fullscreentoggle.one('#fullscreen').removeClass('restore_fullscreen');
            this.floatingfullscreentoggle.removeClass('restore_fullscreen');

        } else {
            this.fullscreenmode = true;
            this.bodynode.addClass('fullscreenmode');
            this.fullscreentoggle.one('#fullscreen').addClass('restore_fullscreen');
            this.floatingfullscreentoggle.addClass('restore_fullscreen');
        }
        M.util.set_user_preference('fullscreenmode', this.fullscreenmode);
    },
    /**
     * Detect whether both Ctrl + ALT + b keys have been released so that a new toggle event for screen mode may be fired
     *
     * @returns void
     */
    toggleKeyPressed: function(e) {
        if (e.ctrlKey && e.altKey && e.keyCode === 66) {
            this.keypressed = false; // Allow the keydown event for (Ctrl + Alt + b) to fire again.
        }
    },
    /**
     * Detect first key press of Ctrl + ALT + b to toggle Full screen mode
     *
     * @returns void
     */
    toggleFullscreenViaKeydown: function(e) {
        if (e.ctrlKey && e.altKey && e.keyCode === 66 && !this.keypressed) {
            this.toggleFullScreen();
            this.keypressed = true;  // Prevent sustained keydown event of (cTRL + Alt + b) toggling fullscreen mode continuosly.
        }
    }
}, {
    NAME: FULLSCREENNAME,
    ATTRS: {
        fullscreenmode: '0'
    }
});
M.local_fullscreen = M.local_fullscreen || {};
M.local_fullscreen.init_fullscreen = function(config) { // 'config' contains the parameter values.
    return new FULLSCREEN(config); // 'config' contains the parameter values.
};


}, '@VERSION@', {"requires": ["node", "event", "base"]});
