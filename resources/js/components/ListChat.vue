<template>
  <div class="list-group">
    <div
      class="list-group-item list-group-item-action flex-column align-items-start"
      v-for="talk in talks"
      :key="talk.id"
    >
      <a :href="'/talks/' + talk.id" class="d-flex">
        <img
          class="img-fluid avatar"
          width="25"
          style="height: 25px;"
          :src="'/storage/img/avatars/' + talk.opposite.avatar"
          :alt="talk.opposite.name"
          :title="talk.opposite.name"
        />
        <div class="ml-2">
          <p>
            <span>Conversa com</span>
            <span>{{ talk.opposite.name }}</span>
          </p>
          <small class="text-muted">{{ talk.created_at }}</small>
        </div>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      talks: []
    };
  },
  mounted() {
    axios.get("/api/talks").then(res => {
      this.talks = res.data.talks.map(talk => {
        talk.opposite =
          this.$userId == talk.user.id ? talk.receiver : talk.user;
        return talk;
      });
    });
  }
};
</script>