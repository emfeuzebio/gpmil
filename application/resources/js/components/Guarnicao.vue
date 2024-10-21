<template>
    <div class="guarnicao" id="guarnicao">
      <img src="../../../public/vendor/img/celotex/figuras/guarnicao.png" class="icone" alt="Guarnição de Serviço">
      <h4>Guarnição de Serviço</h4>
      <div class="conteudo-guarnicao" id="conteudo-guarnicao">
        <div class="row">
          <div class="col-md-12">
            <p class="titulo">Permanência</p>
            <select v-model="selectedPermanencia" class="militares">
              <option value="">Selecione</option>
              <option v-for="pessoa in guarnicao.permanencia" :key="pessoa.nome_guerra" :value="pessoa.nome_guerra">
                {{ pessoa.sigla }} - {{ pessoa.nome_guerra }}
              </option>
            </select>
          </div>
        </div>
  
        <div class="row">
          <div class="col-md-12">
            <p class="titulo">Auxiliar</p>
            <select v-model="selectedAuxiliar" class="militares">
              <option value="">Selecione</option>
              <option v-for="pessoa in guarnicao.auxiliar" :key="pessoa.nome_guerra" :value="pessoa.nome_guerra">
                {{ pessoa.sigla }} - {{ pessoa.nome_guerra }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const guarnicao = ref({ permanencia: ref([]), auxiliar: ref([]) });
  const selectedPermanencia = ref('');
  const selectedAuxiliar = ref('');
  
  // Função para buscar os dados da guarnição do back-end
  const fetchGuarnicao = async () => {
    try {
      const response = await axios.get('/celotex/getGuarnicao');
      guarnicao.value = response.data;
    } catch (error) {
      console.error('Erro ao buscar guarnição:', error);
    }
  };
  
  // Chama a função ao montar o componente
  onMounted(() => {
    fetchGuarnicao();
  });
  </script>
  
  <style scoped>
  /* Adicione estilos customizados aqui */
  </style>
  