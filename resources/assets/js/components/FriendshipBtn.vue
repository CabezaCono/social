<template>
    <button
        @click="sendFriendshipRequest"
        dusk="request-friendship"
    >
        {{ TextBtn }}
    </button>
</template>

<script>
    export default {
        props: {
            recipient: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                TextBtn: 'Solicitar amistad'
            }
        },
        methods: {
            sendFriendshipRequest() {
                axios.post(`friendships/${this.recipient.name}`)
                    .then(res => {
                        this.TextBtn = 'Solicitud enviada'
                    })
                    .catch(err => {
                        console.log(err.response.data)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
