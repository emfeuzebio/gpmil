import { ref, onMounted } from 'vue';
import axios from 'axios';

export function useCelotex() {
  const owlnews = ref(null);
  const slides = ref([]);
  const autoridades = ref([]);
  const horaAtual = ref('');
  const dataAtual = ref('');

  function carregarBannerRotativo() {
    if (!owlnews.value) return;
    const newsOptions = {
      autoplay: true,
      loop: true,
      margin: 10,
      autoplayTimeout: 8000,
      smartSpeed: 1800,
      responsive: {
        0: { items: 1 },
        350: { items: 1 },
        490: { items: 1 },
        1000: { items: 1 },
        1200: { items: 1 }
      }
    };
    $(owlnews.value).owlCarousel(newsOptions);
  }

  function carregarInformativos() {
    axios.get('/slides/ativos').then((response) => {
      slides.value = response.data;
      carregarBannerRotativo();
    });
  }

  function carregarAutoridades() {
    axios.get('/autoridades/getAutoridades').then((response) => {
      autoridades.value = response.data;
    });
  }

  function startTime() {
    const today = new Date();
    const h = String(today.getHours()).padStart(2, '0');
    const m = String(today.getMinutes()).padStart(2, '0');
    const s = String(today.getSeconds()).padStart(2, '0');
    return `${h}:${m}:${s}`;
  }

  function carregarHora() {
    setInterval(() => {
      horaAtual.value = startTime();
    }, 500);
  }

  function carregarData() {
    const data = new Date();
    const day = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"][data.getDay()];
    const date = data.getDate();
    const month = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"][data.getMonth()];
    const year = data.getFullYear();
    dataAtual.value = `${day}, ${date} de ${month} de ${year}`;
  }

  onMounted(() => {
    carregarInformativos();
    carregarAutoridades();
    carregarHora();
    carregarData();
  });

  return {
    owlnews,
    slides,
    autoridades,
    horaAtual,
    dataAtual,
  };
}
