import { ref, onMounted, onUnmounted } from "vue";

export function useSlide() {

const slides = ref([]);
const form = ref({
  imagem: ref(null),
  ativo: ref(true),
  id: ref(null),
});
const isEditing = ref(false);
const loading = ref(true);

const message = ref('');
const messageClass = ref('');

  const edit = (slide) => {
    isEditing.value = true;
    form.value = { ...slide };
    form.value.ativo = slide.ativo === "SIM" ? "SIM" : "NÃO";

    $("#slideModal").modal("show");
    $("#status").bootstrapToggle(slide.ativo === "SIM" ? "on" : "off");
  };

  const save = () => {
    let formData = new FormData();
    formData.append("imagem", form.value.imagem);
    formData.append("ativo", form.value.ativo ? "SIM" : "NÃO");

    if (isEditing.value) {
      formData.append("_method", "PUT");
      axios
        .post(`/slides/update/${form.value.id}`, formData)
        .then(() => {
          message.value = "Slide atualizado com sucesso!";
          messageClass.value = "alert-success";
          loadSlides();
          $("#slideModal").modal("hide");
        })
        .catch(() => {
          message.value = "Erro ao atualizar o slide.";
          messageClass.value = "alert-danger";
        });
    } else {
      axios
        .post("/slides/store", formData)
        .then(() => {
          message.value = "Slide adicionado com sucesso!";
          messageClass.value = "alert-success";
          loadSlides();
          $("#slideModal").modal("hide");
        })
        .catch(() => {
          message.value = "Erro ao adicionar o slide.";
          messageClass.value = "alert-danger";
        });
    }
  };

  const remove = (id) => {
    if (confirm("Tem certeza que deseja excluir este slide?")) {
      axios
        .post(`/slides/delete/${id}`)
        .then(() => {
          message.value = "Slide excluído com sucesso!";
          messageClass.value = "alert-success";
          loadSlides();
        })
        .catch(() => {
          message.value = "Erro ao excluir o slide.";
          messageClass.value = "alert-danger";
        });
    }
  };

  const loadSlides = function(){
    axios.get('/slides/getSlides')
        .then(response => {
            slides.value = response.data;
        })
        .catch((e)=>{
        })
        .finally(() => {
          setTimeout(()=>{
            loading.value = false;

          }, 1000)
        });
    };

  return { edit, save, remove, slides, isEditing, loadSlides, loading, form };
}
