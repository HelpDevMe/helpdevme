<template>
  <div>
    <!-- Proposta Recusada -->
    <div v-if="post.type==2 && post.status==1" class="text-center">
      <span class="badge badge-pill py-2 px-5 badge-danger">{{ post.body }}</span>
    </div>
    <!-- Proposta Aceita -->
    <div v-if="post.type==2 && post.status==2" class="text-center">
      <span class="badge badge-pill py-2 px-5 badge-info">{{ post.body }}</span>
    </div>
    <!-- Pagamento Efetuado -->
    <div v-if="post.type==2 && post.status==3" class="text-center">
      <span class="badge badge-pill py-2 px-5 badge-success">{{ post.body }}</span>
    </div>
    <!-- Questão Finalizada -->
    <div v-if="post.type==3 && post.status==3" class="text-center">
      <span class="badge badge-pill py-2 px-5 badge-danger">{{ post.body }}</span>
    </div>
  </div>
</template>

<script>
export default {
    props: ["post"]
};
</script>
