<template>
    <div class="card mb-5 shadow">
        <div class="card-body">
            <form>
                <div class="form-group">
                    <input type="text" class="form-control" name="title" placeholder="Como podemos te ajudar?" required/>
                </div>
                <div class="form-group">
                    <textarea name="body" class="form-control" placeholder="Pergunta" required></textarea>
                </div>
                <div class="form-group">
                    <multiselect
                        v-model="selected"
                        :multiple="true"
                        :options="options">
                    </multiselect>
                </div>
                <div class="form-row justify-content-end">
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-success btn-block">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import Multiselect from 'vue-multiselect';
  export default {
    components: { Multiselect },
    data () {
      return {
        selected: null,
        options: ['list', 'of', 'options']
      }
    }
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>