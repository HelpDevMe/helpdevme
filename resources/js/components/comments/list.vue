<template>
  <section>
    <p v-if="typing" class="text-muted ellipsis">Alguém está digitando um comentário</p>
    <Item
      v-for="(comment, index) in comments"
      :comment="comment"
      :question="question"
      :key="index"
    />
  </section>
</template>
<script>
import Item from './item';

export default {
	props: ['question', 'comments'],
	data() {
		return {
			channel: `comments.${this.question.id}`,
			timeOut: undefined,
			typing: false
		};
	},
	components: {
		Item
	},
	created() {
		Echo.private(`${this.channel}.private`)
			.listen('PrivateCommentSent', response => {
				const { post } = response;

				this.comments.push(post);
			})
			.listenForWhisper('typing', e => {
				this.typing = e.typing;

				clearTimeout(this.timeOut);

				this.timeOut = setTimeout(() => {
					this.typing = false;
				}, 900);
			});
	}
};
</script>
