import './bootstrap';

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import '../css/app.css'

window.Alpine = Alpine
Alpine.plugin(persist)
Alpine.start()

