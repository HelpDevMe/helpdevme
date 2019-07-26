<template>
  <div>
    <div v-if="comment.type == 1" class="py-3 border-top comment">
      <a :href="`/users/${comment.user_id}`">
        <span class="mr-2">
          <img
            v-if="comment.user.avatar"
            width="25"
            class="img-fluid avatar"
            :src="'/storage/img/avatars/' + comment.user.avatar"
            v-bind:alt="comment.user.name"
            v-bind:title="comment.user.name"
          />
          <i v-else class="fas fa-user-circle fa-2x"></i>
        </span>
        <span>{{ comment.user.name }}</span>
      </a>
      <span>{{ comment.body }}</span>
      <span v-if="comment.budget" class="badge badge-success">{{ comment.budget }}</span>
      <div v-if="$userId == question.user_id" class="d-flex pt-3">
        <div v-if="comment.budget && $userId == comment.talk.receiver_id">
          <div v-if="question.status == 0">
            <button
              type="button"
              class="btn btn-sm btn-success"
              data-toggle="modal"
              v-b-modal="`#confirmModal${ comment.id }`"
            >Aceitar</button>
            <!-- Modal -->
            <div
              class="modal fade"
              :id="`confirmModal${ comment.id }`"
              tabindex="-1"
              role="dialog"
              :ariaLabelledby="`confirmModal${ comment.id }`"
              aria-hidden="true"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" :id="`confirmModalLabel${ comment.id }`">
                      Você está prestes a aceitar uma
                      proposta para sua pergunta
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- <div class="font-weight-bold">{{ comment.talk.user.name }}</div> -->
                    <div>{{ comment.body }}</div>
                    <div class="text-success">{{ comment.budget }}</div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a :href="`/posts/accept${comment.id}`" class="btn btn-success">Aceitar</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <a
            :href="`/payments/${comment.id}`"
            class="btn btn-success"
            v-else-if="question.status == 1"
          >Pagar</a>
        </div>
        <a :href="`/talks/${comment.talk_id}`" class="btn btn-sm text-secondary">Conversar</a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	props: ['comment', 'question']
};
</script>
