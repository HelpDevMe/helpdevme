<template>
  <section>
    <p v-if="typing" class="text-muted ellipsis">Alguém está digitando</p>
    <Item v-for="(question, index) in questions" :question="question" :key="index" />
  </section>
</template>
<script>
import Item from './item';
export default {
	data() {
		return {
			timeOut: undefined,
			typing: false,
			questions: []
		};
	},
	components: {
		Item
	},
	created() {
		Echo.private('newquestions')
			.listen('NewQuestionsEvent', response => {
				const { question } = response;

				this.questions.push(question);
			})
			.listenForWhisper('typing', e => {
				this.typing = e.typing;

				clearTimeout(this.timeOut);

				this.timeOut = setTimeout(() => {
					this.typing = false;
				}, 5000);
			});
	}
};
</script>
