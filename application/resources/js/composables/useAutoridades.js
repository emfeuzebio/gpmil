import {ref, onMounted, onUnmounted} from 'vue';

export function useAutoridades() {

const autoridades = ref([]);

const form = ref({
    id: ref(null),
    diretor_id: ref(null),
    respondendo_id: ref(null),
    nome: ref(''),
    cargo: ref(''),
    respondendo: ref(''),
    caminho_imagem: null,
});
const isEditing = ref(false);
const loading = ref(true);

const message = ref('');
const messageClass = ref('');

const edit = (autoridade) => {
    isEditing.value = true;
    form.value = { ...autoridade };
    getPessoas();
    $('#autoridadeModal').modal('show');

}

const save = async () => {
    let formData = new FormData();
    formData.append('nome', form.value.nome);
    formData.append('cargo', form.value.cargo);
    formData.append('respondendo', form.value.respondendo);
    formData.append('caminho_imagem', form.value.caminho_imagem);

    if (isEditing.value) {
        formData.append('_method', 'PUT');
        axios
            .post(`/autoridades/${form.value.id}/update`, formData)
            .then(response => {
                message.value = 'Autoridade atualizda com sucesso!';
                messageClass.value = 'alert-success';
                loadAutoridades();
                $('#autoridadeModal').modal('hide');
            })
            .catch(error => {
                message.value = 'Erro ao atualizar autoridade';
                messageClass.value = 'alert-danger';
            });
    }
}


const loadAutoridades = () => {
    axios
        .get('/autoridades/getAutoridades')
        .then(response => {
            autoridades.value = response.data;
        })
        .catch(e => {
            console.error(e);
        })
        .finally(() => {
            setTimeout(() => {
                loading.value = false;
            });
        });
}

return { edit, save, loadAutoridades, loading, form, autoridades }
}