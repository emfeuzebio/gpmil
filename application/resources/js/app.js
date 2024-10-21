import './bootstrap';

import { createApp } from 'vue';

import Atividades from './components/Atividades.vue';
import SlideShow from './components/SlideShow.vue';
import Autoridades from './components/Autoridades.vue';
import Celotex from './components/Celotex.vue';
import Aniversariantes from './components/Aniversariantes.vue';
import Guarnicao from './components/Guarnicao.vue';

const app = createApp({});

app.component('atividades', Atividades);
app.component('slideshow', SlideShow);
app.component('autoridades', Autoridades);
app.component('celotex', Celotex);
app.component('aniversariantes', Aniversariantes);
app.component('guarnicao', Guarnicao);

app.mount('#app');
