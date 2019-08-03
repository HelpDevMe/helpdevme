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
import { mapActions } from 'vuex';

import Item from './item';

export default {
	props: ['question', 'comments'],
	data() {
		return {
			timeOut: undefined,
			typing: false
		};
	},
	components: {
		Item
	},
	methods: {
		...mapActions('questions', ['setComment'])
	},
	created() {
		Echo.private(`comments.${this.question.id}.private`)
			.listen('PrivateCommentSent', response => this.setComment(response.post))
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
