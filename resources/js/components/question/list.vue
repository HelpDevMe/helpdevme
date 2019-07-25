<template>
  <section>
    <Item v-for="(question, index) in questions" :question="question" :key="index" />
  </section>
</template>
<script>
import Item from './item';
export default {
	data() {
		return {
			questions: []
		};
	},
	components: {
		Item
	},
	created() {
		Echo.channel('newquestions')
			.listen('NewQuestionsEvent', response => {
				const { question } = response;

				this.questions.push(question);
			})
			.listenForWhisper('typing', e => {
				console.log('typing');
			});
	}
};
</script>
