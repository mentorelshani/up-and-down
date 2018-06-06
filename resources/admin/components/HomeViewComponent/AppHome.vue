<script>
    export default {
	 	data: function() {
	        return {   
                showFilter:true,
                breadcrumb:{},
	        }
	    },

	    props: {
        },

        created() {
            this.breadcrumb=this.$route;
        },

        mounted() {
            this.$store.watch(
                (state)=>{
                    return this.$store.getters.getShowFilterBy;
                },
                (val)=>{
                    this.showFilter=this.$store.getters.getShowFilterBy;
                });
        },

        filters: {
            capitalize: function (value) {
                if (!value) return ''

                value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            },

            replaceUnderLine: function (value) {
                if (!value) return ''

                value.toString()
                return value.replace('_',' ')  
            },

            replaceLine: function (value) {
                if (!value) return ''

                value.toString()
                return value.replace('-',' ')  
            }
        },   

        computed: {
        },

        watch: {
            '$route': function () {
                this.breadcrumb=this.$route;
            }
        },

        methods:{
        }

    }
</script>

<template src="./../templates/appHome.html">
</template>

<style>
</style>