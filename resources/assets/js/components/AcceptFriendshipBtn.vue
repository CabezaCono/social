<template>
    <div v-if="localFriendshipStatus === 'pending'">
        <span v-text="sender.name"></span> te ha enviado un solicitud de amistad
        <button @click="acceptFriendshipRequest">Aceptar solicitud</button>
    </div>
    <div v-else>
        Tú y <span v-text="sender.name"></span> Son amigos
    </div>
</template>

<script>
    export default {
        props: {
            sender: {
                type: Object,
                required: true
            },
            friendshipRequest: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                localFriendshipStatus: this.friendshipStatus
            }
        },
        methods: {
            acceptFriendshipRequest() {
                axios.post(`/accept-friendships/${this.sender.name}`)
                    .then(res => {
                        this.localFriendshipStatus = 'accepted'
                    })
                    .catch(err => {
                        console.log(err.response.data)
                    });
            }
        }
    }
</script>

<style scoped>

</style>
