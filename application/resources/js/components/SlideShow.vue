<template>
    <div class="container">
        <h1 class="my-4">Gerenciar Slides</h1>

        <!-- Exibir mensagens de sucesso ou erro -->
        <div v-if="message" class="alert" :class="messageClass" role="alert">
            {{ message }}
        </div>

        <!-- Botão para adicionar um novo slide -->
        <button class="btn btn-success mb-3" @click="showAddModal()">Adicionar Novo Slide</button>

        <!-- Tabela para listar os slides -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="slide in slides" :key="slide.id" @dblclick="editSlide(slide)">
                    <td>
                        <div class="img-wrapper">
                            <img :src="getImageUrl(slide.caminho_imagem)" alt="Slide" width="150" @click="abrirModalImagem(slide)" style="cursor: pointer;">
                        </div>
                    </td>
                    <td>
                        <span class="badge" :class="{'badge-success': slide.ativo === 'SIM', 'badge-secondary': slide.ativo === 'NÃO'}">
                            {{ slide.ativo }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" @click="editSlide(slide)">Editar</button>
                        <button class="btn btn-danger btn-sm" @click="deleteSlide(slide.id)">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal para adicionar/editar slides -->
        <div class="modal fade" id="slideModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="isEditing">Editar Slide</h5>
                        <h5 class="modal-title" v-else>Adicionar Novo Slide</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveSlide">
                            <div class="form-group">
                                <label for="imagem">Escolha a Imagem:</label>
                                <input type="file" class="form-control-file" id="imagem" @change="onImageChange">
                                <div v-if="form.caminho_imagem" class="mt-2">
                                    <p>Imagem atual:</p>
                                    <img :src="getImageUrl(form.caminho_imagem)" alt="Slide" width="150">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Ativo:</label>
                                <input type="checkbox" class="form-check-input" data-toggle="toggle" data-style="ios" data-onstyle="primary" data-on="SIM" data-off="NÃO" id="status">
                            </div>
                            <button type="submit" class="btn btn-primary" @click.prevent="saveSlide">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para inspecionar imagem-->
        <div class="modal fade" id="imagemModal" tabindex="-1" aria-labelledby="imagemModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="imagemModalLabel">Visualização da Imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body text-center">
                <img :src="imagemSelecionada" alt="Imagem do Slide" class="img-fluid">
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
            slides: window.slideshow || [],
            form: {
                imagem: null,
                ativo: true,
                id: null,
            },
            isEditing: false,
            message: '',
            messageClass: '',
            imagemSelecionada: '',
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
            this.form = { imagem: null, ativo: true, id: null }; // Inicia como "SIM"
            $('#slideModal').modal('show');
            $('#status').bootstrapToggle('on'); // Define o toggle como "SIM" por padrão
        },
        onImageChange(e) {
            this.form.imagem = e.target.files[0];
        },
        getImageUrl(path) {
            return `/${path}`;
        },
        abrirModalImagem(slide) {
            this.imagemSelecionada = this.getImageUrl(slide.caminho_imagem);
            $('#imagemModal').modal('show');
        },
        editSlide(slide) {
            this.isEditing = true;
            this.form = { ...slide };
            this.form.ativo = slide.ativo === 'SIM';

            $('#slideModal').modal('show');
            $('#status').bootstrapToggle(slide.ativo === 'SIM' ? 'on' : 'off'); // Ajusta o estado do toggle
        },
        saveSlide() {
            let formData = new FormData();
            this.form.ativo = $('#status:checked').val() ? 'SIM': 'NÃO';
            formData.append('imagem', this.form.imagem);
            formData.append('ativo', this.form.ativo); // "SIM" ou "NÃO"

            if (this.isEditing) {
                formData.append('_method', 'PUT');
                axios.post(`/slides/update/${this.form.id}`, formData)
                    .then(response => {
                        this.message = 'Slide atualizado com sucesso!';
                        this.messageClass = 'alert-success';
                        this.refreshSlides();
                        $('#slideModal').modal('hide');
                    })
                    .catch(error => {
                        this.message = 'Erro ao atualizar o slide.';
                        this.messageClass = 'alert-danger';
                    });
            } else {
                axios.post('/slides/store', formData)
                    .then(response => {
                        this.message = 'Slide adicionado com sucesso!';
                        this.messageClass = 'alert-success';
                        this.refreshSlides();
                        $('#slideModal').modal('hide');
                    })
                    .catch(error => {
                        this.message = 'Erro ao adicionar o slide.';
                        this.messageClass = 'alert-danger';
                    });
            }
        },
        deleteSlide(id) {
            if (confirm('Tem certeza que deseja excluir este slide?')) {
                axios.post(`/slides/delete/${id}`)
                    .then(response => {
                        this.message = 'Slide excluído com sucesso!';
                        this.messageClass = 'alert-success';
                        this.refreshSlides();
                    })
                    .catch(error => {
                        this.message = 'Erro ao excluir o slide.';
                        this.messageClass = 'alert-danger';
                    });
            }
        },
        refreshSlides() {
            axios.get('/slides/getSlides')
                .then(response => {
                    this.slides = response.data;                        
                });
            // axios.reload('/slides/celotex');
        }
    }
}
</script>