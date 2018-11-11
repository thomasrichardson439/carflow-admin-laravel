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
import Navigo from 'navigo';
import carsShow from './pages/cars_show.js';

let router = new Navigo(null, false);

router.on('/admin/cars/:id', function() {
    carsShow();
    console.log('qwe');
});

router.on('/admin/cars/1', function() {
    console.log('qwe2');
});

router.resolve();