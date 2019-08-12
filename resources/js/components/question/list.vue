<template>
  <section>
    <p v-if="typing" class="text-muted ellipsis">Alguém está digitando uma pergunta</p>
    <Item v-for="(question, index) in news" :question="question" :key="index" />
  </section>
</template>
<script>
import { mapActions, mapState } from 'vuex';

import Item from './item';

export default {
	data() {
		return {
			timeOut: undefined,
			typing: false
		};
	},
	components: {
		Item
	},
	created() {
		Echo.private('newquestions')
			.listen('NewQuestionsEvent', response =>
				this.setQuestion(response.question)
			)
			.listenForWhisper('typing', e => {
				this.typing = e.typing;

				clearTimeout(this.timeOut);

				this.timeOut = setTimeout(() => {
					this.typing = false;
				}, 5000);
			});
	},
	methods: {
		...mapActions('questions', ['setQuestions', 'setQuestion'])
	},
	mounted() {
		this.setQuestions();
	},
	computed: {
		...mapState('questions', ['news'])
	}
};
</script>
