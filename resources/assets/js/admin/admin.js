import './components/masonry';
import './components/charts';
import './components/popover';
import './components/scrollbar';
import './components/sidebar';
import './components/skycons';
import './components/chat';
import './components/datatable';
import './components/datepicker';
import './components/email';
import './components/fullcalendar';
import './components/googleMaps';
import './components/utils';
import './components/entityViewPage';
import './components/select2';
import carsShowCreate from './pages/cars_show_create.js';
import receiptsShow from './pages/receipts_show.js';
import carsIndex from "./pages/cars_index";

if (/^\/admin\/cars$/.test(window.location.pathname)) {
    carsIndex();
}

if (/^\/admin\/cars\/\d+$/.test(window.location.pathname)) {
    carsShowCreate(false);
}

if (/^\/admin\/cars\/create$/.test(window.location.pathname)) {
    carsShowCreate(true);
}

if (/^\/admin\/receipts\/\d+$/.test(window.location.pathname)) {
    receiptsShow();
}