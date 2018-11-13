<template>
    <div class="card mb-5 shadow">
        <div class="card-body">
            <form method="post" action="/questions" role="form">
                <input type="hidden" name="_token" :value="token.content">
                <div class="form-group">
                    <input type="text" class="form-control" name="title" placeholder="Como podemos te ajudar?" required/>
                </div>
                <div class="form-group">
                    <textarea name="body" class="form-control" placeholder="Pergunta" required></textarea>
                </div>
                <div class="form-group">
                    <multiselect v-model="value" tag-placeholder="Adicione isto como nova tag" placeholder="Pesquise ou adicione uma tag" label="title" track-by="id" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
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
<<<<<<< HEAD
    import Multiselect from 'vue-multiselect';
    
    export default {
        components: {
            Multiselect
        },
        data () {
            return {
                value: [],
                options: []
            }
        },
        methods: {
            addTag (newTag) {
                axios
                    .post('/api/tags', {
                        title: newTag
                    })
                    .then(response => {
                        let tag = response.data.tag;
                        
                        this.options.push(tag);
                        this.value.push(tag);
                    });
            },
            listTags () {
                axios
                    .get('/api/tags')
                    .then(response => {
                        this.options = response.data.tags;
                    });
            }
        },
        mounted () {
            this.listTags();
        }
=======
  import Multiselect from 'vue-multiselect';
  export default {
    components: { Multiselect },
    data () {
      return {
        selected: null,
        options: ['list', 'of', 'options'],
        token: document.head.querySelector('meta[name="csrf-token"]')
      }
>>>>>>> master
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
