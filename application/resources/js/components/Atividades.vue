<template>
    <div class="container">
        <h1 class="my-4">Gerenciar Atividades</h1>

        <!-- Exibir mensagens de sucesso ou erro -->
        <div v-if="message" class="alert" :class="messageClass" role="alert">
            {{ message }}
        </div>

        <!-- Botão para adicionar uma nova atividade -->
        <button class="btn btn-success mb-3" @click="showAddModal()">Adicionar Nova Atividade</button>

        <!-- Tabela para listar as atividades -->
        <table class="table table-bordered">
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
                <tr v-for="atividade in atividades" :key="atividade.id" @dblclick="editAtividade(atividade)">
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
                        <button class="btn btn-primary btn-sm" @click="editAtividade(atividade)">Editar</button>
                        <button class="btn btn-danger btn-sm" @click="deleteAtividade(atividade.id)">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal para adicionar/editar atividades -->
        <div class="modal fade" id="atividadeModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="isEditing">Editar Atividade</h5>
                        <h5 class="modal-title" v-else>Adicionar Nova Atividade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveAtividade">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" data-toggle="tooltip" title="Nome da atividade" v-model="form.nome" required>
                            </div>
                            <div class="form-group">
                                <label for="local">Local:</label>
                                <input type="text" class="form-control" data-toggle="tooltip" title="Local da atividade" v-model="form.local" required>
                            </div>
                            <div class="form-group">
                                <label for="data_hora">Data-Hora:</label>
                                <input type="datetime-local" class="form-control" data-toggle="tooltip" title="Data e Hora da atividade" v-model="form.data_hora" required>
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição:</label>
                                <textarea class="form-control" data-toggle="tooltip" title="Descrição e/ou orientações para atividade" v-model="form.descricao" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="dh_ini">Início:</label>
                                <input type="datetime-local" class="form-control" data-toggle="tooltip" title="Data e Hora para o inicio da publicação" v-model="form.dh_ini" required>
                            </div>
                            <div class="form-group">
                                <label for="dh_fim">Fim:</label>
                                <input type="datetime-local" class="form-control" data-toggle="tooltip" title="Data e Hora para o fim da publicação" v-model="form.dh_fim" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Ativo:</label>
                                <input type="checkbox" class="form-check-input" data-toggle="toggle" data-style="ios" data-onstyle="primary" data-on="SIM" data-off="NÃO" id="status">
                            </div>
                            <button type="submit" class="btn btn-primary" @click.prevent="saveAtividade">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            atividades: window.atividades || [], // Passando atividades do Laravel para Vue.js
            form: {
                nome: '',
                local: '',
                data_hora: '',
                descricao: '',
                dh_ini: '',
                dh_fim: '',
                ativo: true,
                id: null,
            },
            isEditing: false,
            message: '',
            messageClass: '',
        }
    },
    mounted() {
        $('#status').change(() => {
            this.form.ativo = $('#status').prop('checked');
        });
    },
    methods: {
        showAddModal() {
            this.isEditing = false;
            this.form = { nome: '', local: '', data_hora: '', descricao: '', dh_ini: '', dh_fim: '', ativo: true, id: null }; // Inicia com valores padrão
            $('#atividadeModal').modal('show');
            $('#status').bootstrapToggle('on'); // Define o toggle como "SIM" por padrão
        },
        editAtividade(atividade) {
            this.isEditing = true;
            this.form = { ...atividade };

            this.form.ativo = atividade.ativo === 'SIM';

            $('#atividadeModal').modal('show');
            $('#status').bootstrapToggle(atividade.ativo === 'SIM' ? 'on' : 'off'); // Ajusta o estado do toggle
        },
        saveAtividade() {
            let formData = new FormData();
            this.form.ativo = $('#status:checked').val() ? 'SIM': 'NÃO';
            formData.append('nome', this.form.nome);
            formData.append('local', this.form.local);
            formData.append('data_hora', this.form.data_hora);
            formData.append('descricao', this.form.descricao);
            formData.append('dh_ini', this.form.dh_ini);
            formData.append('dh_fim', this.form.dh_fim);
            formData.append('ativo', this.form.ativo); // "SIM" ou "NÃO"

            if (this.isEditing) {
                formData.append('_method', 'PUT');
                axios.post(`/atividades/update/${this.form.id}`, formData)
                    .then(response => {
                        this.message = 'Atividade atualizada com sucesso!';
                        this.messageClass = 'alert-success';
                        this.refreshAtividades();
                        $('#atividadeModal').modal('hide');
                    })
                    .catch(error => {
                        this.message = 'Erro ao atualizar a atividade.';
                        this.messageClass = 'alert-danger';
                    });
            } else {
                axios.post('/atividades/store', formData)
                    .then(response => {
                        this.message = 'Atividade adicionada com sucesso!';
                        this.messageClass = 'alert-success';
                        this.refreshAtividades();
                        $('#atividadeModal').modal('hide');
                    })
                    .catch(error => {
                        this.message = 'Erro ao adicionar a atividade.';
                        this.messageClass = 'alert-danger';
                    });
            }
        },
        deleteAtividade(id) {
            if (confirm('Tem certeza que deseja excluir esta atividade?')) {
                axios.post(`/atividades/delete/${id}`)
                    .then(response => {
                        this.message = 'Atividade excluída com sucesso!';
                        this.messageClass = 'alert-success';
                        this.refreshAtividades();
                    })
                    .catch(error => {
                        this.message = 'Erro ao excluir a atividade.';
                        this.messageClass = 'alert-danger';
                    });
            }
        },
        refreshAtividades() {
            axios.get('/atividades/getAtividades')
                .then(response => {
                    this.atividades = response.data;                        
                });
        },
        formatDataHora(dataHora) {
            if (!dataHora) return '';
            const date = new Date(dataHora);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Mês começa em 0
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${day}/${month}/${year} - ${hours}:${minutes}`;
        }
    }
};
</script>