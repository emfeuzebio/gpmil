<template>
    <div class="container">
        <h1 class="my-4">Gerenciar Slides</h1>

        <!-- Exibir mensagens de sucesso ou erro -->
        <div v-if="slideHelper.message" class="alert" :class="slideHelper.messageClass" role="alert">
            {{ message }}
        </div>

        <!-- Botão para adicionar um novo slide -->
        <button class="btn btn-success mb-3" @click="showAddModal()">Adicionar Novo Slide</button>

        <div v-if="slideHelper.loading.value" class="text-center">
            <p>Carregando slides...</p>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Tabela para listar os slides -->
        <table v-else class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="slide in slideHelper.slides.value" :key="slide.id" @dblclick="slideHelper.edit(slide)">
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
                        <button class="btn btn-primary btn-sm" @click="slideHelper.edit(slide)">Editar</button>
                        <button class="btn btn-danger btn-sm" @click="slideHelper.remove(slide.id)">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal para adicionar/editar slides -->
        <div class="modal fade" id="slideModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="slideHelper.isEditing">Editar Slide</h5>
                        <h5 class="modal-title" v-else>Adicionar Novo Slide</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="slideHelper.save">
                            <div class="form-group">
                                <label for="imagem">Escolha a Imagem:</label>
                                <input type="file" class="form-control-file" id="imagem" @change="onImageChange">
                                
                                <div v-if="slideHelper.form.value.caminho_imagem" class="mt-2">
                                    <img :src="getImageUrl(slideHelper.form.value.caminho_imagem)" alt="Slide" width="150">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Ativo:</label>
                                <input type="checkbox" class="form-check-input" v-model="slideHelper.form.ativo" data-on="SIM" data-off="NÃO" id="status">
                            </div>
                            <button type="submit" class="btn btn-primary" @click.prevent="slideHelper.save">Salvar</button>
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

<script setup>
//onmounted busca os slides
// insere na ref slides
// ref loadin = false
// componente de loading en
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useSlide } from '../composables/useSlide';

const slideHelper = useSlide()

const imagemSelecionada = ref('');

const showAddModal = () => {
    slideHelper.isEditing = true;
    slideHelper.form.value = { imagem: null, ativo: true, id: null }; // Inicia como "SIM"
    $('#slideModal').modal('show');
    $('#status').bootstrapToggle('on'); // Define o toggle como "SIM" por padrão
};

const onImageChange = (e) => {
    slideHelper.form.value.imagem = e.target.files[0];
};

const getImageUrl = (path) => {
    return `/${path}`;
};

const abrirModalImagem = (slide) => {
    imagemSelecionada.value = getImageUrl(slide.caminho_imagem);
    $('#imagemModal').modal('show');
};


onMounted(() => {
    $('#status').change(() => {
        slideHelper.form.value.ativo = $('#status').prop('checked');
    });
    slideHelper.loadSlides();
});
</script>
