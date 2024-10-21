<template>
  <div class="row">
    <div class="col-md-6">
      <div class="autoridade" id="autoridade-1">
        <img :src="autoridade1img" class="icone" />
        <div class="conteudo-autoridade" id="conteudo-autoridade-1">
          <figure>
            <img :src="autoridade1foto" alt="" />
          </figure>
          <p class="grad">{{ autoridade1grad }}</p>
          <p class="militar">{{ autoridade1nome }}</p>
          <p class="cargo">{{ autoridade1cargo }}</p>
          <hr />
          <p class="destino">DESTINO</p>
          <select v-model="autoridade1destino" :class="getSelectClass(autoridade1destino)" class="destdiretor">
            <option value="--">--</option>
            <option class="prontonaom" value="pronto">PRONTO NO QGEX</option>
            <option class="despacho" value="despachoexterno">DESPACHO EXTERNO</option>
            <option class="despacho" value="despachointerno">DESPACHO INTERNO</option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="autoridade" id="autoridade-2">
        <img :src="autoridade2img" class="icone" />
        <div class="conteudo-autoridade" id="conteudo-autoridade-2">
          <figure>
            <img :src="autoridade2foto" alt="" />
          </figure>
          <p class="grad">{{ autoridade2grad }}</p>
          <p class="militar">{{ autoridade2nome }}</p>
          <p class="cargo">{{ autoridade2cargo }}</p>
          <hr />
          <p class="destino">DESTINO</p>
          <select v-model="autoridade2destino" :class="getSelectClass(autoridade2destino)" class="destsubdiretor">
            <option value="--">--</option>
            <option class="prontonaom" value="pronto">PRONTO NO QGEX</option>
            <option class="despacho" value="despachoexterno">DESPACHO EXTERNO</option>
            <option class="despacho" value="despachointerno">DESPACHO INTERNO</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Autoridade 1
const autoridade1img = ref('');
const autoridade1foto = ref('');
const autoridade1grad = ref('');
const autoridade1nome = ref('');
const autoridade1cargo = ref('');
const autoridade1destino = ref('--');

// Autoridade 2
const autoridade2img = ref('');
const autoridade2foto = ref('');
const autoridade2grad = ref('');
const autoridade2nome = ref('');
const autoridade2cargo = ref('');
const autoridade2destino = ref('--');

// Função para carregar autoridades da API
const carregaAutoridades = async () => {
  try {
    const response = await axios.get('/autoridades/getAutoridades');
    const autoridades = response.data;
    const baseUrl = 'vendor/img/celotex/pgrads/';

    // Atualizar dados da Autoridade 1
    autoridade1img.value = `${baseUrl}${autoridades[0].pgrad_id}.png`;
    autoridade1foto.value = autoridades[0].foto;
    autoridade1grad.value = autoridades[0].pgrad.sigla;
    autoridade1nome.value = autoridades[0].nome_guerra;
    autoridade1cargo.value = autoridades[0].funcao.descricao;

    // Atualizar dados da Autoridade 2
    autoridade2img.value = `${baseUrl}${autoridades[1].pgrad_id}.png`;
    autoridade2foto.value = autoridades[1].foto;
    autoridade2grad.value = autoridades[1].pgrad.sigla;
    autoridade2nome.value = autoridades[1].nome_guerra;
    autoridade2cargo.value = autoridades[1].funcao.descricao;
  } catch (error) {
    console.error('Erro ao carregar autoridades:', error);
  }
};

// Função para obter a classe do select baseado na opção selecionada
const getSelectClass = (destino) => {
  switch (destino) {
    case 'pronto':
      return 'prontonaom';
    case 'despachoexterno':
    case 'despachointerno':
      return 'despacho';
    default:
      return '';
  }
};

// Carregar autoridades quando o componente for montado
onMounted(() => {
  carregaAutoridades();
});
</script>

<style>
/* Alterar a cor do 'select' conforme a opção */
.despacho {
  background-color: red;
  color: white;
}

.prontonaom {
  background-color: green;
  color: white;
}

option {
  background-color: white;
}
</style>
