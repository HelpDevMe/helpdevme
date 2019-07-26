<template>
  <section>
    <p class="small">{{ comments.length }} resposta(s)</p>
    <List v-if="$userId" :question="question" :comments="comments" />
    <Create v-if="canComment" @create="createComment" :question="question" />
  </section>
</template>
<script>
import List from './list';
import Create from './create';

export default {
	props: ['question'],
	data() {
		return {
			comments: []
		};
	},
	components: {
		List,
		Create
	},
	methods: {
		createComment: function(comment) {
			this.comments.push(comment);
		}
	},
	computed: {
		canComment: function() {
			return (this.$userId != this.question.user_id) && this.question.status == 0;
		}
	},
	mounted() {
		axios.get(`/api/comments/${this.question.id}`).then(res => {
			this.comments = res.data.comments;
		});
	}
};
</script>

