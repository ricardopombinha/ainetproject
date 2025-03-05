import './bootstrap';

import Alpine from 'alpinejs';

import './menu';

import.meta.glob([
    '../img/**',
]);


window.Alpine = Alpine;

Alpine.start();
