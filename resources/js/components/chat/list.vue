<template>
  <div class="list-group">
    <a
      class="list-group-item list-group-item-action flex-column align-items-start"
      v-for="talk in talks"
      :key="talk.id"
      :href="'/talks/' + talk.id"
    >
      <div class="d-flex align-items-center">
        <img
          class="img-fluid avatar"
          width="25"
          style="height: 25px;"
          v-if="talk.opposite.avatar"
          :src="'/storage/img/avatars/' + talk.opposite.avatar"
          :alt="talk.opposite.name"
          :title="talk.opposite.name"
        />
        <i v-else class="fas fa-user-circle fa-2x"></i>
        <div class="ml-3 text-truncate">
          <h6 class="mb-1">Conversa com {{ talk.opposite.name }}</h6>
          <small class="text-muted">{{ talk.created_at }}</small>
        </div>
      </div>
    </a>
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
		axios.get('/api/talks').then(res => {
			this.talks = res.data.talks.map(talk => {
				talk.opposite =
					this.$userId == talk.user.id ? talk.receiver : talk.user;
				return talk;
			});
		});
	}
};
</script>
