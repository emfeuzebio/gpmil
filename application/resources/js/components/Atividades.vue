<template>
    <div class="container">
        <h1 class="my-4">Gerenciar Atividades</h1>
        <!-- Exibir mensagens de sucesso ou erro -->
        <div v-if="atividadesHelper.message" class="alert" :class="atividadesHelper.messageClass" role="alert">
            {{ atividadesHelper.message }}
        </div>

        <!-- Botão para adicionar uma nova atividade -->
        <button class="btn btn-success mb-3" @click="showAddModal()">Adicionar Nova Atividade</button>

        <div v-if="atividadesHelper.loading.value" class="text-center">
            <p>Carregando slides...</p>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Tabela para listar as atividades -->
        <table v-else class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Local</th>
                    <th>Data-Hora</th>
                    <th>Descrição</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="atividade in atividadesHelper.atividades.value" :key="atividade.id" @dblclick="atividadesHelper.edit(atividade)">
                    <td>{{ atividade.nome }}</td>
                    <td>{{ atividade.local }}</td>
                    <td>{{ formatDataHora(atividade.data_hora) }}</td>
                    <td>{{ atividade.descricao }}</td>
                    <td>{{ formatDataHora(atividade.dh_ini) }}</td>
                    <td>{{ formatDataHora(atividade.dh_fim) }}</td>
                    <td>
                        <span class="badge" :class="{'badge-success': atividade.ativo === 'SIM', 'badge-secondary': atividade.ativo === 'NÃO'}">
                            {{ atividade.ativo }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" @click="atividadesHelper.edit(atividade)">Editar</button>
                        <button class="btn btn-danger btn-sm" @click="atividadesHelper.remove(atividade.id)">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal para adicionar/editar atividades -->
        <div class="modal fade" id="atividadeModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="atividadesHelper.isEditing">Editar Atividade</h5>
                        <h5 class="modal-title" v-else>Adicionar Nova Atividade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="atividadesHelper.save">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" data-toggle="tooltip" title="Nome da atividade" v-model="atividadesHelper.form.value.nome" required>
                            </div>
                            <div class="form-group">
                                <label for="local">Local:</label>
                                <input type="text" class="form-control" data-toggle="tooltip" title="Local da atividade" v-model="atividadesHelper.form.value.local" required>
                            </div>
                            <div class="form-group">
                                <label for="data_hora">Data-Hora:</label>
                                <input type="datetime-local" class="form-control" data-toggle="tooltip" title="Data e Hora da atividade" v-model="atividadesHelper.form.value.data_hora" required>
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição:</label>
                                <textarea class="form-control" data-toggle="tooltip" title="Descrição e/ou orientações para atividade" v-model="atividadesHelper.form.value.descricao" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="dh_ini">Início:</label>
                                <input type="datetime-local" class="form-control" data-toggle="tooltip" title="Data e Hora para o inicio da publicação" v-model="atividadesHelper.form.value.dh_ini" required>
                            </div>
                            <div class="form-group">
                                <label for="dh_fim">Fim:</label>
                                <input type="datetime-local" class="form-control" data-toggle="tooltip" title="Data e Hora para o fim da publicação" v-model="atividadesHelper.form.value.dh_fim" required>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="status">Ativo:</label>
                                <input type="checkbox" class="form-check-input" v-model="atividadesHelper.form.ativo" data-on="SIM" data-off="NÃO" id="status">
                            </div>
                            <button type="submit" class="btn btn-primary" @click.prevent="atividadesHelper.save">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAtividades } from '../composables/useAtividades';

const atividadesHelper = useAtividades();


const showAddModal = () => {
    atividadesHelper.isEditing = true;
    atividadesHelper.form.value = { nome: '', local: '', data_hora: '', descricao: '', dh_ini: '', dh_fim: '', ativo: true, id: null }; // Inicia com valores padrão
    $('#atividadeModal').modal('show');
    $('#status').bootstrapToggle('on'); // Define o toggle como "SIM" por padrão
};

const formatDataHora = (dataHora) => {
    if (!dataHora) return '';
    const date = new Date(dataHora);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mês começa em 0
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    
    return `${day}/${month}/${year} - ${hours}:${minutes}`;
}

onMounted(() => {
    $('#status').change(() => {
        atividadesHelper.form.value.ativo = $('#status').prop('checked');
    });
    atividadesHelper.loadAtividades();
});
</script>