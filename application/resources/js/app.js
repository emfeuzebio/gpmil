import './bootstrap';

import { createApp } from 'vue';

import Atividades from './components/Atividades.vue';
import SlideShow from './components/SlideShow.vue';

const app = createApp({});

app.component('atividades', Atividades);
app.component('slideshow', SlideShow);

app.mount('#app');
