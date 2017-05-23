<template>
    <button type="button" class="btn btn-default" aria-label="Favorite" @click="toggle">

        <span :class="classes" aria-hidden="true"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
            }
        },

        computed: {
            classes() {
                return ['glyphicon', this.active ? 'glyphicon-heart red' : 'glyphicon-heart-empty']
            },

            endpoint() {
                return '/replies/' + this.reply.id +'/favorites'
            }
        },

        methods:{
            toggle() {
                this.active ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint);
                this.active = true;
                this.count ++;
            },

            destroy() {
                axios.delete(this.endpoint);
                this.active = false;
                this.count --;
            }
        }
    }
</script>