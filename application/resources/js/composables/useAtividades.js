import { ref, onMounted, onUnmounted } from 'vue';

export function useAtividades() {

const atividades = ref([]);
const form = ref({
    nome: ref(''),
    local: ref(''),
    data_hora: ref(''),
    descricao: ref(''),
    dh_ini: ref(''),
    dh_fim: ref(''),
    ativo: ref(true),
    id: ref(null),
});
const isEditing = ref(false);
const loading = ref(true);

const message = ref('');
const messageClass = ref('');

const edit = (atividade) => {
    isEditing.value = true;
    form.value = { ...atividade };
    form.value.ativo = atividade.ativo === "SIM" ? "SIM" : "NÃO";

    $('#atividadeModal').modal('show');
    $('#status').bootstrapToggle(atividade.ativo === "SIM" ? "on" : "off"); // Ajusta o estado do toggle
};
const save = () => {
    let formData = new FormData();
    formData.append('nome', form.value.nome);
    formData.append('local', form.value.local);
    formData.append('data_hora', form.value.data_hora);
    formData.append('descricao', form.value.descricao);
    formData.append('dh_ini', form.value.dh_ini);
    formData.append('dh_fim', form.value.dh_fim);
    formData.append('ativo', form.value.ativo ? 'SIM': 'NÃO'); // "SIM" ou "NÃO"

    if (isEditing.value) {
        formData.append('_method', 'PUT');
        axios
            .post(`/atividades/update/${form.value.id}`, formData)
            .then(response => {
                console.log('chegou aqui', );
                message.value = 'Atividade atualizada com sucesso!';
                messageClass.value = 'alert-success';
                loadAtividades();
                $('#atividadeModal').modal('hide');
            })
            .catch(error => {
                message.value = 'Erro ao atualizar a atividade.';
                messageClass.value = 'alert-danger';
            });
    } else {
        axios
            .post('/atividades/store', formData)
            .then(response => {
                message.value = 'Atividade adicionada com sucesso!';
                messageClass.value = 'alert-success';
                loadAtividades();
                $('#atividadeModal').modal('hide');
            })
            .catch(error => {
                message.value = 'Erro ao adicionar a atividade.';
                messageClass.value = 'alert-danger';
            });
    }
};

const remove = (id) => {
    if (confirm('Tem certeza que deseja excluir esta atividade?')) {
        axios.post(`/atividades/delete/${id}`)
            .then(response => {
                message.value = 'Atividade excluída com sucesso!';
                messageClass.value = 'alert-success';
                loadAtividades();
            })
            .catch(error => {
                message.value = 'Erro ao excluir a atividade.';
                messageClass.value = 'alert-danger';
            });
    }
};
const loadAtividades = () => {
    axios.get('/atividades/getAtividades')
        .then(response => {
            atividades.value = response.data;
        })
        .catch(e => {
            console.error(e);
        })
        .finally(() => {
            setTimeout(()=>{
                loading.value = false;
            }, 1)
        });
};

return { edit, save, remove, loadAtividades, atividades, form, loading }
}