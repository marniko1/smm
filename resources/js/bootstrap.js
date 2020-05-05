window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });


// jQuery-UI
// require('jquery-ui/ui/widgets/accordion.js');
// require('jquery-ui/ui/widgets/autocomplete.js');
// require('jquery-ui/ui/widgets/button.js');
// require('jquery-ui/ui/widgets/checkboxradio.js');
// require('jquery-ui/ui/widgets/controlgroup.js');
// require('jquery-ui/ui/widgets/datepicker.js');
// require('jquery-ui/ui/widgets/dialog.js');
// require('jquery-ui/ui/widgets/draggable.js');
// require('jquery-ui/ui/widgets/droppable.js');
// require('jquery-ui/ui/widgets/menu.js');
// require('jquery-ui/ui/widgets/mouse.js');
// require('jquery-ui/ui/widgets/progressbar.js');
// require('jquery-ui/ui/widgets/resizable.js');
// require('jquery-ui/ui/widgets/selectable.js');
// require('jquery-ui/ui/widgets/selectmenu.js');
// require('jquery-ui/ui/widgets/slider.js');
// require('jquery-ui/ui/widgets/sortable.js');
// require('jquery-ui/ui/widgets/spinner.js');
// require('jquery-ui/ui/widgets/tabs.js');
// require('jquery-ui/ui/widgets/tooltip.js');


// DataTables
// window.JSZip = require('jszip');
// // require('jszip');  // won't work like this
// require('pdfmake');
require('datatables');
require('datatables.net-bs4');
// require('datatables.net-buttons');
// require('datatables.net-fixedheader');
// require('datatables.net-responsive');
// require('datatables.net-select');
// require( 'datatables.net-buttons/js/buttons.colVis.js' )(); // Column visibility
// require( 'datatables.net-buttons/js/buttons.html5.js' )();  // HTML 5 file export
// require( 'datatables.net-buttons/js/buttons.flash.js' )();  // Flash file export
// require( 'datatables.net-buttons/js/buttons.print.js' )();  // Print view button