<template>
  <!-- Post -->
  <div v-if="post.type!=2 && !post.budget" :class="user.id==post.user_id ? 'text-right' : ''">
    <img
      v-if="user.id!=post.user_id"
      width="25"
      class="img-fluid"
      :src="'/storage/img/avatars/' + opposite.avatar"
      v-bind:alt="opposite.name"
      v-bind:title="opposite.name"
    />
    <span
      class="badge badge-pill py-2 px-3"
      :class="(user.id!==post.user_id)?'badge-secondary':'badge-primary'"
    >{{ post.body }}</span>
  </div>
</template>

<script>
export default {
  props: ["user", "post", "opposite"]
};
</script>
