<template>
  <!-- Fim da Finalização da Questão -->
  <div v-if="iFinished">
    <div class="card text-white bg-warning mb-3">
      <div class="card-body">
        <h5 class="card-title">Você finalizou essa questão!</h5>
        <p
          class="card-text"
        >Esperamos que tudo esteja bem e {{ opposite.name }} também finalize. Caso contrário ambos poderão solicitiar o processo de arbitragem.</p>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-sm btn-outline-light">Solicitar Arbitragem</button>
        <button type="button" class="btn btn-sm btn-success">Continuar Trabalhando</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["iFinished", "opposite"]
};
</script>
