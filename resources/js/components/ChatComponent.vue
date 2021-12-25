<template>
    <div>
        <ul>
            <li v-for="(message, key) in messages" :key="key">
                <strong>{{ message.name }}</strong>
                {{ message.message }}
            </li>
        </ul>
        <input v-model="text" />
        <button @click="postMessage" :disabled="!textExists">Submit</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            text: '',
            messages: []
        };
    },
    computed: {
        textExists() {
            return this.text.length > 0;
        }
    },
    created() {
        this.getMessages();
        Echo.private('test').listen('MessageSentEvent', e => {
            this.messages.push({
                message: e.message.message,
                user: e.user
            });
        });
    },
    methods: {
        getMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },
        postMessage(message) {
            axios.post('/messages', { message: this.text }).then(response => {
                this.text = '';
            });
        }
    }
};
</script>