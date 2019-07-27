<template>
  <section>
    <p class="small">{{ commentsItems.length }} resposta(s)</p>
    <List v-if="$userId" :question="question" :comments="commentsItems" />
    <Create v-if="canComment" @create="createComment" :question="question" />
  </section>
</template>
<script>
import List from './list';
import Create from './create';

export default {
	props: ['question', 'comments'],
	data() {
		return {
			commentsItems: []
		};
	},
	components: {
		List,
		Create
	},
	methods: {
		createComment: function(comment) {
			this.commentsItems.push(comment);
		}
	},
	computed: {
		canComment: function() {
			return this.$userId != this.question.user_id && this.question.status == 0;
		}
	},
	mounted() {
		this.commentsItems = this.comments || [];
	}
};
</script>

