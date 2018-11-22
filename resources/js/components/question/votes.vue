<template>
  <div class="d-flex flex-column align-items-center justify-content-center">
    <button class="btn btn-sm btn-link" @click="upvote">Up</button>
    <input type="number" readonly class="form-control-plaintext py-0 text-center" v-model="votes">
    <button class="btn btn-sm btn-link" @click="downvote">Down</button>
  </div>
</template>

<script>
export default {
  props: ['question', 'initi-votes'],
  data() {
    return {
      votes: this.initiVotes
    }
  },
  methods: {
    upvote() {
      this.request(1);
    },
    downvote() {
      this.request(0);
    },
    request(vote) {
      axios
        .patch('/api/questions/' + this.question.id, {
          vote: vote
        })
        .then(response => {
          this.votes = response.data.votes;
        });
    }
  }
}
</script>