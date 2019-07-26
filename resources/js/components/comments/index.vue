<template>
  <section>
    <p class="small">{{ comments.length }} resposta(s)</p>
    <List :question="question" :comments="comments" />
    <Create v-if="$userId != question.user_id" @create="createComment" :question="question" />
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
	mounted() {
		axios.get(`/api/comments/${this.question.id}`).then(res => {
			this.comments = res.data.comments;
		});
	}
};
</script>

