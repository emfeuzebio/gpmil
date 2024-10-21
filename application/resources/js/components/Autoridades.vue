<template>
    <div class="container">
        <h1 class="my-4">Autoridades</h1>

        <!-- Exibir mensagens de sucesso ou erro -->
        <div v-if="autoridadesHelper.message" class="alert" :class="autoridadesHelper.messageClass" role="alert">
            {{ autoridadesHelper.message }}
        </div>

        <div v-if="autoridadesHelper.loading.value" class="text-center">
            <p>Carregando slides...</p>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Tabela para listar o Diretor e Sub-Diretor -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>P/Grad</th>
                    <th>Nome</th>
                    <th>Função</th>
                    <th>Respondendo</th>
                    <!-- <th>Ações</th> -->
                </tr>
            </thead>
            <tbody>
                <tr v-for="autoridade in autoridadesHelper.autoridades.value" :key="autoridade.id">
                    <td>
                        <img :src="autoridade.foto" alt="Autoridade" width="150">
                    </td>
                    <td>{{ autoridade.pgrad.sigla }}</td>
                    <td>{{ autoridade.nome_guerra }}</td>
                    <td>{{ autoridade.funcao.descricao }}</td>
                    <td>{{ autoridade.respondendo || 'Nenhum' }}</td>
                    <!-- <td>
                        <button class="btn btn-primary btn-sm" @click="autoridadesHelper.edit(autoridade)">Editar</button>
                    </td> -->
                </tr>
            </tbody>
        </table>

        <!-- Modal para editar informações -->
        <div class="modal fade" id="autoridadeModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="autoridadesHelper.isEditing">Editar Autoridade</h5>
                        <h5 class="modal-title">Editar Diretor e Respondendo</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="autoridadesHelper.save">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="diretor_id" class="form-label">Diretor</label>
                                    <select v-model="autoridadesHelper.form.diretor_id" id="diretor_id" name="diretor_id" class="form-control" required>
                                        <option v-for="autoridade in autoridadesHelper.autoridades.value" :key="autoridade.id" :value="autoridade.id">
                                            {{ autoridade.nome_guerra }}
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="respondendo_id" class="form-label">Respondendo</label>
                                    <select v-model="autoridadesHelper.form.respondendo_id" id="respondendo_id" name="respondendo_id" class="form-control">
                                        <option :value="null">Nenhum</option>
                                        <option v-for="autoridade in autoridadesHelper.autoridades.value" :key="autoridade.id" :value="autoridade.id">
                                            {{ autoridade.nome_guerra }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearForm">Fechar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import { useAutoridades } from '../composables/useAutoridades';

// Definindo estados reativos
const autoridadesHelper = useAutoridades(); // Lista de autoridades

const showAddModal = () => {
    autoridadesHelper.isEditing = true;
    autoridadesHelper.form.value = { nome: '', cargo: '', respondendo: '' }
    $('#autoridadeModal').modal('show')
}




// Carrega autoridades quando o componente é montado
onMounted(() => {
    autoridadesHelper.loadAutoridades();
});



</script>
