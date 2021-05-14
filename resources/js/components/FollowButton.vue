<template>
    <div class="container">
         <button class="btn btn-primary ml-4 pb-4" @click="followUser" v-text="buttonText" > Follow</button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'followId'],
        mounted() {
            console.log('Component mounted.')
        },

        data: function () {
            return {
                status:this.followId
            }
        },

        methods: {
            followUser() {
               axios.post('/follow/' + this.userId,
                { headers: { "Content-Type": "application/json" } } )
                .then(response => {
                    this.status = !this.status;
                    alert( response.data );

                })
                .catch( errors => {
                    if (errors.response.status == 401) {
                            window.location = '/login';
                        }
                } );
            }
        },
        
        computed: {
            buttonText() {
                return (this.status) ? 'Unfollow': 'follow';
            }
        }
    }
</script>
