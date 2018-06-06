<script>
    export default {
        data() {
            return {
                showDetailsRole:false,
            }
        },

        props: {
        },

        beforeCreate() {
        },

        created() {
        },

        mounted() {
        },

        computed: {
        },

        watch: {
        },

        methods:{
            detailsRole:function() {
                this.showDetailsRole=!this.showDetailsRole;
            }
        }
    }

</script>

<template src="../../templates/roles.html">
</template>