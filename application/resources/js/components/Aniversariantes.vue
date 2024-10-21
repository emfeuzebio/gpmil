<template>
  <div class="aniversariante" id="aniversariante">
    <img src="../../../public/vendor/img/celotex/figuras/aniversariantes.png" class="icone">
    <h4>Aniversariantes da Semana</h4>
    <div class="conteudo-aniversariante" id="conteudo-aniversariante">
      <p v-if="!aniversariantes || aniversariantes.length === 0">Não há aniversariantes nesse mês.</p>
      <ul v-else class="datas">
        <li v-for="aniversariante in aniversariantes" :key="aniversariante.id" id="datas">
          {{ aniversariante.status === 'Reserva' ? aniversariante.pgrad.sigla + ' R1' : aniversariante.pgrad.sigla }}
          <strong> {{ aniversariante.nome_guerra }}</strong> -
          {{ formatDate(aniversariante.dt_nascimento) }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { format, parseISO } from 'date-fns';
import { ptBR } from 'date-fns/locale';

const aniversariantes = ref([]);

// Função para formatar a data
const formatDate = (date) => {
  const parsedDate = parseISO(date);
  return format(parsedDate, 'dd/MMM', { locale: ptBR });
};

// Função para buscar os aniversariantes do back-end
const fetchAniversariantes = async () => {
  try {
    const response = await axios.get('/celotex/getAniversariantes');
    aniversariantes.value = response.data;
  } catch (error) {
    console.error('Erro ao buscar aniversariantes:', error);
  }
};

// Chama a função ao montar o componente
onMounted(() => {
  fetchAniversariantes();
});
</script>

<style scoped>
/* Estilização customizada pode ser adicionada aqui */
</style>
