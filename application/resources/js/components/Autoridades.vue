<template>
    <div class="container">
        <h1 class="my-4">Autoridades</h1>

        <!-- Exibir mensagens de sucesso ou erro -->
        <div v-if="message" class="alert" :class="messageClass" role="alert">
            {{ message }}
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
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="autoridade in autoridades" :key="autoridade.id">
                    <td>
                        <img :src="autoridade.foto" alt="Autoridade" width="150">
                    </td>
                    <td>{{ autoridade.pgrad.sigla }}</td>
                    <td>{{ autoridade.nome_guerra }}</td>
                    <td>{{ autoridade.funcao.descricao }}</td>
                    <td>{{ autoridade.respondendo || 'Nenhum' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" @click="editAutoridade(autoridade)">Editar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal para editar informações -->
        <div class="modal fade" id="autoridadeModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Autoridade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveAutoridade">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" v-model="form.nome" required>
                            </div>
                            <div class="form-group">
                                <label for="cargo">Cargo:</label>
                                <input type="text" class="form-control" v-model="form.cargo" required>
                            </div>
                            <div class="form-group">
                                <label for="respondendo">Respondendo por:</label>
                                <input type="text" class="form-control" v-model="form.respondendo">
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
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
            autoridades: window.diretor || [], // Lista de autoridades
            form: {
                id: null,
                nome: '',
                cargo: '',
                respondendo: '',
                caminho_imagem: null,
            },
            message: '',
            messageClass: '',
        }
    },
    mounted() {
        this.getAutoridades(); // Carrega as autoridades no componente
    },
    methods: {
        getAutoridades() {
            axios.get('/autoridades/getAutoridades')
                .then(response => {
                    this.autoridades = response.data;
                });
        },
        getImageUrl(path) {
            return `/${path}`;
        },
        editAutoridade(autoridade) {
            this.form = { ...autoridade }; // Preenche o formulário com os dados da autoridade
            $('#autoridadeModal').modal('show'); // Exibe o modal de edição
        },
        saveAutoridade() {
            const method = this.form.id ? 'PUT' : 'POST';
            const url = this.form.id ? `/autoridades/update/${this.form.id}` : '/autoridades/store';

            axios({
                method: method,
                url: url,
                data: this.form
            })
            .then(response => {
                this.message = 'Autoridade salva com sucesso!';
                this.messageClass = 'alert-success';
                this.getAutoridades(); // Atualiza a lista após a edição
                $('#autoridadeModal').modal('hide'); // Fecha o modal
            })
            .catch(error => {
                this.message = 'Erro ao salvar a autoridade.';
                this.messageClass = 'alert-danger';
            });
        }
    }
}
</script>
