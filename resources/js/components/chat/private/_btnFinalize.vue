<template>
  <!-- Finalização da Questão -->
  <div class="form-group" v-if="!iFinished && talk.question.status == 2">
    <a :href="'/' + talk.question.slug + '/finalize'" class="btn btn-warning">Finalizar Questão</a>
  </div>
</template>

<script>
export default {
  props: ["iFinished", "talk"]
};
</script>
