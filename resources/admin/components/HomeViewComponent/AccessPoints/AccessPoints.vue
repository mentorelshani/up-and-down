<script>
    export default {
        data() {
            return {
                details: {
                    active:true,
                },
                search:{},
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
            a:function() {
                swal({
                    title:'Deleted!',
                    text:'Row has been deleted.',
                    type:'success',
                    customClass: 'sweetalert-lg'
                });
            }
        }
    }

</script>

<template src="../../templates/accessPoints.html">
</template>