<template>
  <section>
    <p class="small">{{ comments.length }} resposta(s)</p>
    <List v-if="$userId" :question="question" :comments="comments" />
    <Create v-if="canComment" :question="question" />
  </section>
</template>
<script>
import { mapGetters } from 'vuex';

import List from './list';
import Create from './create';

export default {
	props: ['question'],
	components: {
		List,
		Create
	},
	computed: {
		...mapGetters('questions', ['getComments']),
		canComment: function() {
			return this.$userId != this.question.user_id && this.question.status == 0;
		},
		comments: function() {
			return this.getComments(this.question.id) || [];
		}
	}
};
</script>

