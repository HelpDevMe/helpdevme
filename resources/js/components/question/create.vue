<template>
    <div class="card mb-5 shadow">
        <div class="card-body">
            <form @submit.prevent="addQuestion">
                <div class="form-group">
                    <input type="text" class="form-control" name="title" v-model="title" placeholder="Como podemos te ajudar?" required/>
                </div>
                <div class="form-group">
                    <textarea name="body" class="form-control" v-model="body" placeholder="Pergunta" required></textarea>
                </div>
                <div class="form-group">
                    <multiselect v-model="tags" tag-placeholder="Adicione isto como nova tag" placeholder="Pesquise ou adicione uma tag" label="title" track-by="id" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
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
        components: {
            Multiselect
        },
        data () {
            return {
                title: undefined,
                body: undefined,
                tags: [],
                options: []
            }
        },
        methods: {
            addTag (newTag) {
                console.log('add tag')
                axios
                    .post('/api/tags', {
                        title: newTag
                    })
                    .then(response => {
                        let tag = response.data.tag;
                        
                        this.options.push(tag);
                        this.tags.push(tag);
                    });
            },
            listTags () {
                axios
                    .get('/api/tags')
                    .then(response => {
                        this.options = response.data.tags;
                    });
            },
            addQuestion () {
                axios
                    .post('/api/questions', {
                        title: this.title,
                        body: this.body,
                        tags: this.tags.map(tag => tag.id)
                    })
                    .then(response => {
                        console.log('addQuestion response', response);
                    });
            }
        },
        mounted () {
            this.listTags();
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
