<template>
  <!-- Proposta -->
  <div v-if="post.type!=2 && post.budget" class="card bg-light mb-5">
    <div class="card-body">
      <p class="card-text">
        {{ post.body }}
        <span class="text-success">R$ {{ post.budget }}</span>
      </p>
    </div>
    <!-- Não exibir se for quem enviou a proposta -->
    <!-- Só mostrar se o usuario for quem recebeu a proposta, quem efetuou essa proposta não verá -->
    <div class="card-footer" v-if="user.id==talk.receiver_id && post.status!=3">
      <!-- Proposta NÃO aceita ainda -->
      <a
        v-if="post.status==0 || post.status==1"
        :href="'/posts/accept/' + post.id"
        class="btn btn-success"
      >Aceitar</a>
      <!-- Proposta aceita -->
      <a v-if="post.status==2" :href="'/payments/' + post.id" class="btn btn-success">Pagar</a>
      <!-- Proposta aceita OU proposta em analise -->
      <a
        v-if="post.status!=1"
        :href="'/posts/refused/' + post.id"
        class="btn btn-link btn-sm text-secondary"
      >Recusar</a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["post", "user", "talk"]
};
</script>
