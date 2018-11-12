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
import carsShow from './pages/cars_show.js';

if (/^\/admin\/cars\/\d+$/.test(window.location.pathname)) {
    carsShow();
}