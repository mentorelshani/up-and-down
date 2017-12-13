<script>
    export default {
 		data: function() {
            return {
                show__address_block:false,
                show__accessPoint_block:false,
                show__accessPoint_addEdit_block:false,

                //Config entry main data
                show__section_config_entry:false,
            }
        },

        beforeCreate() {

        },

        created() {
            // console.log(this.$store.getters.doneTodos);
        },

        mounted() {

        },

        computed: {
            getUser:  function() {
                return this.$store.getters.getUser
            }
        },

        methods: {
            show__info_address: function() {
                this.show__address_block = !this.show__address_block;
                this.$store.commit('setUser', {
                    qmimi:10,
                    TVSH:2,
                    Total:12
                });

            },
            show__info_accessPoint: function() {
                this.show__accessPoint_block = !this.show__accessPoint_block;
                console.log (this.$store.getters.getUser);
            },
            show__info_accessPoint_addEdit: function() {
                this.show__accessPoint_addEdit_block = !this.show__accessPoint_addEdit_block;

            }
        },
    }
</script>

<template src="./templates/entry_details.html">

</template>

<style>
	
</style>